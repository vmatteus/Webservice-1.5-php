<?php
namespace Cielo;

class Order
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $currency = 986;

    /**
     * @var string
     */
    private $dateTime;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $language = 'PT';

    /**
     * @var integer
     */
    private $shipping;

    /**
     * @var string
     */
    private $softDescriptor;

    public function __construct($number, $total, $currency = 986, $dateTime = null)
    {
        $this->setNumber($number);
        $this->setTotal($total);
        $this->setCurrency($currency);

        if ($dateTime == null) {
            $this->setDateTime(@date('Y-m-d\TH:i:s'));
        }


    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setNumber($number)
    {
        if (strlen($number) < 1 || strlen($number) > 20) {
            throw new \UnexpectedValueException('O número do pedido deve ter entre 1 e 20 caracteres');
        }

        $this->number = $number;
    }

    public function setTotal($total)
    {
        if (!is_int($total)) {
            throw new \UnexpectedValueException('O valor total do pedido deve ser informado como inteiro e já deve incluir valor de frete e outras despesas/taxas');
        }

        $this->total = $total;
    }

    public function setCurrency($currency)
    {
        if (!is_int($currency)) {
            throw new \UnexpectedValueException('A moeda deve ser informada utilizando o código ISO 4217');
        }

        $this->currency = $currency;
    }

    public function setDateTime($dateTime)
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]{3}-?[0-9]{2}:[0-9]{2})?$/', $dateTime)) {
            throw new \UnexpectedValueException('A data deve ser informada utilizando o formato aaaa-MM-ddTHH:mm:ss');
        }

        $this->dateTime = $dateTime;
    }

    public function setDescription($description)
    {
        if (strlen($description) > 1024) {
            throw new \UnexpectedValueException('A descrição deve ser uma string com até 1024 caracteres');
        }

        $this->description = $description;
    }

    public function setLanguage($language)
    {
        switch ($language) {
            case 'PT':
            case 'EN':
            case 'ES':
                $this->language = $language;
                break;
            default:
                throw new \UnexpectedValueException('O idioma deve ser informado como PT (português), EN (inglês) ou ES (espanhol)');
        }
    }

    public function setShipping($shipping)
    {
        if (!is_int($shipping)) {
            throw new \UnexpectedValueException('O valor da autorização que deve ser destinado à taxa de embarque deve ser informada como inteiro');
        }

        $this->shipping = $shipping;
    }

    public function setSoftDescriptor($softDescriptor)
    {
        if (strlen($softDescriptor) > 13) {
            throw new \UnexpectedValueException('O texto que será exibido na fatura do portador deve ser uma string com até 13 caracteres');
        }

        $this->softDescriptor = $softDescriptor;
    }
}
