<?php

namespace Codewithdiki\LaravelMootaTransaction\Data;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class GenerateTransactionData extends DataTransferObject
{
    public string $invoice_number;

    public string $payment_method_id;

    public int $amount;

    public string $type;

    public string $expired_date;

    public string $description;

    public CustomerData $customer;

    /** @var TransactionItemData[] */
    #[CastWith(ArrayCaster::class, itemType: TransactionItemData::class)]
    public array $items;
}