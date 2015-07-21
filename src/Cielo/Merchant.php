<?php

namespace Cielo;

class Merchant
{
    /**
     * @var string
     */
    private $affiliationId;

    /**
     * @var string
     */
    private $affiliationKey;

    /**
     * @param string $id
     * @param string $key
     */
    public function __construct($id, $key)
    {
        $this->setAffiliationId((string) $id);
        $this->setAffiliationKey((string) $key);
    }

    /**
     * @return string
     */
    public function getAffiliationId()
    {
        return $this->affiliationId;
    }

    /**
     * @return string
     */
    public function getAffiliationKey()
    {
        return $this->affiliationKey;
    }

    /**
     * @param  string $id
     * @throws \UnexpectedValueException se o número de afiliação não for númerico
     * ou não conter de 1 à 20 caracteres
     */
    public function setAffiliationId($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 || strlen($id) > 20) {
            throw new \UnexpectedValueException(
                'O número de afiliação deve ser um número e ter entre 1 e 20 caracteres'
            );
        }

        $this->affiliationId = $id;
    }

    /**
     * @param  string $key
     * @throws \UnexpectedValueException se a chave de afiliação não for do tipo
     * `string` ou não conter de 1 à 100 caracteres
     */
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
