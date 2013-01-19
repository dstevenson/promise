<?php

namespace React\Promise;

/**
 * @group CancelableDeferred
 */
class CancelableDeferredTest extends TestCase
{
    /** @test */
    public function shouldPropagateARejectionWhenACancelableDeferredIsCanceled()
    {
        $canceler = $this->createCallableMock();
        $canceler
            ->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(1));

        $d = new CancelableDeferred($canceler);
        $d->cancel();

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $d->then($this->expectCallableNever(), $mock);
    }

    /** @test */
    public function shouldReturnAPromiseForCanceledValueWhenCanceled()
    {
        $canceler = $this->createCallableMock();
        $canceler
            ->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue(1));

        $d = new CancelableDeferred($canceler);
        $promise = $d->cancel();

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $promise->then($this->expectCallableNever(), $mock);
    }

    /** @test */
    public function shouldNotInvokeCancelerWhenRejectedNormally()
    {
        $canceler = $this->createCallableMock();
        $canceler
            ->expects($this->never())
            ->method('__invoke');

        $d = new CancelableDeferred($canceler);
        $d->reject(2);

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(2));

        $d->then($this->expectCallableNever(), $mock);
    }

    /** @test */
    public function shouldPropagateTheUnalteredResolutionValue()
    {
        $d = new CancelableDeferred(function () {});
        $d->resolve(2);

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(2));

        $d->then($mock);
    }

    /** @test */
    public function shouldCallProgbackForCancelableDeferred()
    {
        $d = new CancelableDeferred(function () {});

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));

        $d->then($this->expectCallableNever(), $this->expectCallableNever(), $mock);
        $d->progress(1);
    }
}
