<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Api;

interface RentalQuoteRepositoryInterface
{

    /**
     * create Rental order by products
     * @param string $email - Customer Email
     * @param int $addressId
     * @param \Thomas\RentalCompatible\Api\Data\RentalItemInterface[] $items
     * @param int $storeId
     * @param string|null $payment
     * @param string|null $shipping
     * @return string
     * @throws \Magento\Framework\Exception\InputException
     */
    public function createRentalOrder(
        $email,
        $addressId,
        array $items,
        int $storeId,
        $payment = "",
        $shipping = ""
    );

    /**
     * get rental options
     *
     * @param int $productId
     * @return \Thomas\RentalCompatible\Api\Data\RentalOptionInterface[]|null
     */
    public function getRentalOptions($productId);

}

