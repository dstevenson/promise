<?php

namespace React\Promise;

/**
 * @group QueueProcessor
 * @group SimpleQueueProcessor
 */
class SimpleQueueProcessorTest extends TestCase
{
    /** @test */
    public function shouldProcessCallbackArrayWithValue()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));
        
        $mock2 = $this->createCallableMock();
        $mock2
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(1));
        
        $p = new SimpleQueueProcessor();
        $p->processQueue(array($mock, $mock2), 1);
    }
}
