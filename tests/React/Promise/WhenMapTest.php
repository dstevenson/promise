<?php

namespace React\Promise;

/**
 * @group When
 * @group WhenMap
 */
class WhenMapTest extends TestCase
{
    protected function mapper()
    {
        return function ($val) {
            return $val * 2;
        };
    }

    protected function promiseMapper()
    {
        return function ($val) {
            $when = new When();
            return $when->resolve($val * 2);
        };
    }

    /** @test */
    public function shouldMapInputValuesArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(2, 4, 6)));

        $when = new When();
        $when
            ->map(
                array(1, 2, 3),
                $this->mapper()
            )->then($mock);
    }

    /** @test */
    public function shouldMapInputPromisesArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(2, 4, 6)));

        $when = new When();
        $when
            ->map(
                array($when->resolve(1), $when->resolve(2), $when->resolve(3)),
                $this->mapper()
            )->then($mock);
    }

    /** @test */
    public function shouldMapMixedInputArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(2, 4, 6)));

        $when = new When();
        $when
            ->map(
                array(1, $when->resolve(2), 3),
                $this->mapper()
            )->then($mock);
    }

    /** @test */
    public function shouldMapInputWhenMapperReturnsAPromise()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(2, 4, 6)));

        $when = new When();
        $when
            ->map(
                array(1, 2, 3),
                $this->promiseMapper()
            )->then($mock);
    }

    /** @test */
    public function shouldAcceptAPromiseForAnArray()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(array(2, 4, 6)));

        $when = new When();
        $when
            ->map(
                $when->resolve(array(1, $when->resolve(2), 3)),
                $this->mapper()
            )->then($mock);
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
        $when
            ->map(
                $when->resolve(1),
                $this->mapper()
            )->then($mock);
    }

    /** @test */
    public function shouldRejectWhenInputContainsRejection()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(2));

        $when = new When();
        $when
            ->map(
                array($when->resolve(1), $when->reject(2), $when->resolve(3)),
                $this->mapper()
            )->then($this->expectCallableNever(), $mock);
    }
}
