<?php

namespace React\Promise;

class SimpleQueueProcessor implements QueueProcessorInterface
{
    public function processQueue($queue, $value)
    {
        foreach ($queue as $handler) {
            call_user_func($handler, $value);
        }
    }
}
