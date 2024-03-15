<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Api\Data;

interface RentalOptionValueInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    const ID = 'id';
    const VALUE = 'value';

    /**
     * Get option id
     * @return int|null
     */
    public function getId();

    /**
     * Set option Id
     * @param int $id
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionValueInterface
     */
    public function setId($id);

    /**
     * Get option value
     * @return string|null
     */
    public function getValue();

    /**
     * Set option value
     * @param string $value
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionValueInterface
     */
    public function setValue($value);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionValueExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Thomas\RentalCompatible\Api\Data\RentalOptionValueExtensionInterface $extensionAttributes
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionInterface
     */
    public function setExtensionAttributes(
        \Thomas\RentalCompatible\Api\Data\RentalOptionValueExtensionInterface $extensionAttributes
    );
}
