<?php
namespace Cielo;

class PaymentMethod
{
    const VISA = 'visa';
    const MASTERCARD = 'mastercard';
    const DINERS = 'diners';
    const DISCOVER = 'discover';
    const ELO = 'elo';
    const AMEX = 'amex';
    const JCB = 'jcb';
    const AURA = 'aura';

    const CREDITO_A_VISTA = 1;
    const PARCELADO_LOJA = 2;
    const DEBITO = 'A';

    private $issuer;
    private $product;
    private $installments;

    public function __construct($issuer, $product = PaymentMethod::CREDITO_A_VISTA, $installments = 1)
    {
        $this->setIssuer($issuer);
        $this->setProduct($product);
        $this->setInstallments($installments);
    }

    public function getIssuer()
    {
        return $this->issuer;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getInstallments()
    {
        return $this->installments;
    }

    public function setIssuer($issuer)
    {
        switch ($issuer) {
            case PaymentMethod::VISA:
            case PaymentMethod::MASTERCARD:
            case PaymentMethod::DINERS:
            case PaymentMethod::DISCOVER:
            case PaymentMethod::ELO:
            case PaymentMethod::AMEX:
            case PaymentMethod::JCB:
            case PaymentMethod::AURA:
                $this->issuer = $issuer;
                break;
            default:
                throw new \UnexpectedValueException(
                    'O nome da bandeira deve ser uma string em minúsculo: visa, ' .
                    'mastercard, diners, discover, elo, amex, jcb e aura'
                );
        }
    }

    public function setProduct($product)
    {
        switch ($product) {
            case PaymentMethod::CREDITO_A_VISTA:
            case PaymentMethod::DEBITO:
                $this->installments = 1;
                break;

            case PaymentMethod::PARCELADO_LOJA:
                $this->product = $product;
                break;

            default:
                throw new \UnexpectedValueException(
                    'Produto inválido. Utilize 1 – Crédito à Vista, 2 – Parcelado loja ou A – Débito.'
                );
        }
    }

    public function setInstallments($installments)
    {
        $isOneTimePayment = (
            $this->product === PaymentMethod::DEBITO ||
            $this->product === PaymentMethod::CREDITO_A_VISTA
        );

        if ($isOneTimePayment && $installments !== 1) {
            throw new \UnexpectedValueException('Para crédito à vista ou débito, o número de parcelas deve ser 1');
        }

        if ($installments < 1 || strlen($installments) > 2) {
            throw new \UnexpectedValueException(
                'O número de parcelas deve ser maior ou igual a 1 e deve ter no máximo 2 dígitos'
            );
        }

        $this->installments = $installments;
    }
}
