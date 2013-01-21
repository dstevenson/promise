<?php

namespace React\Promise;

/**
 * @group CancelablePromise
 * @group CancelableDeferredPromise
 */
class CancelableDeferredPromiseTest extends TestCase
{
    /** @test */
    public function shouldForwardToDeferred()
    {
        $mock = $this->getMock('React\\Promise\\CancelableDeferred');
        $mock
            ->expects($this->once())
            ->method('then')
            ->with(1, 2, 3);

        $mock
            ->expects($this->once())
            ->method('cancel');

        $p = new CancelableDeferredPromise($mock);
        $p->then(1, 2, 3);
        $p->cancel();
    }
}
