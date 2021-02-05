<?php

namespace Lexide\Chronos\TimeProvider;

class MilliTimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return floor(microtime(true) / 1000);
    }
}