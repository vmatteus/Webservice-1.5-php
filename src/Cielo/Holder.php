<?php
namespace Cielo;

class Holder
{
    const CVV_NOT_INFORMED = 0;
    const CVV_INFORMED = 1;
    const CVV_UNREADABLE = 2;
    const CVV_NONEXISTENT = 9;

    /**
     * @var integer
     */
    private $creditCardNumber;

    /**
     * @var string
     */
    private $expiration;

    /**
     * @var integer
     */
    private $cvvIndicator = Holder::CVV_NOT_INFORMED;

    /**
     * @var integer
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

    public function __construct(
        $tokenOrNumber,
        $expirationYear = null,
        $expirationMonth = null,
        $indicator = Holder::CVV_NOT_INFORMED,
        $cvv = null
    ) {
        if (func_num_args() == 1) {
            $this->setToken($tokenOrNumber);
        } else {
            $this->setCreditCardNumber($tokenOrNumber);
            $this->setExpiration($expirationYear, $expirationMonth);
            $this->setCVVIndicator($indicator);

            if ($indicator == Holder::CVV_INFORMED) {
                $this->setCVV($cvv);
            }
        }
    }

    public function getCreditCardNumber()
    {
        return $this->creditCardNumber;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function getCVVIndicator()
    {
        return $this->cvvIndicator;
    }

    public function getCVV()
    {
        return $this->cvv;
    }

    public function getName()
    {
        return $this->holderName;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setCreditCardNumber($number)
    {
        if (!is_numeric($number) || strlen($number) > 19) {
            throw new \UnexpectedValueException(
                'O número do cartão deve conter apenas números e ter no máximo 19 caracteres'
            );
        }

        $this->creditCardNumber = $number;
    }

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

    public function setName($name)
    {
        if (!is_string($name) || strlen($name) > 50) {
            throw new \UnexpectedValueException('O nome do portador deve ser uma string com, no máximo, 50 caracteres');
        }

        $this->holderName = $name;
    }

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
