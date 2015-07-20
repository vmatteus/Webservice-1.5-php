<?php
namespace Cielo;

class Transaction
{
    const ONLY_AUTHENTICATE = 0;
    const AUTHORIZE_IF_AUTHENTICATED = 1;
    const AUTHORIZE = 2;
    const AUTHORIZE_WITHOUT_AUTHENTICATION = 3;
    const RECURRENCE = 4;

    /**
     * @var string
     */
    private $tid;

    /**
     * @var string
     */
    private $pan;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $authenticationUrl;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * @var Holder
     */
    private $holder;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     * @var string
     */
    private $returnURL;

    /**
     * @var integer
     */
    private $authorize;

    /**
     * @var boolean
     */
    private $capture;

    /**
     * @var string
     */
    private $freeField;

    /**
     * @var integer
     */
    private $bin;

    /**
     * @var boolean
     */
    private $generateToken = false;

    /**
     * @var string
     */
    private $avs;

    public function __construct(
        Merchant $merchant,
        Holder $holder,
        Order $order,
        PaymentMethod $paymentMethod,
        $returnURL,
        $authorize,
        $capture
    ) {
        $this->setMerchant($merchant);
        $this->setHolder($holder);
        $this->setOrder($order);
        $this->setPaymentMethod($paymentMethod);
        $this->setReturnURL($returnURL);
        $this->setAuthorize($authorize);
        $this->setCapture($capture);
    }

    public function getTid()
    {
        return $this->tid;
    }

    public function getPan()
    {
        return $this->pan;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }

    public function getAuthenticationURL()
    {
        return $this->authenticationUrl;
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function getHolder()
    {
        return $this->holder;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getReturnURL()
    {
        return $this->returnURL;
    }

    public function getAuthorize()
    {
        return $this->authorize;
    }

    public function getCapture()
    {
        return $this->capture;
    }

    public function getFreeField()
    {
        return $this->freeField;
    }

    public function getBin()
    {
        return $this->bin;
    }

    public function getGenerateToken()
    {
        return $this->generateToken;
    }

    public function getAvs()
    {
        return $this->avs;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    public function setHolder(Holder $holder)
    {
        $this->holder = $holder;

        if (($bin = substr($holder->getCreditCardNumber(), 0, 6)) !== false) {
            $this->setBin($bin);
        }
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function setReturnURL($returnURL)
    {
        if (!filter_var($returnURL, FILTER_VALIDATE_URL)) {
            throw new \UnexpectedValueException('URL de retorno inválida');
        }

        $this->returnURL = $returnURL;
    }

    public function setAuthorize($authorize)
    {
        switch ($authorize) {
            case Transaction::ONLY_AUTHENTICATE:
            case Transaction::AUTHORIZE_IF_AUTHENTICATED:
            case Transaction::AUTHORIZE:
            case Transaction::AUTHORIZE_WITHOUT_AUTHENTICATION:
            case Transaction::RECURRENCE:
                $this->authorize = $authorize;
                break;
            default:
                throw new \UnexpectedValueException('Indicador de autorização inválido');
        }
    }

    public function setCapture($capture)
    {
        if (!is_bool($capture)) {
            throw new \UnexpectedValueException('Indicador de captura deve ser um boolean');
        }

        $this->capture = $capture;
    }

    public function setFreeField($freeField)
    {
        if (strlen($freeField) > 128) {
            throw new \UnexpectedValueException('O campo livre deve ter, no máximo, 128 caracteres');
        }

        $this->freeField = $freeField;
    }

    public function setBin($bin)
    {
        if (!is_numeric($bin) || strlen($bin) != 6) {
            throw new \UnexpectedValueException(
                'O campo bin deve ser informado com os 6 primeiros dígitos do número do cartão'
            );
        }

        $this->bin = $bin;
    }

    public function setGenerateToken($generateToken)
    {
        if (!is_bool($generateToken)) {
            throw new \UnexpectedValueException('O campo generate-token deve ser um boolean');
        }

        $this->generateToken = $generateToken;
    }

    public function setAvs($avs)
    {
        $this->avs = $avs;
    }

    public function setTid($tid)
    {
        $this->tid = $tid;
    }

    public function setPan($pan)
    {
        $this->pan = $pan;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setAuthenticationURL($authenticationUrl)
    {
        $this->authenticationUrl = $authenticationUrl;
    }

    public function setAuthentication(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function setAuthorization(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }
}
