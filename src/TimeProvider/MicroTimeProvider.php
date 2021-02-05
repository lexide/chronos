<?php

namespace Lexide\Chronos\TimeProvider;

class MicroTimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(): float|int
    {
        return microtime(true);
    }
}