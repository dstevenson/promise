<?php

namespace React\Promise;

interface QueueProcessorInterface
{
    public function processQueue($queue, $value);
}
