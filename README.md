# Webservice-1.5-php

Integração em PHP com o Webservice Cielo 1.5

## Dependências

* PHP >= 5.4
* libxml

## Instalação

Se já possui um arquivo `composer.json`, basta adicionar a seguinte dependência ao seu projeto:

```json
"require": {
    "developercielo/webservice-1.5-php":"dev-master"
}
```

Com a dependência adicionada ao `composer.json`, basta executar:

```
composer install
```

Alternativamente, você pode executar diretamente em seu terminal:

```
composer require "developercielo/webservice-1.5-php:dev-master"
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

## EXEMPLO DE CONSULTA

```php
<?php

require 'vendor/autoload.php';

use Cielo\Cielo;
use src\Cielo\CieloException;
use src\Cielo\Consultation;

$mid = '12345678'; //seu merchant id
$key = 'xxxx'; //sua chave

$cielo = new Cielo($mid, $key, Cielo::TEST);

$consultation = $cielo->consultation('10069930693EF9D81001'); //tid da transação

  try {

      $consultationResponse = $cielo->consultationRequest($consultation);

        if (is_object($consultationResponse)){

          printf("TID=%s\n", $consultationResponse->getTid());
          printf("STATUS=%s\n", $consultationResponse->getStatus());
          printf("PAN=%s\n", $consultationResponse->getPan());

          printf("AUTORIZATION CODE=%s\n", $consultationResponse->getAuthorization()->getCode());
          printf("AUTORIZATION MESSAGE=%s\n", $consultationResponse->getAuthorization()->getMessage());
          printf("AUTORIZATION DATE=%s\n", $consultationResponse ->getAuthorization()->getDateTime());

        }
          

  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }
```

## EXEMPLO DE CAPTURA TOTAL DA TRANSAÇÃO

```php
<?php

require 'vendor/autoload.php';

use Cielo\Cielo;
use src\Cielo\CieloException;
use src\Cielo\Capture;

$mid = '12345678'; //seu merchant id
$key = 'xxxx'; //sua chave

$cielo = new Cielo($mid, $key, Cielo::TEST);

$capture = $cielo->Capture('10069930693EF9D81001'); //tid da transação

  try {

      $captureResponse = $cielo->captureRequest($capture);

        if (is_object($captureResponse)){

          printf("TID=%s\n", $captureResponse->getTid());
          printf("STATUS=%s\n", $captureResponse->getStatus());
          printf("PAN=%s\n", $captureResponse->getPan());

          printf("STATUS CODE=%s\n", $captureResponse->getCaptureInformation()->getCode());
          printf("CAPTURE MESSAGE=%s\n", $captureResponse->getCaptureInformation()->getMessage());
          printf("CAPTURE DATE=%s\n", $captureResponse ->getCaptureInformation()->getDateTime());
          printf("CAPTURED VALUE=%s\n", $captureResponse ->getCaptureInformation()->getValue());

        }
          

  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }
```

## EXEMPLO DE CANCELAMENTO DA CAPTURA

```php
<?php

require 'vendor/autoload.php';

use Cielo\Cielo;
use src\Cielo\CieloException;
use src\Cielo\Cancellation;

$mid = '12345678'; //seu merchant id
$key = 'xxxx'; //sua chave

$cielo = new Cielo($mid, $key, Cielo::TEST);

$cancellation = $cielo->Cancellation('10069930693EF9D81001'); //tid da transação

  try {

      $cancellationResponse = $cielo->cancellationRequest($cancellation);

        if (is_object($cancellationResponse)){

          printf("TID=%s\n", $cancellationResponse->getTid());
          printf("STATUS=%s\n", $cancellationResponse->getStatus());
          printf("PAN=%s\n", $cancellationResponse->getPan());

          printf("STATUS CODE=%s\n", $cancellationResponse->getCancellationInformation()->getCode());
          printf("CACELLATION MESSAGE=%s\n", $cancellationResponse->getCancellationInformation()->getMessage());
          printf("CACELLATION DATE=%s\n", $cancellationResponse ->getCancellationInformation()->getDateTime());
          printf("CACELLATION VALUE=%s\n", $cancellationResponse->getCancellationInformation()->getValue());

        }
          

  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }
```
