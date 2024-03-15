<?php
/**
 * Copyright © rental compatible All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thomas\RentalCompatible\Api\Data;

interface RentalQuoteInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Rentalquote list.
     * @return \Thomas\RentalCompatible\Api\Data\RentalItemInterface[]
     */
    public function getItems();

    /**
     * Set quote_item_id list.
     * @param \Thomas\RentalCompatible\Api\Data\RentalItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

