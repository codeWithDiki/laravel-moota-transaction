<?php

namespace Codewithdiki\LaravelMootaTransaction\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Codewithdiki\LaravelMootaTransaction\Data\GenerateTransactionData;

class LaravelMootaTransaction
{
    protected function getAPIKey() : string
    {
        return config('moota-transaction.v2_apikey', "");
    }

    protected function getMootaUrl() : string
    {
        return config('moota-transaction.moota_url', "https://app.moota.co");
    }

    public function getBanks() : ?Collection
    {
        $response = Http::withToken($this->getAPIKey())
        ->acceptJson()
        ->get("{$this->getMootaUrl()}/api/v2/bank", [
            "per_page" => 100
        ]);

        if(empty($response->json())){
            return null;
        }

        return collect($response->json("data"));
    }

    public function generateTransaction(GenerateTransactionData $generateTransactionData) : Collection|\Exception
    {
        try{
            $data = array_merge([
                'callback_url' => route('laravel-moota-transaction-webhook'),
                'increase_total_from_unique_code' => config("moota-transaction.unique_code", true),
                'with_unique_code' => config("moota-transaction.unique_code", true),
                'start_unique_code' => config("moota-transaction.unique_code_start", 1),
                'end_unique_code' => config("moota-transaction.unique_code_end", 199)
            ], $generateTransactionData->toArray());

            $response = Http::withToken($this->getAPIKey())
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->asForm()
            ->withBody(
                json_encode($data), 'application/json'
            )
            ->post("{$this->getMootaUrl()}/api/v2/contract");

            if(empty($response->json())){
                throw new \Exception("Terjadi kesalahan ketika melakukan request.");
            }

            if($response->status() != 200){
                throw new \Exception($response->json('message'));
            }

            $transactionable_model = config('moota-transaction.transactionable_model');

            $transaction = $transactionable_model::query()
            ->where($transactionable_model::invoiceNumberColumn(), $generateTransactionData->invoice_number)
            ->first();

            if(empty($transaction)){
                throw new \Exception("Transaksi tidak ditemukan!");
            }

            if($transactionable_model::trxColumn()){
                $transaction->update([
                    $transactionable_model::trxColumn() => $response->json('data.trx_id')
                ]);
            }


            return collect($response->json("data"));

        } catch(\Exception $e){
            return $e;
        }
    } 
}