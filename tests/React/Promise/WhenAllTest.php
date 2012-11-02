<?php

namespace React\Promise;

/**
 * @group When
 * @group WhenAll
 */
class WhenAllTest extends TestCase
{
    /** @test */
    public function shouldResolveEmptyInput()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array()));

        $when = new When();
        $when->all(array(), $mock);
    }

    /** @test */
    public function shouldResolveValuesArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(1, 2, 3)));

        $when = new When();
        $when->all(
            array(1, 2, 3),
            $mock
        );
    }

    /** @test */
    public function shouldResolvePromisesArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(1, 2, 3)));

        $when = new When();
        $when->all(
            array($when->resolve(1), $when->resolve(2), $when->resolve(3)),
            $mock
        );
    }

    /** @test */
    public function shouldResolveSparseArrayInput()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(null, 1, null, 1, 1)));

        $when = new When();
        $when->all(
            array(null, 1, null, 1, 1),
            $mock
        );
    }

    /** @test */
    public function shouldRejectIfAnyInputPromiseRejects()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(2));

        $when = new When();
        $when->all(
            array($when->resolve(1), $when->reject(2), $when->resolve(3)),
            $this->expectCallableNever(),
            $mock
        );
    }

    /** @test */
    public function shouldAcceptAPromiseForAnArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(1, 2, 3)));

        $when = new When();
        $when->all(
            $when->resolve(array(1, 2, 3)),
            $mock
        );
    }

    /** @test */
    public function shouldResolveToEmptyArrayWhenInputPromiseDoesNotResolveToArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array()));

        $when = new When();
        $when->all(
            $when->resolve(1),
            $mock
        );
    }
}
