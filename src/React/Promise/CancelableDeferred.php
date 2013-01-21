<?php

namespace React\Promise;

class CancelableDeferred implements CancelablePromiseInterface, ResolverInterface, PromisorInterface
{
    private $canceler;
    private $deferred;

    public function __construct($canceler = null)
    {
        $this->canceler = $canceler;
        $this->deferred = new Deferred();
    }

    public function cancel()
    {
        $reason = null;

        if (is_callable($this->canceler)) {
            $reason = call_user_func($this->canceler);
        }

        return $this->deferred->reject($reason);
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        return $this->deferred->then($fulfilledHandler, $errorHandler, $progressHandler);
    }

    public function resolve($result = null)
    {
        return $this->deferred->resolve($result);
    }

    public function reject($reason = null)
    {
        return $this->deferred->reject($reason);
    }

    public function progress($update = null)
    {
        return $this->deferred->progress($update);
    }

    public function promise()
    {
        if (null === $this->promise) {
            $this->promise = new CancelableDeferredPromise($this);
        }

        return $this->promise;
    }

    public function resolver()
    {
        return $this->deferred->resolver();
    }
}
