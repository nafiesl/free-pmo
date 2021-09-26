<?php

namespace App\Services\InvoiceDrafts;

/**
 * Draft Item class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Item
{
    /**
     * Invoice item description.
     *
     * @var string
     */
    public $description;

    /**
     * Invoice item amount.
     *
     * @var int
     */
    public $amount;

    /**
     * Create new invoice item.
     *
     * @param  array  $itemDetail  Detail of an invoice item.
     */
    public function __construct(array $itemDetail)
    {
        $this->description = $itemDetail['description'];
        $this->amount = $itemDetail['amount'];
    }

    /**
     * Update attribute of an invoice item.
     *
     * @param  array  $newItemData  Item attribute that will be replaced.
     * @return \App\Services\InvoiceDrafts\Item
     */
    public function updateAttribute(array $newItemData)
    {
        if (isset($newItemData['description'])) {
            $this->description = $newItemData['description'];
        }
        if (isset($newItemData['amount'])) {
            $this->amount = $newItemData['amount'];
        }

        return $this;
    }
}
