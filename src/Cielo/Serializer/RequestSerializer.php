<?php
namespace Cielo\Serializer;

use \DOMDocument;
use \DOMNode;
use Cielo\Transaction;

abstract class RequestSerializer
{
    const NS = 'http://ecommerce.cbmp.com.br';
    const VERSION = '1.3.0';

    public abstract function serialize(Transaction $transaction);

    protected function createDadosEc(Transaction $transaction, DOMDocument $document)
     {
        $merchant = $transaction->getMerchant();

        $dadosEc = $document->createElementNS(TransactionRequestSerializer::NS, 'dados-ec');
        $numero = $document->createElementNS(TransactionRequestSerializer::NS, 'numero', $merchant->getAffiliationId());
        $chave = $document->createElementNS(TransactionRequestSerializer::NS, 'chave', $merchant->getAffiliationKey());

        $dadosEc->appendChild($numero);
        $dadosEc->appendChild($chave);

        return $dadosEc;
    }
}
