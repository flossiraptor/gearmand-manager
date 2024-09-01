<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Metadata and capabilities of a Gearman Worker.
 */
interface GmWorkerInterface
{

    /**
     * Get the file-descriptor used by the job server to identify the worker.
     *
     * @return int
     *   The file-descriptor.
     */
    public function getFd() : int;

    /**
     * Get the IP address of the worker.
     *
     * @return int
     *   The IP address of the worker.
     */
    public function getIp() : string;

    /**
     * Get the client ID used by the job server to identify the worker.
     *
     * @return string
     *   The client ID used by the job server to identify the worker.
     */
    public function getClientId() : string;

    /**
     * Get the list of Gearman functions which this worker can perform.
     *
     * @return string[]
     *   The list of Gearman functions which this worker can perform.
     */
    public function getFunctions() : array;

    /**
     * Test if this worker can perform a Gearman function.
     *
     * @param string $function
     *   The name of the Gearman function.
     *
     * @return bool
     *   TRUE if this worker can perform the function.
     */
    public function hasFunction(string $function) : bool;

}
