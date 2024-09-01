<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Status information with queue priorities for a single Gearman function.
 */
interface GmPriorityStatusInterface
{

    /**
     * Get the name of this Gearman function.
     *
     * @return string
     *   The name of this Gearman function.
     */
    public function getName() : string;

    /**
     * Get the number of requests queued with High priority.
     *
     * @return int
     *   The number of requests queued with High priority.
     */
    public function getQueuedHigh() : int;

    /**
     * Get the number of requests queued with Normal priority.
     *
     * @return int
     *   The number of requests queued with Normal priority.
     */
    public function getQueuedNormal() : int;

    /**
     * Get the number of requests queued.
     *
     * @return int
     *   The number of requests queued.
     */
    public function getQueued() : int;

    /**
     * Get number of requests queued with Low priority.
     *
     * @return int
     *   The number of requests queued with Low priority.
     */
    public function getQueuedLow() : int;

    /**
     * Get the number of workers available for this function.
     *
     * @return int
     *   The number of workers available for this function.
     */
    public function getWorkers() : int;

}
