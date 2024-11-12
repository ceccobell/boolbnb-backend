<?php

namespace App\Http\Controllers;

use Braintree\Gateway;
use Illuminate\Http\Request;

class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
    }

    public function getToken()
    {
        // Genera un client token per il frontend
        $token = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $token]);
    }

    public function makePayment(Request $request)
    {
        // Riceve il nonce dal frontend e crea una transazione
        $nonce = $request->input('payment_method_nonce');

        $result = $this->gateway->transaction()->sale([
            'amount' => '10.00', // Importo del pagamento
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            return response()->json(['success' => true, 'transaction' => $result->transaction]);
        } else {
            return response()->json(['success' => false, 'message' => $result->message]);
        }
    }
}
