<?php

namespace Flossiraptor\GearmandManager;

/**
 * Query the information available from a Gearmand job server.
 */
interface ManagerInterface
{

    /**
     * The `maxqueue` command interprets 0 (or a negative number) as unlimited.
     */
    const NO_QUEUE_LIMIT = 0;

    /**
     * List the functions available to the Gearmand job server.
     *
     * @return string[]
     *   The names of each function available.
     */
    public function getFunctions() : array;

    /**
     * List the workers which are available to the job server.
     *
     * @return \Flossiraptor\GearmandManager\Response\GmWorkerInterface[]
     *   List of workers available.
     */
    public function workers() : array;

    /**
     * Get the metadata available for each function.
     *
     * @return \Flossiraptor\GearmandManager\Response\GmStatusInterface[]
     *   Metadata for each function, indexed by function name.
     */
    public function status() : array;

    /**
     * Get the metadata including priorities for each function.
     *
     * @return \Flossiraptor\GearmandManager\Response\GmPriorityStatusInterface[]
     *   Metadata with priorities for each function, indexed by function name.
     */
    public function prioritystatus() : array;

    /**
     * Fetch the version of the job server.
     *
     * @return string
     *   The version identifier provided by the job server.
     */
    public function version(): string;

    /**
     * Set the maximum queue size for a function.
     *
     * @param string $function
     *   The name of the gearman function.
     * @param int $maxQueueSize
     *   The maximum queue size for all priorities.
     */
    public function maxqueue(
        string $function,
        int $maxQueueSize = self::NO_QUEUE_LIMIT,
    ) : void;

    /**
     * Set the maximum queue size for each priority for a function.
     *
     * @param string $function
     *   The name of the gearman function.
     * @param int $maxQueueSizeHigh
     *   The maximum queue size for high priority requests.
     * @param int $maxQueueSizeNormal
     *   The maximum queue size for normal priority requests.
     * @param int $maxQueueSizeLow
     *   The maximum queue size for low priority requests.
     */
    public function maxqueueWithPriorities(
        string $function,
        int $maxQueueSizeHigh = ManagerInterface::NO_QUEUE_LIMIT,
        int $maxQueueSizeNormal = ManagerInterface::NO_QUEUE_LIMIT,
        int $maxQueueSizeLow = ManagerInterface::NO_QUEUE_LIMIT,
    ) : void;

}
