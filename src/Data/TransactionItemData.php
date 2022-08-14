<?php

namespace Codewithdiki\LaravelMootaTransaction\Data;

use Spatie\DataTransferObject\DataTransferObject;

class TransactionItemData extends DataTransferObject
{
    public string $name;

    public int $qty;

    public int $price;

    public string $sku;

    public ?string $image_url;
}