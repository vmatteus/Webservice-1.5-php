<?php

namespace Cielo;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class HolderTest extends TestCase
{
    /**
     * @var Holder
     */
    private $holder;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->holder = new Holder(
            '4012001038443335',
            '2015',
            '08',
            Holder::CVV_INFORMED,
            '973'
        );
    }

    /**
     * @test
     */
    public function getToken()
    {
        $this->assertNull($this->holder->getToken());
    }

    /**
     * @test
     */
    public function getCreditCardNumber()
    {
        $this->assertEquals('4012001038443335', $this->holder->getCreditCardNumber());
    }

    /**
     * @test
     */
    public function getExpiration()
    {
        $this->assertEquals('201508', $this->holder->getExpiration());
    }

    /**
     * @test
     */
    public function getCVVIndicator()
    {
        $this->assertEquals(Holder::CVV_INFORMED, $this->holder->getCVVIndicator());
    }

    /**
     * @test
     */
    public function getCVV()
    {
        $this->assertEquals(973, $this->holder->getCVV());
    }

    public function testGetName()
    {
        $this->holder->setName('Ciclano');

        $this->assertEquals('Ciclano', $this->holder->getName());
    }

    /**
     * @test
     */
    public function setNameThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->holder->setName(null);
    }

    /**
     * @test
     */
    public function setToken()
    {
        $this->holder->setToken('TuS6LeBHWjqFFtE7S3zR052Jl/KUlD+tYJFpAdlA87E=');

        $this->assertEquals('TuS6LeBHWjqFFtE7S3zR052Jl/KUlD+tYJFpAdlA87E=', $this->holder->getToken());
    }

    /**
     * @test
     */
    public function setTokenThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->holder->setToken(null);
    }

    /**
     * @test
     */
    public function setCVVThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->holder->setCVV(null);
    }

    /**
     * @test
     */
    public function setCVVIndicatorThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->holder->setCVVIndicator(-1);
    }

    /**
     * @test
     */
    public function setCreditCardNumberThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->holder->setCreditCardNumber(false);
    }
}
