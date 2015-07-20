<?php

namespace Cielo;

class Holder
{
    const CVV_NOT_INFORMED = 0;
    const CVV_INFORMED = 1;
    const CVV_UNREADABLE = 2;
    const CVV_NONEXISTENT = 9;

    /**
     * @var string
     */
    private $creditCardNumber;

    /**
     * @var string
     */
    private $expiration;

    /**
     * @var int
     */
    private $cvvIndicator = Holder::CVV_NOT_INFORMED;

    /**
     * @var string
     */
    private $cvv;

    /**
     * @var string
     */
    private $holderName;

    /**
     * @var string
     */
    private $token;

    /**
     * @param string      $tokenOrNumber
     * @param null|string $expirationYear
     * @param null|string $expirationMonth
     * @param int         $indicator
     * @param int         $cvv
     */
    public function __construct(
        $tokenOrNumber,
        $expirationYear = null,
        $expirationMonth = null,
        $indicator = Holder::CVV_NOT_INFORMED,
        $cvv = null
    ) {
        if (func_num_args() == 1) {
            $this->setToken($tokenOrNumber);

            return null;
        }

        $this->setCreditCardNumber($tokenOrNumber);
        $this->setExpiration($expirationYear, $expirationMonth);
        $this->setCVVIndicator($indicator);

        if ($indicator == Holder::CVV_INFORMED) {
            $this->setCVV($cvv);
        }
    }

    /**
     * @return string
     */
    public function getCreditCardNumber()
    {
        return $this->creditCardNumber;
    }

    /**
     * @return string
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return int
     */
    public function getCVVIndicator()
    {
        return $this->cvvIndicator;
    }

    /**
     * @return string
     */
    public function getCVV()
    {
        return $this->cvv;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param  string $number
     * @throws \UnexpectedValueException se o número do cartão não for numérico
     * ou exceder 19 dígitos
     */
    public function setCreditCardNumber($number)
    {
        if (!is_numeric($number) || strlen($number) > 19) {
            throw new \UnexpectedValueException(
                'O número do cartão deve conter apenas números e ter no máximo 19 caracteres'
            );
        }

        $this->creditCardNumber = $number;
    }

    /**
     * @param string $expirationYear
     * @param string $expirationMonth
     *
     * @throws \UnexpectedValueException se o ano de expiração não for numérico
     * ou não conter 4 dígitos
     *
     * @throws \UnexpectedValueException se o mês de expiração não for numérico
     * ou não estiver entre 1 e 12
     */
    public function setExpiration($expirationYear, $expirationMonth)
    {
        if (!is_numeric($expirationYear) || strlen($expirationYear) != 4) {
            throw new \UnexpectedValueException('O ano de expiração do cartão deve ser um número de 4 dígitos');
        }

        if (!is_numeric($expirationMonth) || $expirationMonth < 1 || $expirationMonth > 12) {
            throw new \UnexpectedValueException('O mês de expiração do cartão deve ser um número entre 1 e 12');
        }

        $this->expiration = sprintf('%4d%02d', $expirationYear, $expirationMonth);
    }

    /**
     * @param  int $indicator
     * @throws \UnexpectedValueException se o indicador for inválido
     */
    public function setCVVIndicator($indicator)
    {
        switch ($indicator) {
            case Holder::CVV_NOT_INFORMED:
            case Holder::CVV_UNREADABLE:
            case Holder::CVV_NONEXISTENT:
                $this->cvv = null;
                break;

            case Holder::CVV_INFORMED:
                $this->cvvIndicator = $indicator;
                break;

            default:
                throw new \UnexpectedValueException('Indicador inválido');
        }
    }

    /**
     * @param  string $cvv
     * @throws \UnexpectedValueException se o CVV não for numérico ou não conter
     * 3 ou 4 dígitos
     */
    public function setCVV($cvv)
    {
        if (!is_numeric($cvv) || strlen($cvv) < 3 || strlen($cvv) > 4) {
            throw new \UnexpectedValueException(
                'O código de segurança deve ser um número e deve ter 3 ou 4 caracteres'
            );
        }

        $this->cvv = $cvv;
        $this->setCVVIndicator(Holder::CVV_INFORMED);
    }

    /**
     * @param  string $name
     * @throws \UnexpectedValueException se o nome do portador do cartão não for
     * do tipo `string` ou exceder 50 caracteres
     */
    public function setName($name)
    {
        if (!is_string($name) || strlen($name) > 50) {
            throw new \UnexpectedValueException('O nome do portador deve ser uma string com, no máximo, 50 caracteres');
        }

        $this->holderName = $name;
    }

    /**
     * @param  string $token
     * @throws \UnexpectedValueException se o token exceder 100 caracteres ou não
     * for do tipo `string`
     */
    public function setToken($token)
    {
        if (!is_string($token) || strlen($token) > 100) {
            throw new \UnexpectedValueException('O token deve ser uma string com, no máximo, 100 caracteres');
        }

        $this->token = $token;
        $this->creditCardNumber = null;
        $this->expiration = null;
        $this->cvvIndicator = Holder::CVV_NOT_INFORMED;
        $this->cvv = null;
    }
}
