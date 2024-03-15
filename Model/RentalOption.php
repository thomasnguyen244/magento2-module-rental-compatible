<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Model;

use Thomas\RentalCompatible\Api\Data\RentalOptionInterface;
use Magento\Framework\Api\AbstractExtensibleObject;
use \Magento\Framework\Api\AttributeValueFactory;

class RentalOption extends AbstractExtensibleObject implements RentalOptionInterface
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
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getRentalId()
    {
        return $this->_get(self::RENTAL_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRentalId($rentalId)
    {
        return $this->setData(self::RENTAL_ID, $rentalId);
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
    public function getOptionId()
    {
        return $this->_get(self::OPTION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOptionId($optionId)
    {
        return $this->setData(self::OPTION_ID, $optionId);
    }

    /**
     * @inheritDoc
     */
    public function getOptionTitle()
    {
        return $this->_get(self::OPTION_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setOptionTitle($optionTitle)
    {
        return $this->setData(self::OPTION_TITLE, $optionTitle);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getIsRequired()
    {
        return $this->_get(self::IS_REQUIRED);
    }

    /**
     * @inheritDoc
     */
    public function setIsRequired($isRequired)
    {
        return $this->setData(self::IS_REQUIRED, $isRequired);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(
        \Thomas\RentalCompatible\Api\Data\RentalOptionExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

