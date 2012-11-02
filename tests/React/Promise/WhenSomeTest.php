<?php

namespace React\Promise;

/**
 * @group When
 * @group WhenSome
 */
class WhenSomeTest extends TestCase
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
        $when->some(array(), 1, $mock);
    }

    /** @test */
    public function shouldResolveValuesArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(1, 2)));

        $when = new When();
        $when->some(
            array(1, 2, 3),
            2,
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
            ->with($this->identicalTo(array(1, 2)));

        $when = new When();
        $when->some(
            array($when->resolve(1), $when->resolve(2), $when->resolve(3)),
            2,
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
            ->with($this->identicalTo(array(null, 1)));

        $when = new When();
        $when->some(
            array(null, 1, null, 2, 3),
            2,
            $mock
        );
    }

    /** @test */
    public function shouldRejectIfAnyInputPromiseRejectsBeforeDesiredNumberOfInputsAreResolved()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(1 => 2, 2 => 3)));

        $when = new When();
        $when->some(
            array($when->resolve(1), $when->reject(2), $when->reject(3)),
            2,
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
            ->with($this->identicalTo(array(1, 2)));

        $when = new When();
        $when->some(
            $when->resolve(array(1, 2, 3)),
            2,
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
        $when->some(
            $when->resolve(1),
            1,
            $mock
        );
    }
}
