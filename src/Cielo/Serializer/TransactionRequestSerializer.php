<?php

namespace Cielo\Serializer;

use Cielo\Transaction;
use DOMDocument;

class TransactionRequestSerializer extends RequestSerializer
{
    /**
     * {@inheritDoc}
     */
    public function serialize(Transaction $transaction)
    {
        libxml_use_internal_errors(true);
        $document = new DOMDocument('1.0', 'utf-8');

        $requisicaoTransacao = $this->createRequisicaoTransacao($transaction, $document);
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
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createRequisicaoTransacao(Transaction $transaction, DOMDocument $document)
    {
        $requisicaoTransacao = $document->createElementNS(RequestSerializer::NS, 'requisicao-transacao');
        $requisicaoTransacao->setAttribute('id', $transaction->getOrder()->getNumber());
        $requisicaoTransacao->setAttribute('versao', RequestSerializer::VERSION);

        $requisicaoTransacao->appendChild($this->createDadosEc($transaction, $document));
        $requisicaoTransacao->appendChild($this->createDadosPortador($transaction, $document));
        $requisicaoTransacao->appendChild($this->createDadosPedido($transaction, $document));
        $requisicaoTransacao->appendChild($this->createFormaPagamento($transaction, $document));

        $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'url-retorno', $transaction->getReturnURL()));
        $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'autorizar', $transaction->getAuthorize()));
        $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'capturar', $transaction->getCapture() ? 'true':'false'));
        $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'campo-livre', $transaction->getFreeField()));

        if ($transaction->getBin() !== null) {
            $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'bin', $transaction->getBin()));
        }

        $requisicaoTransacao->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'gerar-token', $transaction->getGenerateToken() ? 'true':'false'));

        $avsXML = $transaction->getAvs();

        if (! empty($avsXML)) {
            $avs = $document->createElementNS(TransactionRequestSerializer::NS, 'avs');
            $avs->appendChild($document->createCDATASection($avsXML));

            $requisicaoTransacao->appendChild($avs);
        }

        return $requisicaoTransacao;
    }

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createDadosPortador(Transaction $transaction, DOMDocument $document)
    {
        $holder = $transaction->getHolder();
        $token = $holder->getToken();

        $dadosPortador = $document->createElementNS(TransactionRequestSerializer::NS, 'dados-portador');

        if (empty($token)) {
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'numero', $holder->getCreditCardNumber()));
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'validade', $holder->getExpiration()));
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'indicador', $holder->getCVVIndicator()));
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'codigo-seguranca', $holder->getCVV()));
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'token'));
        } else {
            $dadosPortador->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'token', $token));
        }

        return $dadosPortador;
    }

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createDadosPedido(Transaction $transaction, DOMDocument $document)
    {
        $order = $transaction->getOrder();

        $dadosPedido = $document->createElementNS(TransactionRequestSerializer::NS, 'dados-pedido');

        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'numero', $order->getNumber()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'valor', $order->getTotal()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'moeda', $order->getCurrency()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'data-hora', $order->getDateTime()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'descricao', $order->getDescription()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'idioma', $order->getLanguage()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'taxa-embarque', (int) $order->getShipping()));
        $dadosPedido->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'soft-descriptor', $order->getSoftDescriptor()));

        return $dadosPedido;
    }

    /**
     * @param  Transaction $transaction
     * @param  DOMDocument $document
     * @return \DOMElement
     */
    private function createFormaPagamento(Transaction $transaction, DOMDocument $document)
    {
        $paymentMethod = $transaction->getPaymentMethod();

        $formaPagamento = $document->createElementNS(TransactionRequestSerializer::NS, 'forma-pagamento');

        $formaPagamento->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'bandeira', $paymentMethod->getIssuer()));
        $formaPagamento->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'produto', $paymentMethod->getProduct()));
        $formaPagamento->appendChild($document->createElementNS(TransactionRequestSerializer::NS, 'parcelas', $paymentMethod->getInstallments()));

        return $formaPagamento;
    }
}
