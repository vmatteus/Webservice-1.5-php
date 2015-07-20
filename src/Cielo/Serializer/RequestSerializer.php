<?php

namespace Cielo\Serializer;

use Cielo\Transaction;
use DOMDocument;

abstract class RequestSerializer
{
    /**
     * @var string
     */
    const NS = 'http://ecommerce.cbmp.com.br';

    /**
     * @var string
     */
    const VERSION = '1.3.0';

    /**
     * @param  Transaction $transaction
     * @return string
     */
    abstract public function serialize(Transaction $transaction);

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
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
