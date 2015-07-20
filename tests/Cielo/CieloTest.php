<?php

namespace Cielo;

use PHPUnit_Framework_TestCase as TestCase;

class CieloTest extends TestCase
{
    /**
     * @var Cielo
     */
    private $cielo;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->cielo = new Cielo('1006993069', '25fbb997438630f30b112d033ce2e621b34f3', Cielo::TEST);
    }

    /**
     * @test
     */
    public function withInvalidEndpoint()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        new Cielo(
            '1006993069',
            '25fbb997438630f30b112d033ce2e621b34f3',
            'http://'
        );
    }

    /**
     * @test
     */
    public function merchant()
    {
        $this->assertInstanceOf(
            Merchant::class,
            $this->cielo->merchant('1006993069', '25fbb997438630f30b112d033ce2e621b34f3')
        );
    }

    /**
     * @test
     */
    public function holderWithOnlyToken()
    {
        $this->assertInstanceOf(Holder::class, $this->cielo->holder('TuS6LeBHWjqFFtE7S3zR052Jl/KUlD+tYJFpAdlA87E='));
    }

    /**
     * @test
     */
    public function holder()
    {
        $this->assertInstanceOf(
            Holder::class,
            $this->cielo->holder(
                '4012001038443335',
                '2015',
                '08',
                Holder::CVV_INFORMED,
                '973'
            )
        );
    }

    /**
     * @test
     */
    public function order()
    {
        $this->assertInstanceOf(Order::class, $this->cielo->order('178148599', 1000));
    }

    /**
     * @test
     */
    public function paymentMethod()
    {
        $this->assertInstanceOf(
            PaymentMethod::class,
            $this->cielo->paymentMethod(PaymentMethod::VISA, PaymentMethod::CREDITO_A_VISTA)
        );
    }

    /**
     * @test
     */
    public function transaction()
    {
        $holder = $this->cielo->holder('4551870000000183', 2018, 5, Holder::CVV_INFORMED, 123);

        $order = $this->cielo->order('178148599', 1000);

        $paymentMethod = $this->cielo->paymentMethod(PaymentMethod::VISA, PaymentMethod::CREDITO_A_VISTA);

        $this->assertInstanceOf(
            Transaction::class,
            $this->cielo->transaction(
                $holder,
                $order,
                $paymentMethod,
                'http://localhost/cielo.php',
                Transaction::AUTHORIZE_WITHOUT_AUTHENTICATION,
                true
            )
        );
    }
}
