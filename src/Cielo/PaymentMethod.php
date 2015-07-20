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
        $allowedIssuers = [
            PaymentMethod::VISA,
            PaymentMethod::MASTERCARD,
            PaymentMethod::DINERS,
            PaymentMethod::DISCOVER,
            PaymentMethod::ELO,
            PaymentMethod::AMEX,
            PaymentMethod::JCB,
            PaymentMethod::AURA,
        ];

        if (! in_array($issuer, $allowedIssuers, true)) {
            throw new \UnexpectedValueException(
                'O nome da bandeira deve ser uma string em minúsculo: visa, ' .
                'mastercard, diners, discover, elo, amex, jcb e aura'
            );
        }

        $this->issuer = $issuer;
    }

    public function setProduct($product)
    {
        $isAllowedProduct = (
            $product === PaymentMethod::CREDITO_A_VISTA ||
            $product === PaymentMethod::DEBITO ||
            $product === PaymentMethod::PARCELADO_LOJA
        );

        if (! $isAllowedProduct) {
            throw new \UnexpectedValueException(
                'Produto inválido. Utilize 1 – Crédito à Vista, 2 – Parcelado loja ou A – Débito.'
            );
        }

        if ($product === PaymentMethod::CREDITO_A_VISTA || $product === PaymentMethod::DEBITO) {
            $this->installments = 1;
        }

        $this->product = $product;
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
