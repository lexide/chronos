<?php

namespace Lexide\Chronos\TimeProvider;

class MicroTimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return microtime(true);
    }
}