<?php

namespace Cielo;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class OrderTest extends TestCase
{
    /**
     * @var Order
     */
    private $order;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->order = new Order('178148599', 1000, 986);
    }

    /**
     * @test
     */
    public function getNumber()
    {
        $this->assertEquals('178148599', $this->order->getNumber());
    }

    /**
     * @test
     */
    public function setNumberThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setNumber('');
    }

    /**
     * @test
     */
    public function setTotalThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setTotal(10.00);
    }

    /**
     * @test
     */
    public function setCurrencyThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setCurrency(null);
    }

    /**
     * @test
     */
    public function setDateTimeThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setDateTime('2015-07-20');
    }

    /**
     * @test
     */
    public function setDescriptionThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setDescription(str_repeat('foo', 1024 / 3 + 1));
    }

    /**
     * @test
     */
    public function setLanguageThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setLanguage('DE');
    }

    /**
     * @test
     */
    public function setShippingThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setShipping(20.00);
    }

    /**
     * @test
     */
    public function setSoftDescriptorThrowsUnexpectedValue()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $this->order->setSoftDescriptor(str_repeat('9', 14));
    }

    /**
     * @test
     */
    public function getSoftDescriptor()
    {
        $descriptor = '12345';

        $this->order->setSoftDescriptor($descriptor);

        $this->assertEquals($descriptor, $this->order->getSoftDescriptor());
    }
}
