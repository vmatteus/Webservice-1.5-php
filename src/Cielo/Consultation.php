<?php

namespace Cielo;

Class Consultation {

	/**
	 * @var string
	 */
	public $tid;

	/**
	 * @param Merchant      $merchant
	 * @param string  		$tid
	 */
	public function __construct(
		Merchant $merchant, 
		$tid = null
	) {
		$this->setMerchant($merchant);
		$this->setTidOrOrderNumber($tid);
		
	}

	/**
     * @param Merchant $merchant
     */
    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * @return Merchant
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

	/**
     * @param  string $tid
     * @throws \UnexpectedValueException se o número do tid não estiver de 1
     * à 20 caracteres
     */
	public function setTidOrOrderNumber($tid = null)
	{
		
		if(strlen($tid) < 1 || strlen($tid) > 20 )
			throw new \UnexpectedValueException("O string de consulta (Tid) deve ter entre 1 à 20 caracteres", 1);

		$this->$tid = $tid;
			
		
	}

	/**
     * @return Consultation Id
     */
	public function getConsultationId()
	{
		return md5(date("YmdHisu"));
	}



}