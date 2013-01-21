<?php

namespace React\Promise;

interface CancelablePromiseInterface extends PromiseInterface
{
    public function cancel();
}
