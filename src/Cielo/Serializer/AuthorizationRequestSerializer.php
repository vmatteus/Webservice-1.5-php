<?php

namespace Cielo\Serializer;

use Cielo\Transaction;
use DOMDocument;

class AuthorizationRequestSerializer extends RequestSerializer
{
    /**
     * @param  Transaction $transaction
     * @return string
     */
    public function serialize(Transaction $transaction)
    {
        libxml_use_internal_errors(true);

        $document = new DOMDocument('1.0', 'utf-8');

        $autorizacao = $this->createRequisicaoAutorizacao($transaction, $document);

        $document->appendChild($autorizacao);
        $document->schemaValidate('ecommerce.xsd');

        $exception = new \DomainException('Erro na criação do XML');

        $count = 0;

        foreach (libxml_get_errors() as $error) {
            $exception = new \DomainException($error->message, $error->code, $exception);

            ++ $count;
        }

        libxml_clear_errors();

        if ($count) {
            throw $exception;
        }

        return $document->saveXML();
    }

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createRequisicaoAutorizacao(Transaction $transaction, DOMDocument $document)
    {
        $autorizacao = $document->createElementNS(RequestSerializer::NS, 'requisicao-autorizacao-tid');

        $autorizacao->setAttribute('id', $transaction->getOrder()->getNumber());
        $autorizacao->setAttribute('versao', RequestSerializer::VERSION);

        $autorizacao->appendChild($document->createElementNS(RequestSerializer::NS, 'tid', $transaction->getTid()));
        $autorizacao->appendChild($this->createDadosEc($transaction, $document));

        return $autorizacao;
    }
}
