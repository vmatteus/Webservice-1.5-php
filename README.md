# Webservice-1.5-php

Integração em PHP com o Webservice Cielo 1.5

## Dependências

* PHP >= 5.4
* libxml

## Instalação

```
composer install
```

## EXEMPLO DE TRANSAÇÃO

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

      if ($transaction->getAuthorization()->getLR() == 0)
          printf("Transação autorizada com sucesso. TID=%s\n", $transaction->getTid());

  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }

```

## EXEMPLO DE CONSULTA DA TRANSAÇÃO ATRAVÉS DO TID

```php
<?php

require 'vendor/autoload.php';

use Cielo\Cielo;
use src\Cielo\CieloException;
use src\Cielo\Consultation;

function __autoload($class_name) {
    require_once $class_name . '.php';
}

$mid = '1006993069'; //seu merchant id
$key = '25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3'; //sua chave

$cielo = new Cielo($mid, $key, Cielo::TEST);

$consultation = $cielo->Consultation('10069930693EF9D81001'); //tid da transação

  try {

      $consultationResponse = $cielo->consultationRequest($consultation);

        if (is_object($consultationResponse)){

          printf("TID=%s\n", $consultationResponse->getTid());
          printf("STATUS=%s\n", $consultationResponse->getStatus());
          printf("PAN=%s\n", $consultationResponse->getPan());
          printf("AUTORIZATION CODE=%s\n", $consultationResponse->getAuthorization()->code);
          printf("AUTORIZATION MESSAGE=%s\n", $consultationResponse->getAuthorization()->message);
          printf("AUTORIZATION DATE=%s\n", $consultationResponse ->getAuthorization()->dateTime);

        }
          

  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }
```