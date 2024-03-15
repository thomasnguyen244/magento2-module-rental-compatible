<?php
/**
 * Copyright © 2019 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Thomas\RentalCompatible\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Payment\Helper\Data;
use Magento\Shipping\Model\Config;
use Magento\Store\Model\StoreManagerInterface;

class ShippingOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var Data
     */
    protected $paymentData;

    /**
     * @var Config
     */
    private $shippingData;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Constructor
     *
     * @param Data $paymentData
     */
    public function __construct(
        Data $paymentData,
        StoreManagerInterface $storeManager,
        Config $shippingConfig,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->shippingData = $shippingConfig;
        $this->paymentData = $paymentData;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $activeCarriers = $this->shippingData->getAllCarriers();
        $shippingmethods = array();
        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            $options = array();
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode.'_'.$methodCode;
                    $options[] = array('value'=>$code,'label'=>$method);
                }
                 $carrierTitle = $this->scopeConfig->getValue('carriers/'.$carrierCode.'/title');
            }
            $shippingmethods[] = array('value' => $options, 'label' => $carrierTitle);
        }

        return $shippingmethods;
    }
}
