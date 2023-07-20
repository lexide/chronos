<?php

namespace Lexide\Chronos\TimeSkipper;

class TimeSkipper implements TimeSkipperInterface
{

    /**
     * {@inheritDoc}
     */
    public function skip(float|int $seconds): void
    {
        sleep((int) $seconds);
    }

}