<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Api\Data;

interface RentalOptionInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    const ID = 'id';
    const RENTAL_ID = 'rental_id';
    const PRODUCT_ID = 'product_id';
    const OPTION_ID = 'option_id';
    const OPTION_TITLE = 'option_title';
    const TYPE = 'type';
    const IS_REQUIRED = 'is_required';

    /**
     * Get id
     * @return int|null
     */
    public function getId();

    /**
     * Set id
     * @param int $id
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setId($id);

    /**
     * Get id
     * @return int|null
     */
    public function getRentalId();

    /**
     * Set id
     * @param int $rentalId
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setRentalId($rentalId);

    /**
     * Get product id
     * @return int|null
     */
    public function getProductId();

    /**
     * Set product id
     * @param int $productId
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setProductId($productId);

    /**
     * Get option id
     * @return int|null
     */
    public function getOptionId();

    /**
     * Set option id
     * @param int $optionId
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setOptionId($optionId);

    /**
     * Get option title
     * @return string|null
     */
    public function getOptionTitle();

    /**
     * Set option title
     * @param string $optionTitle
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setOptionTitle($optionTitle);

    /**
     * Get option type
     * @return string|null
     */
    public function getType();

    /**
     * Set option type
     * @param string $type
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setType($type);

    /**
     * Get option isRequired
     * @return int|null
     */
    public function getIsRequired();

    /**
     * Set option isRequired
     * @param int $isRequired
     * @return \Thomas\RentalCompatible\Rentalquote\Api\Data\RentalOptionInterface
     */
    public function setIsRequired($isRequired);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Thomas\RentalCompatible\Api\Data\RentalOptionExtensionInterface $extensionAttributes
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionInterface
     */
    public function setExtensionAttributes(
        \Thomas\RentalCompatible\Api\Data\RentalOptionExtensionInterface $extensionAttributes
    );
}
