<?php

namespace Cielo\Serializer;

use Cielo\Consultation;
use DOMDocument;

class ConsultationRequestSerializer extends RequestSerializer
{
    /**
     * {@inheritDoc}
     */
    public function serialize($transaction)
    {

        libxml_use_internal_errors(true);

        $document = new DOMDocument('1.0', 'utf-8');

        $requisicaoTransacao = $this->createConsultationRequest($transaction, $document);

        $document->appendChild($requisicaoTransacao);

        if (is_file('ecommerce.xsd') && is_readable('ecommerce.xsd')) {
            $document->schemaValidate('ecommerce.xsd');
        }

        $exception = new \DomainException('Erro na criação do XML');
        $count = 0;

        foreach (libxml_get_errors() as $error) {
            $exception = new \DomainException($error->message, $error->code, $exception);
            ++$count;
        }

        libxml_clear_errors();

        if ($count) {
            echo $document->saveXML();
            throw $exception;
        }

        return $document->saveXML();
    }

    /**
     * @param \DOMElement $root
     * @param string      $name
     * @param string      $value
     * @param string      $namespace
     */
    private function createElementAndAppendWithNs(\DOMElement $root, $name, $value, $namespace = self::NS)
    {
        $root->appendChild(new \DOMElement($name, $value, $namespace));
    }

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createConsultationRequest($transaction, DOMDocument $document)
    {
        $requisicao = $document->createElementNS(self::NS, 'requisicao-consulta');

        $requisicao->setAttribute('id', $transaction->getConsultationId());
        $requisicao->setAttribute('versao', RequestSerializer::VERSION);

        $this->createElementAndAppendWithNs($requisicao, 'tid', $transaction->tid);

        $requisicao->appendChild($this->createDadosEc($transaction, $document));

        return $requisicao;
    }
}
