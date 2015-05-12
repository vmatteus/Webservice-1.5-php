# Webservice-1.5-php

Integração em PHP com o Webservice Cielo 1.5

## Dependências

* PHP >= 5.4
* libxml

## Instalação

```
composer install
```

## Utilização

```php
<?php
require 'vendor/autoload.php';

use Cielo\Cielo;
use Cielo\CieloException;
use Cielo\Transaction;
use Cielo\Holder;
use Cielo\PaymentMethod;

$mid = '12345678'; //seu merchant id
$key = 'xxxx'; //sua chave

$cielo = new Cielo($mid, $key, Cielo::TEST);

$holder = $cielo->holder('4551870000000183', 2018, 5, Holder::CVV_INFORMED, 123);
$order = $cielo->order('178148599', 1000);
$paymentMethod = $cielo->paymentMethod(PaymentMethod::VISA, PaymentMethod::CREDITO_A_VISTA);

$transaction = $cielo->transaction($holder,
                                   $order,
                                   $paymentMethod,
                                   'http://localhost/cielo.php',
                                   Transaction::AUTHORIZE_WITHOUT_AUTHENTICATION,
                                   true);

try {
    $transaction = $cielo->transactionRequest($transaction);

    if ($transaction->getAuthorization()->getLR() == 0) {
        printf("Transação autorizada com sucesso. TID=%s\n", $transaction->getTid());
    }
} catch (CieloException $e) {
    printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());
}
```
