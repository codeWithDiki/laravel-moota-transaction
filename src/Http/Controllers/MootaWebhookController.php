<?php 

namespace Codewithdiki\LaravelMootaTransaction\Http\Controllers;

use Codewithdiki\LaravelMootaTransaction\Concerns\HasMootaTransaction;

class MootaWebhookController extends Controller
{
    public function retrieve_webhook(\Illuminate\Http\Request $request)
    {
        $transactionable_model = config("moota-transaction.transactionable_model");

        if(empty($transactionable_model)){
            return "Server Error";
        }

        if(!in_array(HasMootaTransaction::class ,class_uses($transactionable_model))){
            return "Server Error";
        }

        $invoice_number_column = $transactionable_model::invoiceNumberColumn();

        if(empty($invoice_number_column)){
            return "Server Error";
        }

        $transaction = $transactionable_model::query()
        ->where([
            $invoice_number_column => $request->post('invoice_number')
        ])
        ->first();

        if(empty($transaction)){
            return "Resource not found!";
        }

        if(config("moota-transaction.mode", 'testing') == "production"){
            if($request->ip() != "128.199.173.138"){
                return "You are not authorized.";
            }
        }

        $transaction->setTrxStatus($request->post("status"));

        return "OK";
    }
}