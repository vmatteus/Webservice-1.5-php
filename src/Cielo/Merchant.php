<?php
namespace Cielo;

class Merchant
{
    /**
     * @var integer
     */
    private $affiliationId;

    /**
     * @var string
     */
    private $affiliationKey;

    public function __construct($id, $key)
    {
        $this->setAffiliationId($id);
        $this->setAffiliationKey($key);
    }

    public function getAffiliationId()
    {
        return $this->affiliationId;
    }

    public function getAffiliationKey()
    {
        return $this->affiliationKey;
    }

    public function setAffiliationId($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 || strlen($id) > 20) {
            throw new \UnexpectedValueException(
                'O número de afiliação deve ser um número e ter entre 1 e 20 caracteres'
            );
        }

        $this->affiliationId = $id;
    }

    public function setAffiliationKey($key)
    {
        if (!is_string($key) || strlen($key) < 1 || strlen($key) > 100) {
            throw new \UnexpectedValueException(
                'A chave de afiliação deve ser uma string e ter entre 1 e 100 caracteres'
            );
        }

        $this->affiliationKey = $key;
    }
}
