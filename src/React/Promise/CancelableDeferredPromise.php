<?php

namespace React\Promise;

class CancelableDeferredPromise implements CancelablePromiseInterface
{
    private $deferred;

    public function __construct(CancelableDeferred $deferred)
    {
        $this->deferred = $deferred;
    }

    public function cancel()
    {
        return $this->deferred->cancel();
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        return $this->deferred->then($fulfilledHandler, $errorHandler, $progressHandler);
    }
}
