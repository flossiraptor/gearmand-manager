<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Status information for a single Gearman function.
 */
interface GmStatusInterface
{

    /**
     * Get the name of this Gearman function.
     *
     * @return string
     *   The name of this Gearman function.
     */
    public function getName() : string;

    /**
     * Get the number of requests queued.
     *
     * @return int
     *   The number of requests queued.
     */
    public function getQueued() : int;

    /**
     * Get the number of requests currently running.
     *
     * @return int
     *   The number of requests currently running.
     */
    public function getRunning() : int;

    /**
     * Get the number of workers available for this function.
     *
     * @return int
     *   The number of workers available for this function.
     */
    public function getWorkers() : int;

}
