<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Model;

use Thomas\RentalCompatible\Api\Data\RentalOptionValueInterface;
use Magento\Framework\Api\AbstractExtensibleObject;
use \Magento\Framework\Api\AttributeValueFactory;

class RentalOptionValue extends AbstractExtensibleObject implements RentalOptionValueInterface
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
    public function getValue()
    {
        return $this->_get(self::VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
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
        \Thomas\RentalCompatible\Api\Data\RentalOptionValueExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

