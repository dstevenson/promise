<?php

namespace React\Promise;

/**
 * @group When
 * @group WhenAny
 */
class WhenAnyTest extends TestCase
{
    /** @test */
    public function shouldResolveToNullWithEmptyInputArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(null));

        $when = new When();
        $when->any(array(), $mock);
    }

    /** @test */
    public function shouldResolveWithAnInputValue()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $when = new When();
        $when->any(
            array(1, 2, 3),
            $mock
        );
    }

    /** @test */
    public function shouldResolveWithAPromisedInputValue()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $when = new When();
        $when->any(
            array($when->resolve(1), $when->resolve(2), $when->resolve(3)),
            $mock
        );
    }

    /** @test */
    public function shouldRejectWithAllRejectedInputValuesIfAllInputsAreRejected()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(0 => 1, 1 => 2, 2 => 3)));

        $when = new When();
        $when->any(
            array($when->reject(1), $when->reject(2), $when->reject(3)),
            $this->expectCallableNever(),
            $mock
        );
    }

    /** @test */
    public function shouldResolveWhenFirstInputPromiseResolves()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $when = new When();
        $when->any(
            array($when->resolve(1), $when->reject(2), $when->reject(3)),
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
            ->with($this->identicalTo(1));

        $when = new When();
        $when->any(
            $when->resolve(array(1, 2, 3)),
            $mock
        );
    }

    /** @test */
    public function shouldResolveToNullArrayWhenInputPromiseDoesNotResolveToArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(null));

        $when = new When();
        $when->any(
            $when->resolve(1),
            $mock
        );
    }
}
