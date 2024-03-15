<?php
/**
 * RentalCompatible Helper
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Helper;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Directory\Model\CountryFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Model\Address\CustomerAddressDataProvider;
use Magento\Quote\Api\ShipmentEstimationInterface;
use Magento\Quote\Api\Data\AddressInterface as QuoteAddress;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Registry;
use Magento\Framework\App\ObjectManager;
use Magento\Sales\Model\OrderNotifier;
use Thomas\RentalCompatible\Model\Cart;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Quote\Model\ResourceModel\Quote\Item as ResourceQuoteItem;

/**
 * Class Data
 *
 * @package Thomas\RentalCompatible\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $defaultShipping = 'flatrate_flatrate';
    protected $defaultPayment = 'checkmo';

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;

    /**
     * @var DateTime
     */
    protected $_dateTime;

    /**
     * @var \Magento\Checkout\Model\CompositeConfigProvider
     */
    protected $configProvider;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * @var CountryFactory
     */
    private $countryFactory;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quote;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var CustomerAddressDataProvider
     */
    protected $customerAddressData;

    /**
     * @var ShipmentEstimationInterface
     */
    protected $shipmentEstimation;

    /**
     * @var QuoteAddress
     */
    protected $quoteAddress;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable
     */
    protected $configurable;

    /**
     * @var \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable
     */
    protected $resourceConfigurable;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected  $registry;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Quote\Model\QuoteManagement
     */
    protected $quoteManagement;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var \Magento\Sales\Model\Order\Email\Sender\OrderSender
     */
    protected $orderSender;

    /**
     * @var ResourceQuoteItem
     */
    protected $quoteItemResource;

    /**
     * @var \Magento\Catalog\Model\Product\OptionFactory
     */
    protected $optionFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Quote\Model\QuoteFactory $quote,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        AddressRepositoryInterface $addressRepository,
        CountryFactory $countryFactory,
        SessionFactory $customerSessionFactory,
        CustomerAddressDataProvider $customerAddressData,
        ShipmentEstimationInterface $shipmentEstimation,
        QuoteAddress $quoteAddress,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $resourceConfigurable,
        Image $imageHelper,
        \Magento\Catalog\Model\Product\OptionFactory $optionFactory,
        Registry $registry,
        Cart $cart,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        DateTime $dateTime,
        ResourceQuoteItem $quoteItemResource
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->orderSender = $orderSender;
        $this->addressRepository = $addressRepository;
        $this->countryFactory = $countryFactory;
        $this->customerSession = $customerSessionFactory->create();
        $this->customerAddressData = $customerAddressData;
        $this->shipmentEstimation = $shipmentEstimation;
        $this->quoteAddress = $quoteAddress;
        $this->configurable = $configurable;
        $this->resourceConfigurable = $resourceConfigurable;
        $this->imageHelper = $imageHelper;
        $this->registry = $registry;
        $this->objectManager = ObjectManager::getInstance();
        $this->optionFactory = $optionFactory;
        $this->cart = $cart;
        $this->_dateTime = $dateTime;
        $this->_localeDate = $localeDate;
        $this->quoteItemResource = $quoteItemResource;

        parent::__construct($context);
    }

    /**
     * get timezone value
     *
     * @param string
     * @return string
     */
    public function getTimezoneDateTime($dateTime = "today")
    {
        if($dateTime === "today" || !$dateTime){
            $dateTime = $this->_dateTime->gmtDate();
        }

        $today = $this->_localeDate
            ->date(
                new \DateTime($dateTime)
            )->format('Y-m-d H:i:s');
        return $today;
    }

    /**
     * get current store id
     *
     * @param int|null $storeId
     * @return int
     */
    public function getCurrentStoreId($storeId = null)
    {
        $store = $this->storeManager->getStore($storeId);
        $storeId = $store->getStoreId();
        return $storeId;
    }

    /**
     * get current currency code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getCurrentCurrencyCode($storeId = null)
    {
        return $this->storeManager->getStore($storeId)->getCurrentCurrencyCode();
    }

    /**
     * @param string $key
     * @param int|mixed|null $store
     * @param mixed|null $default
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig($key, $store = null, $default = null)
    {
        $store = $this->storeManager->getStore($store);

        $result = $this->scopeConfig->getValue(
            'thomasrentalsystem/create_order/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        if ($default != null) {
            return $result ? $result : $default;
        } else {
            return $result;
        }
    }

    /**
     * check is enabled module feature
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->getConfig("enable");
    }

    /**
     * get default payment method
     *
     * @return string
     */
    public function getDefaultPayment()
    {
        $payment = $this->getConfig("default_payment");
        return !empty($payment) ? $payment : $this->defaultPayment;
    }

    /**
     * get default shipping method
     *
     * @return string
     */
    public function getDefaultShipping()
    {
        $shipping = $this->getConfig("default_shipping");
        return !empty($shipping) ? $shipping : $this->defaultShipping;
    }

    /**
     * create order programmatically
     * @param mixed $orderInfo
     * @param int|null $storeId
     * @return mixed|array
     */
    public function createOrder($orderInfo, $storeId = null)
    {
        $result = [];
        $store = $this->storeManager->getStore($storeId);
        $storeId = $store->getStoreId();
        $orderInfo['store_id'] = $storeId;
        $websiteId = $store->getWebsiteId();
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($orderInfo['email']); // load customer by email address

        if (!$customer->getId()) {
            return;
        }
        $orderInfo = $this->verifyOrderInfo($orderInfo, $customer);
        $customerEmail = $customer->getEmail();

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quote->create(); //Create object of quote
        $quote->setStore($store); //set store for our quote
        /* for registered customer */
        $customer = $this->customerRepository->getById($customer->getId());
        $quote->setCurrency();
        $quote->assignCustomer($customer); //Assign quote to customer

        $productOption = $this->objectManager->create(\Magento\Catalog\Model\Product\Option::class);

        //add items in quote
        $dataOptions = [];
        foreach ($orderInfo['items'] as $item) {
            try {
                $product = $this->productRepository->getById($item['product']);
                $options = $productOption->getProductOptions($product);
                foreach ($options as $option) {
                    $option = $option;
                    if ($option->getType() == "file" && isset($item['options'])) {
                        $optionId = $option->getId();
                        unset($item['options'][$optionId]);
                    }
                }
                $dataOptions[$item['product']] = isset($item['additional_options']) ? $item['additional_options'] : [];
                $buyRequest = new \Magento\Framework\DataObject($item);
                $quote->addProduct($product, $buyRequest);
            } catch (\Exception $e) {
                $result['error'][] = $e->getMessage();
            }
        }

        foreach ($quote->getAllVisibleItems() as $quoteItem) {
            $data = isset($dataOptions[$quoteItem->getProductId()]) ? $dataOptions[$quoteItem->getProductId()] : [];
            try {
                $quoteItem = $this->cart->execute($quoteItem, $data);
            } catch (\Exception $e) {
                //
                $result['error'][] = $e->getMessage();
            }
        }
        //Set Billing and shipping Address to quote
        $quote->getBillingAddress()->addData($orderInfo['billing_address']);
        $quote->getShippingAddress()->addData($orderInfo['shipping_address']);

        // set shipping method
        $quote->collectTotals()->save();
        $quote = $this->setShippingMethod($quote, $orderInfo);

        // set payment method
        $quote = $this->setPaymentMethod($quote, $orderInfo);

        // Collect Quote Totals & Save
        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals()->save();
        // Create Order From Quote Object

        try {
            $order = $this->quoteManagement->submit($quote);
            if ($order == null) throw new \Exception(__("Can not order"));
            /* for send order email to customer email id */
            if ($order && $customerEmail) {
                $order->setCustomerEmail($customerEmail);
                $this->objectManager->create(OrderNotifier::class)->notify($order);
            }
            /* get order real id from order */
            $orderId = $order ? $order->getIncrementId() : "";
            if ($orderId) {
                $result['success'] = $orderId;
                $result['orderIncrementId'] = $orderId;
                $result['orderId'] = $order->getId();
            }
        } catch (\Exception $e) {
            $result['error'][] = $e->getMessage();
        }
        return $result;
    }

    /**
     * verify order info data
     *
     * @param mixed $orderInfo
     * @param \Magento\Customer\Model\Customer|\Magento\Customer\Api\Data\CustomerInterface $customer
     * @return mixed
     */
    public function verifyOrderInfo($orderInfo, $customer)
    {
        if ($customer->getDefaultShipping()) {
            $orderInfo['shipping_address']['save_in_address_book'] = 0;
        }

        if ($customer->getDefaultBilling()) {
            $orderInfo['billing_address']['save_in_address_book'] = 0;
        }

        if (!isset($orderInfo['currency_id'])) {
            $storeId = isset($orderInfo['store_id']) ? $orderInfo['store_id'] : null;
            $currencyId = $this->getCurrentCurrencyCode($storeId);
            $orderInfo['currency_id'] = !empty($currencyId) ? $currencyId : 'USD';
        }

        return $orderInfo;
    }

    /**
     * Set shipping method
     *
     * @param mixed $quote
     * @param mixed $orderInfo
     * @return mixed
     */
    public function setShippingMethod($quote, $orderInfo)
    {
        $this->quoteAddress->setData($orderInfo['shipping_address']);
        $shippingMethods = $this->shipmentEstimation->estimateByExtendedAddress($quote->getId(), $this->quoteAddress);
        $shippingMethod = $this->getDefaultShipping();

        $isPickUp = false;
        $lowestAmount = INF;
        if ($orderInfo['shipping'] == "pickup_advanced") $isPickUp = true;
        foreach ($shippingMethods as $item) {
            if ($item->getAmount() >= $lowestAmount) continue;
            $lowestAmount = $item->getAmount();
            if ($isPickUp && $item->getCarrierCode() == 'pickup_advanced')
                $shippingMethod = $item->getCarrierCode() . '_' . $item->getMethodCode();
            if (!$isPickUp && $item->getCarrierCode() != 'pickup_advanced')
                $shippingMethod = $item->getCarrierCode() . '_' . $item->getMethodCode();
        }

        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->setShippingMethod($shippingMethod) //shipping method, please verify flat rate shipping must be enable
            ->collectShippingRates();
        return $quote;
    }

    /**
     * Set payment method
     *
     * @param mixed $quote
     * @param mixed $orderInfo
     * @return mixed
     */
    public function setPaymentMethod($quote, $orderInfo)
    {
        $paymentMethod = $this->getDefaultPayment();
        if (isset($orderInfo['payment']) && !empty($orderInfo['payment'])) {
            $paymentMethod = $orderInfo['payment']['method'];
        }
        $quote->setPaymentMethod($paymentMethod); //payment method, please verify checkmo must be enable from admin
        $quote->setInventoryProcessed(false); //decrease item stock equal to qty
        $quote->save(); //quote save
        // Set Sales Order Payment, We have taken check/money order

        $paymentData =  $orderInfo['payment'];
        $quote->getPayment()->importData($paymentData);
        return $quote;
    }

    /**
     * convert payment code
     *
     * @param string $payment
     * @return string
     */
    public function convertPaymentCode($payment)
    {
        if (!empty($payment)) {
            $payment = strtolower($payment);
            if (strpos($payment, "credit card") !== false) {
                // continue
            }
        }
        return $payment;
    }

    /**
     * convert shipping code
     *
     * @param string $shipping
     * @return string
     */
    public function convertShippingCode($shipping)
    {
        if (!empty($shipping)) {
            //write logic at here.
        }
        return $shipping;
    }

    /**
     * get customer data
     *
     * @param string|null $email
     * @param int|null $storeId
     * @return array|mixed
     */
    public function getCustomerData($email = null, $storeId = null)
    {
        $customerData = [];
        $customer = null;

        if ($email != null) {
            $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();
            $customerByEmail = $this->customerFactory->create();
            $customerByEmail->setWebsiteId($websiteId);
            $customerByEmail->loadByEmail($email);
            if (!$customerByEmail->getId()) return [];
            $customer = $this->getCustomer($customerByEmail->getId());
        }
        if ($customer && $customer->getId()) {
            $customerData = $customer->__toArray();
            $customerData['addresses'] = $this->customerAddressData->getAddressDataByCustomer($customer);

            $country = $this->objectManager->create(\Magento\Directory\Model\Country::class);
            foreach ($customerData['addresses'] as &$item) {
                $item['country_name'] = $country->load($item['country_id'])->getName();
            }
        }
        return $customerData;
    }

    /**
     * Get logged-in customer
     *
     * @param int $id
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer($id = null)
    {
        try {
            if ($id != null) {
                return $this->customerRepository->getById($id);
            }
            return $this->customerRepository->getById($this->customerSession->getCustomerId());
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * get customer by email
     *
     * @param string $email
     * @param int|null $storeId
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomerByEmail($email, $storeId = null)
    {
        $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();
        try {
            return $this->customerRepository->get($email, $websiteId);
        } catch(\Exception $e) {
            return null;
        }
    }

}
