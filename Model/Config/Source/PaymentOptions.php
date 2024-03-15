<?php
/**
 * Copyright © 2019 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Thomas\RentalCompatible\Model\Config\Source;

use Magento\Payment\Helper\Data;

/**
 * Class PaymentOptions
 *
 * @package Thomas\RentalCompatible\Model\Config\Source
 */
class PaymentOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var Data
     */
    protected $paymentData;

    protected $_options = null;

    /**
     * Constructor
     *
     * @param Data $paymentData
     */
    public function __construct(
        Data $paymentData
    ) {
        $this->paymentData = $paymentData;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = [];
            $paymentMethods = $this->paymentData->getPaymentMethods();

            foreach ($paymentMethods as $code => $paymentMethod) {
                if (isset($paymentMethod['title'])) {
                    $label = $paymentMethod['title'];
                } else {
                    try {
                        $label = $this->paymentData->getMethodInstance($code)->getConfigData('title', null);
                    } catch(\Exception $e) {
                        $label = "";
                    }
                }
                if ($label) {
                    $this->_options[$code] = [
                        'label' => $label,
                        'value' => $code
                    ];
                }
            }

            usort($this->_options, function ($a, $b) {
                return strcmp($a['value'], $b['value']);
            });
        }
        return $this->_options;
    }

}
