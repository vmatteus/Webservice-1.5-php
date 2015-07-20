<?php

namespace Cielo;

use Cielo\Serializer\AuthorizationRequestSerializer;
use Cielo\Serializer\TransactionRequestSerializer;
use Cielo\Serializer\TransactionResponseUnserializer;

class Cielo
{
    const PRODUCTION = 'https://ecommerce.cielo.com.br/servicos/ecommwsec.do';
    const TEST = 'https://qasecommerce.cielo.com.br/servicos/ecommwsec.do';

    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * @var string
     */
    private $endpoint = Cielo::PRODUCTION;

    /**
     * @param string $id
     * @param string $key
     * @param string $endpoint
     */
    public function __construct($id, $key, $endpoint = Cielo::PRODUCTION)
    {
        if (! filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new \UnexpectedValueException('Endpoint inválido.');
        }

        $this->merchant = $this->merchant($id, $key);
        $this->endpoint = $endpoint;
    }

    /**
     * @param  string      $tokenOrNumber
     * @param  null|string $expirationYear
     * @param  null|string $expirationMonth
     * @param  int         $indicator
     * @param  null|string $cvv
     * @return Holder
     */
    public function holder(
        $tokenOrNumber,
        $expirationYear = null,
        $expirationMonth = null,
        $indicator = Holder::CVV_NOT_INFORMED,
        $cvv = null
    ) {
        if (func_num_args() == 1) {
            return new Holder($tokenOrNumber);
        }

        return new Holder($tokenOrNumber, $expirationYear, $expirationMonth, $indicator, $cvv);
    }

    /**
     * @param  string $id
     * @param  string $key
     * @return Merchant
     */
    public function merchant($id, $key)
    {
        $this->merchant = new Merchant($id, $key);

        return $this->merchant;
    }

    /**
     * @param  string      $number
     * @param  int         $total
     * @param  int         $currency
     * @param  null|string $dateTime
     * @return Order
     */
    public function order($number, $total, $currency = 986, $dateTime = null)
    {
        return new Order($number, $total, $currency, $dateTime);
    }

    /**
     * @param  string     $issuer
     * @param  int        $product
     * @param  string|int $installments
     * @return PaymentMethod
     */
    public function paymentMethod($issuer, $product = PaymentMethod::CREDITO_A_VISTA, $installments = 1)
    {
        return new PaymentMethod($issuer, $product, $installments);
    }

    /**
     * @param  Holder        $holder
     * @param  Order         $order
     * @param  PaymentMethod $paymentMethod
     * @param  string        $returnURL
     * @param  int           $authorize
     * @param  bool          $capture
     * @return Transaction
     */
    public function transaction(
        Holder $holder,
        Order $order,
        PaymentMethod $paymentMethod,
        $returnURL,
        $authorize,
        $capture
    ) {
        return new Transaction($this->merchant, $holder, $order, $paymentMethod, $returnURL, $authorize, $capture);
    }

    private function sendHttpRequest($message)
    {
        $headers = ['Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                    'Accept: text/xml; charset=utf-8',
                    'User-Agent: PHP-SDK: 1.0'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        curl_setopt($curl, CURLOPT_SSLVERSION, 4);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(['mensagem' => $message]));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function authorizationRequest(Transaction $transaction)
    {
        $serializer = new AuthorizationRequestSerializer();

        $response = $this->sendHttpRequest($serializer->serialize($transaction));

        $unserializer= new TransactionResponseUnserializer($transaction);

        return $unserializer->unserialize($response);
    }

    public function transactionRequest(Transaction $transaction)
    {
        $serializer = new TransactionRequestSerializer();

        $response = $this->sendHttpRequest($serializer->serialize($transaction));

        $unserializer = new TransactionResponseUnserializer($transaction);

        return $unserializer->unserialize($response);
    }
}
