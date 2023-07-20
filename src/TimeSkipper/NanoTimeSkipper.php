<?php

namespace Lexide\Chronos\TimeSkipper;

class NanoTimeSkipper implements TimeSkipperInterface
{

    /**
     * {@inheritDoc}
     */
    public function skip(float|int $seconds): void
    {
        time_nanosleep((int) $seconds, fmod($seconds, 1));
    }

}