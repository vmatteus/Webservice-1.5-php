<?php

namespace Cielo;

class Authorization
{
    /**
     * @var int
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
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $lr;

    /**
     * @var int
     */
    private $arp;

    /**
     * @var int
     */
    private $nsu;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getLr()
    {
        return $this->lr;
    }

    /**
     * @return int
     */
    public function getArp()
    {
        return $this->arp;
    }

    /**
     * @return int
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param string $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @param int $lr
     */
    public function setLr($lr)
    {
        $this->lr = $lr;
    }

    /**
     * @param int $arp
     */
    public function setArp($arp)
    {
        $this->arp = $arp;
    }

    /**
     * @param int $nsu
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
    }
}
