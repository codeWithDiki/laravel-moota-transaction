<?php

namespace Codewithdiki\LaravelMootaTransaction\Facades;

class LaravelMootaTransaction extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return "laravel-moota-transaction";
    }
}