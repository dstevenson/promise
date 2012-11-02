<?php

namespace React\Promise;

/**
 * @group When
 * @group WhenResolve
 */
class WhenResolveTest extends TestCase
{
    /** @test */
    public function shouldResolveAnImmediateValue()
    {
        $expected = 123;

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo($expected));

        $when = new When();
        $when
            ->resolve($expected)
            ->then(
                $mock,
                $this->expectCallableNever()
            );
    }

    /** @test */
    public function shouldResolveAResolvedPromise()
    {
        $expected = 123;

        $d = new Deferred();
        $d->resolve($expected);

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo($expected));

        $when = new When();
        $when
            ->resolve($d->promise())
            ->then(
                $mock,
                $this->expectCallableNever()
            );
    }

    /** @test */
    public function shouldRejectARejectedPromise()
    {
        $expected = 123;

        $d = new Deferred();
        $d->reject($expected);

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo($expected));

        $when = new When();
        $when
            ->resolve($d->promise())
            ->then(
                $this->expectCallableNever(),
                $mock
            );
    }

    /** @test */
    public function shouldSupportDeepNestingInPromiseChains()
    {
        $d = new Deferred();
        $d->resolve(false);
        
        $when = new When();

        $result = $when->resolve($when->resolve($d->then(function ($val) use ($when) {
            $d = new Deferred();
            $d->resolve($val);

            $identity = function ($val) {
                return $val;
            };

            return $when->resolve($d->then($identity))->then(
                function ($val) {
                    return !$val;
                }
            );
        })));

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(true));

        $result->then($mock);
    }
}
