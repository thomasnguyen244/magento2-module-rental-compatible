<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Model;

use Thomas\RentalCompatible\Api\Data\RentalItemInterface;
use Magento\Framework\Api\AbstractExtensibleObject;
use \Magento\Framework\Api\AttributeValueFactory;

/**
 * Class RentalItem
 *
 * @package Thomas\RentalCompatible\Model
 */
class RentalItem extends AbstractExtensibleObject implements RentalItemInterface
{

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $attributeValueFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->_get(self::PRODUCT_SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku($sku)
    {
        return $this->setData(self::PRODUCT_SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getRentalPrice()
    {
        return $this->_get(self::RENTAL_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setRentalPrice($rentalPrice)
    {
        return $this->setData(self::RENTAL_PRICE, $rentalPrice);
    }

    /**
     * @inheritDoc
     */
    public function getRentalFrom()
    {
        return $this->_get(self::RENTAL_FROM);
    }

    /**
     * @inheritDoc
     */
    public function setRentalFrom($rentalFrom)
    {
        return $this->setData(self::RENTAL_FROM, $rentalFrom);
    }

    /**
     * @inheritDoc
     */
    public function getRentalTo()
    {
        return $this->_get(self::RENTAL_TO);
    }

    /**
     * @inheritDoc
     */
    public function setRentalTo($rentalTo)
    {
        return $this->setData(self::RENTAL_TO, $rentalTo);
    }

    /**
     * @inheritDoc
     */
    public function getRentalFromUtc()
    {
        return $this->_get(self::RENTAL_FROM_UTC);
    }

    /**
     * @inheritDoc
     */
    public function setRentalFromUtc($rentalFromUtc)
    {
        return $this->setData(self::RENTAL_FROM_UTC, $rentalFromUtc);
    }

    /**
     * @inheritDoc
     */
    public function getRentalToUtc()
    {
        return $this->_get(self::RENTAL_TO_UTC);
    }

    /**
     * @inheritDoc
     */
    public function setRentalToUtc($rentalToUtc)
    {
        return $this->setData(self::RENTAL_TO_UTC, $rentalToUtc);
    }

    /**
     * @inheritDoc
     */
    public function getRentalStart()
    {
        return $this->_get(self::RENTAL_START);
    }

    /**
     * @inheritDoc
     */
    public function setRentalStart($rentalStart)
    {
        return $this->setData(self::RENTAL_START, $rentalStart);
    }

    /**
     * @inheritDoc
     */
    public function getRentalHours()
    {
        return $this->_get(self::RENTAL_HOURS);
    }

    /**
     * @inheritDoc
     */
    public function setRentalHours($rentalHours)
    {
        return $this->setData(self::RENTAL_HOURS, $rentalHours);
    }

    /**
     * @inheritDoc
     */
    public function getHasTime()
    {
        return $this->_get(self::HAS_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setHasTime($hasTime)
    {
        return $this->setData(self::HAS_TIME, $hasTime);
    }

    /**
     * @inheritDoc
     */
    public function getLocalPickup()
    {
        return $this->_get(self::LOCAL_PICKUP);
    }

    /**
     * @inheritDoc
     */
    public function setLocalPickup($localPickup)
    {
        return $this->setData(self::LOCAL_PICKUP, $localPickup);
    }

    /**
     * @inheritDoc
     */
    public function getRentalOptions()
    {
        return $this->_get(self::RENTAL_OPTIONS);
    }

    /**
     * @inheritDoc
     */
    public function setRentalOptions($rentalOptions)
    {
        return $this->setData(self::RENTAL_OPTIONS, $rentalOptions);
    }

    /**
     * @inheritDoc
     */
    public function getProductOptions()
    {
        return $this->_get(self::PRODUCT_OPTIONS);
    }

    /**
     * @inheritDoc
     */
    public function setProductOptions($productOptions)
    {
        return $this->setData(self::PRODUCT_OPTIONS, $productOptions);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getQty()
    {
        return $this->_get(self::QTY);
    }

    /**
     * @inheritDoc
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

