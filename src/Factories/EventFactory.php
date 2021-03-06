<?php

namespace Juhasev\LaravelSes\Factories;

class EventFactory
{
    /**
     * Create processor class
     *
     * @param string $eventName
     * @param string $modelName
     * @param int $modelId
     * @return EventInterface
     */
    public static function create(string $eventName, string $modelName, int $modelId): EventInterface
    {
        $class = 'Juhasev\\LaravelSes\\Factories\\Events\\Ses' . $eventName. 'Event';

        return new $class($modelName,$modelId);
    }
}
