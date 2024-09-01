<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Status information with queue priorities for a single Gearman function.
 */
class GMPriorityStatus implements GmPriorityStatusInterface
{

    /**
     * Constructor.
     *
     * @param string $name
     *   Name of this Gearman function.
     * @param int $queuedHigh
     *   Number of requests queued with High priority.
     * @param int $queuedNormal
     *   Number of requests queued with Normal priority.
     * @param int $queuedLow
     *   Number of requests queued with Low priority.
     * @param int $workers
     *   Number of workers which can perform this function.
     */
    public function __construct(
        public readonly string $name,
        public readonly int $queuedHigh,
        public readonly int $queuedNormal,
        public readonly int $queuedLow,
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
    public function getQueuedHigh() : int {
        return $this->queuedHigh;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueuedNormal() : int {
        return $this->queuedNormal;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueuedLow() : int {
        return $this->queuedLow;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueued() : int {
        return $this->queuedHigh + $this->queuedNormal + $this->queuedLow;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkers() : int {
        return $this->workers;
    }

}
