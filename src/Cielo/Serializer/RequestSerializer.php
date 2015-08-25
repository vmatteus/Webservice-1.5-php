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
    abstract public function serialize($transaction);

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    protected function createDadosEc($transaction, DOMDocument $document)
    {
        $merchant = $transaction->getMerchant();

        $dadosEc = $document->createElementNS(self::NS, 'dados-ec');
        $numero = $document->createElementNS(self::NS, 'numero', $merchant->getAffiliationId());
        $chave = $document->createElementNS(self::NS, 'chave', $merchant->getAffiliationKey());

        $dadosEc->appendChild($numero);
        $dadosEc->appendChild($chave);

        return $dadosEc;
    }
}
