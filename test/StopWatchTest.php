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

    public function testZeroIfNotStarted()
    {

        $this->timeProvider->shouldNotReceive("get");

        $stopWatch = new StopWatch($this->timeProvider);

        $this->assertSame(0, $stopWatch->duration());
        $this->assertSame(0, $stopWatch->stop());
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

    public function testIntervalMode()
    {
        $start = 10;
        $intervals = [3, 17, 7, 12];
        $times = [$start];
        $running = $start;
        foreach ($intervals as $interval) {
            $running += $interval;
            $times[] = $running;
        }

        $this->timeProvider->shouldReceive("get")->andReturnValues($times);

        $stopWatch = new StopWatch($this->timeProvider, true);
        $stopWatch->start();

        foreach ($intervals as $interval) {
            $this->assertSame($interval, $stopWatch->duration());
        }

    }

}
