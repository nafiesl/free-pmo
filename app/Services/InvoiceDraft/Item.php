<?php

namespace App\Services\InvoiceDrafts;

/**
 * Draft Item class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Item
{
    public $description;
    public $amount;

    public function __construct(array $itemDetail)
    {
        $this->description = $itemDetail['description'];
        $this->amount = $itemDetail['amount'];
    }

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
