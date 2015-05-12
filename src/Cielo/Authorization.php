<?php
namespace Cielo;

class Authorization
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
    private $lr;

    /**
     * @var integer
     */
    private $arp;

    /**
     * @var integer
     */
    private $nsu;

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

    public function getLr()
    {
        return $this->lr;
    }

    public function getArp()
    {
        return $this->arp;
    }

    public function getNsu()
    {
        return $this->nsu;
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

    public function setLr($lr)
    {
        $this->lr = $lr;
    }

    public function setArp($arp)
    {
        $this->arp = $arp;
    }

    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
    }
}
