<?php
namespace Cielo;

class Token
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $numero;

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }
}
