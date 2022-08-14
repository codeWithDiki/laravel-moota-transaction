<?php

namespace Codewithdiki\LaravelMootaTransaction\Concerns;

trait HasMootaTransaction
{
    public static function trxColumn() : ?string
    {
        return null;
    }

    public static function invoiceNumberColumn() : string
    {
        return "invoice_number";
    }

    public function statusColumn() : string
    {
        return "status";
    }

    public function setTrxStatus(string $status) : void
    {
        $casts = config("moota-transaction.status_converter", []);

        if(!empty($casts)){
            $status = match($status){ 
                'success' => $casts['success'],
                'fail' => $casts['fail'],
                'settlement' => $casts['settlement'],
                'expire' => $casts['expire'],
                default => $status
            };
        }


        // Mengganti status transaksi
        $this->update([
            $this->statusColumn() => $status
        ]);
    }
}