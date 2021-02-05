<?php

namespace Lexide\Chronos\Test;

use Lexide\Chronos\Exception\StopWatchException;
use Lexide\Chronos\StopWatch;
use Lexide\Chronos\TimeProvider\TimeProviderInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class StopWatchTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var TimeProviderInterface|MockInterface
     */
    protected $timeProvider;

    public function setUp(): void
    {
        $this->timeProvider = \Mockery::mock(TimeProviderInterface::class);
    }

    public function testExceptionIfNotStarted()
    {

        $this->timeProvider->shouldNotReceive("get");

        $messagePattern = "/must be started/";

        $stopWatch = new StopWatch($this->timeProvider);

        try {
            $stopWatch->duration();
            $this->fail("Should not have been able to call duration() when the watch is stopped");
        } catch (StopWatchException $e) {
            $this->assertMatchesRegularExpression($messagePattern, $e->getMessage());
        }

        try {
            $stopWatch->stop();
            $this->fail("Should not have been able to call stop() when the watch is stopped");
        } catch (StopWatchException $e) {
            $this->assertMatchesRegularExpression($messagePattern, $e->getMessage());
        }
    }

    public function testReturnsTimeDifference()
    {
        $difference = 5;
        $start = 10;

        $this->timeProvider->shouldReceive("get")->twice()->andReturnValues([$start, $start + $difference]);

        $stopWatch = new StopWatch($this->timeProvider);
        $stopWatch->start();
        $this->assertSame($difference, $stopWatch->duration());
    }

    public function testWatchCanBeStopped()
    {
        $difference = 5;
        $start = 10;

        $this->timeProvider->shouldReceive("get")->twice()->andReturnValues([$start, $start + $difference]);

        $stopWatch = new StopWatch($this->timeProvider);
        $stopWatch->start();

        $this->assertTrue($stopWatch->isRunning());
        $this->assertSame($difference, $stopWatch->stop());
        $this->assertFalse($stopWatch->isRunning());

    }

}
