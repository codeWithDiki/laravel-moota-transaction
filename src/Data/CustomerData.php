<?php

namespace Codewithdiki\LaravelMootaTransaction\Data;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    public string $name;

    public string $email;

    public ?string $phone;
}