<?php

namespace Lexide\Chronos\TimeProvider;

class MilliTimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(): float|int
    {
        return floor(microtime(true) * 1000) / 1000;
    }
}