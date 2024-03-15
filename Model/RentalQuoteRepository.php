<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Model;

use Magento\Customer\Model\CustomerFactory;
use Thomas\RentalCompatible\Api\Data\RentalItemInterface;
use Thomas\RentalCompatible\Api\Data\RentalItemInterfaceFactory;
use Thomas\RentalCompatible\Api\Data\RentalQuoteInterface;
use Thomas\RentalCompatible\Api\Data\RentalQuoteInterfaceFactory;
use Thomas\RentalCompatible\Api\RentalQuoteRepositoryInterface;
use Thomas\RentalCompatible\Model\CreateOrderRental;
use Thomas\RentalCompatible\Helper\Data;
use Thomas\RentalCompatible\Api\Data\RentalOptionInterfaceFactory;
use Thomas\RentalCompatible\Api\Data\RentalOptionInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magenest\RentalSystem\Model\ResourceModel\RentalOption\CollectionFactory as RentalOptionCollection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class RentalQuoteRepository
 *
 * @package Thomas\RentalCompatible\Model
 */
class RentalQuoteRepository implements RentalQuoteRepositoryInterface
{

    const DEFAULT_COUNTRY_ID = "DE";

    /**
     * @var RentalItem
     */
    protected $searchResultsFactory;

    /**
     * @var RentalItemInterfaceFactory
     */
    protected $rentalItemFactory;

    /**
     * @var CreateOrderRental
     */
    protected $createOrder;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /** @var RentalOptionCollection */
    protected $rentalOptionCollection;

    /**
     * @var RentalOptionInterfaceFactory
     */
    protected $rentalOptionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $_productRepository;

    /**
     * @param CreateOrderRental $createOrder
     * @param Data $helperData
     * @param RentalItemInterfaceFactory $rentalItemFactory
     * @param RentalQuoteInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CustomerFactory $customerFactory
     * @param RentalOptionCollection $rentalOptionCollection
     * @param RentalOptionInterfaceFactory $rentalOptionFactory
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        CreateOrderRental $createOrder,
        Data $helperData,
        RentalItemInterfaceFactory $rentalItemFactory,
        RentalQuoteInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        CustomerFactory $customerFactory,
        RentalOptionCollection $rentalOptionCollection,
        RentalOptionInterfaceFactory $rentalOptionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->createOrder = $createOrder;
        $this->helperData = $helperData;
        $this->rentalItemFactory = $rentalItemFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->customerFactory = $customerFactory;
        $this->rentalOptionCollection = $rentalOptionCollection;
        $this->rentalOptionFactory = $rentalOptionFactory;
        $this->_productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function getRentalOptions($productId)
    {
        $items = $this->rentalOptionCollection->create()
            ->addFilter('product_id', $productId)
            ->getData();
        $return = [];
        if ($items) {
            foreach ($items as $itemData) {
                $rentalOption = $this->rentalOptionFactory->create();
                foreach ($itemData as $_key => $_value) {
                    $rentalOption->setData($_key, $_value);
                }
                $return[] = $rentalOption;
            }
        }
        return $return;
    }

    /**
     * @inheritDoc
     */
    public function createRentalOrder(
        $email,
        $addressId,
        array $items,
        int $storeId,
        $payment = "",
        $shipping = ""
    ) {
        $orderIncrement = "";
        try {
            $rentalProducts = $items;
            if ($rentalProducts && $email) {
                $storeId = $storeId ? (int)$storeId : 1;
                $storeId = $this->helperData->getCurrentStoreId($storeId);
                $customer = $this->helperData->getCustomerByEmail($email, $storeId);
                if ($customer && $customer->getId()) {
                    $payment = $payment ? $payment : $this->helperData->getConfig("default_payment");
                    $payment = $payment ? $payment : "cashondelivery";
                    $shipping = $shipping ? $shipping : $this->helperData->getConfig("default_shipping");
                    $shipping = $shipping ? $shipping : "flatrate_flatrate";
                    $addressData = $this->initAddressData($customer, $addressId);

                    $postCreateOrder = [
                        'email' => $customer->getEmail(),
                        'first_name' => $customer->getFirstname(),
                        'last_name' => $customer->getLastname(),
                        'items' => [],
                        'payment' => $payment,
                        'shipping' => $shipping,
                        'telephone' => isset($addressData['telephone']) ? $addressData['telephone'] : "",
                        'store_id' => $storeId,
                        'shipping_address' => $addressData,
                        'billing_address' => $addressData
                    ];
                    $paymentCode = $this->helperData->convertPaymentCode($payment);
                    if (!empty($paymentCode)) {
                        $postCreateOrder["payment"] = [];
                        $postCreateOrder["payment"]["method"] = $paymentCode;
                    }

                    $items = [];
                    /** @var \Thomas\RentalCompatible\Api\Data\RentalItemInterface $_item */
                    foreach ($rentalProducts as $_item) {
                        if ($_item->getRentalFrom() && $_item->getRentalTo()) {
                            $productId = $_item->getProductId();
                            if (!$productId && $_item->getSku()) {
                                $product = $this->getProductBySku($_item->getSku());
                                $productId = $product ? $product->getId() : 0;
                            }
                            if (!$productId) {
                                continue;
                            }
                            $fromUtc = @strtotime($_item->getRentalFrom());
                            $fromDate = date("Y-m-d H:i:s", $fromUtc);
                            $fromDateLocale = $this->helperData->getTimezoneDateTime($fromDate);
                            $fromDateLocaleTime = strtotime($fromDateLocale);

                            $toUtc = @strtotime($_item->getRentalTo());
                            $toDate = date("Y-m-d H:i:s", $toUtc);
                            $toDateLocale = $this->helperData->getTimezoneDateTime($toDate);
                            $toDateLocaleTime = strtotime($toDateLocale);

                            $duration = ($toUtc - $fromUtc) / 3600;
                            $rentalOption = $_item->getRentalOptions();
                            $optionsArray = $this->getRentalOptionsArray($rentalOption);

                            $additionalOptions = [
                                "rental_price" => (float)$_item->getRentalPrice(),
                                "rental_from" => $fromDateLocaleTime,
                                "rental_to" => $toDateLocaleTime,
                                "rental_from_utc" => $fromUtc,
                                "rental_to_utc" => $toUtc,
                                "rental_start" => $fromUtc * 1000,
                                "rental_hours" => $duration,
                                "has_time" => (int)$_item->getHasTime(),
                                "local_pickup" => (int)$_item->getLocalPickup(),
                                "options" => $optionsArray
                            ];
                            $_newItem = [
                                'product' => $productId,
                                'item' => $productId,
                                'rentfrom' => $_item->getRentalFrom(),
                                'rentto' => $_item->getRentalTo(),
                                'qty' => $_item->getQty() ? $_item->getQty() : 1,
                                'selected_configurable_option' => "",
                                'related_product' => "",
                                "rental_price" => (float)$_item->getRentalPrice(),
                                'additional_options' => $additionalOptions
                            ];
                            $items[] = $_newItem;
                        }
                    }
                    if ($items) {
                        $postCreateOrder['items'] = $items;
                        //call helper create order
                        $results = $this->helperData->createOrder($postCreateOrder, $storeId);

                        if ($results && isset($results["orderId"]) && $results["orderId"]) {
                            $this->createOrder->execute((int)$results["orderId"]);
                            $orderIncrement = isset($results["orderIncrementId"]) ? $results["orderIncrementId"] : $results["orderId"];
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not create rental order: %1',
                $exception->getMessage()
            ));
        }
        return $orderIncrement;
    }

    /**
     * init address data
     *
     * @param mixed $customer
     * @param int $addressId
     * @return array|mixed
     */
    protected function initAddressData($customer, $addressId)
    {
        $customerModel = $this->customerFactory->create();
        $addressData = [
            'firstname' => $customer ? $customer->getFirstname() : "",
            'lastname' => $customer ? $customer->getLastname() : "",
            'street' => "",
            'company' => "",
            'city' => "",
            'country_id' => self::DEFAULT_COUNTRY_ID,
            'region' => [
                "region" => "",
                "region_code" => "",
                "region_id" => 0
            ],
            'region_id' => null,
            'postcode' => "",
            'telephone' => "",
            'save_in_address_book' => 1
        ];
        try {
            $address = $customerModel->getAddressById($addressId);
            $addressData = [
                'street' => $address ? $address->getStreetLine(1) : "",
                'company' => $address ? $address->getCompany() : "",
                'city' => $address ? $address->getCity() : "",
                'country_id' => $address ? $address->getCountryId() : self::DEFAULT_COUNTRY_ID,
                'region' => [
                    "region" => "",
                    "region_code" => "",
                    "region_id" => ""
                ],
                'region_id' => $address ? $address->getRegionId() : null,
                'postcode' => $address ? $address->getPostcode() : "11-111",
                'telephone' => $address ? $address->getTelephone() : "",
                'save_in_address_book' => 1
            ];
        } catch (\Exception $e) {
            //
        }
        return $addressData;
    }

    /**
     * get rental options array
     *
     * @param mixed $optionModel
     * @return array|mixed
     */
    protected function getRentalOptionsArray($optionModel)
    {
        $optionsArray = [];
        if ($optionModel) {
            $options = $optionModel->getItems();
            foreach ($options as $_item) {
                if ($_item->getId()) {
                    $optionsArray[$_item->getId()] = $_item->getValue();
                }
            }
        }
        return $optionsArray;
    }

    /**
     * get product by sku
     *
     * @var string $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface|bool
     */
    protected function getProductBySku($sku)
    {
        try {
            return $this->_productRepository->get($sku);
        } catch (\Exception $e) {
            //
        }
        return false;
    }
}

