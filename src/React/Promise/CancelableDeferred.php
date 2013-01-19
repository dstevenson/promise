<?php

namespace React\Promise;

class CancelableDeferred implements PromiseInterface, ResolverInterface, PromisorInterface
{
    private $canceler;
    private $deferred;

    public function __construct($canceler)
    {
        $this->canceler = $canceler;
        $this->deferred = new Deferred();
    }

    public function cancel()
    {
        return $this->deferred->reject(call_user_func($this->canceler));
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
        return $this->deferred->promise();
    }

    public function resolver()
    {
        return $this->deferred->resolver();
    }
}
