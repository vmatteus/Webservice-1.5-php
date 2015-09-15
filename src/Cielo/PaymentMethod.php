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
    const PARCELADO_ADM = 3;
    const DEBITO = 'A';

    private $issuer;
    private $product;
    private $installments;

    /**
     * @param string $issuer
     * @param int    $product
     * @param int    $installments
     */
    public function __construct($issuer = null, $product = PaymentMethod::CREDITO_A_VISTA, $installments = 1)
    {
        $this->setIssuer($issuer);
        $this->setProduct($product);
        $this->setInstallments($installments);
    }

    /**
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param  string $issuer
     * @throws \UnexpectedValueException se a bandeira do cartão for inválida
     */
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
            null,
        ];

        if (! in_array($issuer, $allowedIssuers, true)) {
            throw new \UnexpectedValueException(
                'O nome da bandeira deve ser uma string em minúsculo: visa, ' .
                'mastercard, diners, discover, elo, amex, jcb e aura'
            );
        }

        $this->issuer = $issuer;
    }

    /**
     * @param  string|int $product
     * @throws \UnexpectedValueException se o `produto` for inválido
     */
    public function setProduct($product)
    {
        $isAllowedProduct = (
            $product == PaymentMethod::CREDITO_A_VISTA ||
            $product == PaymentMethod::DEBITO ||
            $product == PaymentMethod::PARCELADO_LOJA ||
            $product == PaymentMethod::PARCELADO_ADM
        );

        if (! $isAllowedProduct) {
            throw new \UnexpectedValueException(
                'O produto é inválido. Utilize 1 – Crédito à Vista, 2 – Parcelado loja, 3 - Parcelado Adm, ou A – Débito.'
            );
        }

        if ($product === PaymentMethod::CREDITO_A_VISTA || $product === PaymentMethod::DEBITO) {
            $this->installments = 1;
        }

        $this->product = $product;
    }

    /**
     * @param string $installments
     *
     * @throws \UnexpectedValueException se a forma de pagamento for débito ou
     * crédito à vista e o número de parcelas for diferente de 1
     *
     * @throws \UnexpectedValueException se o número de parcelas for menor que 1
     * ou o número de parcelas não estiver com 2 dígitos
     */
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
