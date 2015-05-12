<?php
namespace Cielo\Serializer;

use \DOMDocument;
use \DOMNode;
use Cielo\Transaction;

class AuthorizationRequestSerializer extends RequestSerializer
{
    public function serialize(Transaction $transaction)
    {
        libxml_use_internal_errors(true);
        $document = new DOMDocument('1.0', 'utf-8');

        $requisicaoAutorizacao = $this->createRequisicaoAutorizacao($transaction, $document);

        $document->appendChild($requisicaoAutorizacao);
        $document->schemaValidate('ecommerce.xsd');

        $exception = new \DomainException('Erro na criação do XML');
        $count = 0;

        foreach (libxml_get_errors() as $error) {
            $exception = new \DomainException($error->message, $error->code, $exception);
            ++$count;
        }

        libxml_clear_errors();

        if ($count) {
            throw $exception;
        }

        return $document->saveXML();
    }

    private function createRequisicaoAutorizacao(Transaction $transaction, DOMDocument $document)
    {
        $requisicaoAutorizacao = $document->createElementNS(RequestSerializer::NS, 'requisicao-autorizacao-tid');
        $requisicaoAutorizacao->setAttribute('id', $transaction->getOrder()->getNumber());
        $requisicaoAutorizacao->setAttribute('versao', RequestSerializer::VERSION);

        $requisicaoAutorizacao->appendChild($document->createElementNS(RequestSerializer::NS, 'tid', $transaction->getTid()));
        $requisicaoAutorizacao->appendChild($this->createDadosEc($transaction, $document));

        return $requisicaoAutorizacao;
    }
}
