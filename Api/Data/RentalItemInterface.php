<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Api\Data;

interface RentalItemInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    const LOCAL_PICKUP = 'local_pickup';
    const RENTAL_START = 'rental_start';
    const HAS_TIME = 'has_time';
    const RENTAL_PRICE = 'rental_price';
    const RENTAL_TO_UTC = 'rental_to_utc';
    const RENTAL_FROM = 'rental_from';
    const RENTAL_TO = 'rental_to';
    const RENTAL_FROM_UTC = 'rental_from_utc';
    const RENTAL_OPTIONS = 'rental_options';
    const PRODUCT_ID = 'product_id';
    const QTY = 'qty';
    const PRODUCT_SKU = 'sku';
    const RENTAL_HOURS = 'rental_hours';
    const PRODUCT_OPTIONS = 'product_options';

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setSku($sku);

    /**
     * Get rental_price
     * @return string|null
     */
    public function getRentalPrice();

    /**
     * Set rental_price
     * @param string $rentalPrice
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalPrice($rentalPrice);

    /**
     * Get rental_from
     * @return string|null
     */
    public function getRentalFrom();

    /**
     * Set rental_from
     * @param string $rentalFrom
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalFrom($rentalFrom);

    /**
     * Get rental_to
     * @return string|null
     */
    public function getRentalTo();

    /**
     * Set rental_to
     * @param string $rentalTo
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalTo($rentalTo);

    /**
     * Get rental_from_utc
     * @return string|null
     */
    public function getRentalFromUtc();

    /**
     * Set rental_from_utc
     * @param string $rentalFromUtc
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalFromUtc($rentalFromUtc);

    /**
     * Get rental_to_utc
     * @return string|null
     */
    public function getRentalToUtc();

    /**
     * Set rental_to_utc
     * @param string $rentalToUtc
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalToUtc($rentalToUtc);

    /**
     * Get rental_start
     * @return string|null
     */
    public function getRentalStart();

    /**
     * Set rental_start
     * @param string $rentalStart
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalStart($rentalStart);

    /**
     * Get rental_hours
     * @return string|null
     */
    public function getRentalHours();

    /**
     * Set rental_hours
     * @param string $rentalHours
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalHours($rentalHours);

    /**
     * Get has_time
     * @return string|null
     */
    public function getHasTime();

    /**
     * Set has_time
     * @param string $hasTime
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setHasTime($hasTime);

    /**
     * Get local_pickup
     * @return string|null
     */
    public function getLocalPickup();

    /**
     * Set local_pickup
     * @param string $localPickup
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setLocalPickup($localPickup);

    /**
     * Get rental_options
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionsInterface|null
     */
    public function getRentalOptions();

    /**
     * Set rental_options
     * @param \Thomas\RentalCompatible\Api\Data\RentalOptionsInterface $rentalOptions
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setRentalOptions($rentalOptions);

    /**
     * Get product_options
     * @return string|null
     */
    public function getProductOptions();

    /**
     * Set product_options
     * @param string $productOptions
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setProductOptions($productOptions);

    /**
     * Get product_id
     * @return int|null
     */
    public function getProductId();

    /**
     * Set product_id
     * @param int $productId
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setProductId($productId);

    /**
     * Get qty
     * @return int|null
     */
    public function getQty();

    /**
     * Set qty
     * @param int $qty
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setQty($qty);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface $extensionAttributes
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface
     */
    public function setExtensionAttributes(
        \Thomas\RentalCompatible\Api\Data\RentalItemExtensionInterface $extensionAttributes
    );

}

