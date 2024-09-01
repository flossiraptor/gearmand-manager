<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Status information for a single Gearman function.
 */
class GMStatus implements GmStatusInterface
{

    /**
     * Constructor.
     *
     * @param string $name
     *   Name of this Gearman function.
     * @param int $queued
     *   Number of requests queued with High priority.
     * @param int $running
     *   Number of requests currently running.
     * @param int $workers
     *   Number of workers which can perform this function.
     */
    public function __construct(
        public readonly string $name,
        public readonly int $queued,
        public readonly int $running,
        public readonly int $workers,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueued() : int {
        return $this->queued;
    }

    /**
     * {@inheritdoc}
     */
    public function getRunning() : int {
        return $this->running;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkers() : int {
        return $this->workers;
    }

}
