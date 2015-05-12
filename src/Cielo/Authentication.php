<?php
namespace Cielo;

class Authentication
{
    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $dateTime;

    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $eci;

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getEci()
    {
        return $this->eci;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setEci($eci)
    {
        $this->eci = $eci;
    }
}
