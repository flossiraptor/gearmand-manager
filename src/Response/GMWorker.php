<?php

namespace Flossiraptor\GearmandManager\Response;

/**
 * Metadata and capabilities of a Gearman Worker.
 */
class GMWorker implements GmWorkerInterface
{

    /**
     * Constructor.
     *
     * @param int $fd,
     *   File-descriptor used by the job server to identify the worker.
     * @param string $ip,
     *   IP address of the worker.
     * @param string $clientId,
     *   Client ID used by the job server to identify the worker.
     * @param array $functions,
     *   List of Gearman functions which this worker can perform.
     */
    public function __construct(
        public readonly int $fd,
        public readonly string $ip,
        public readonly string $clientId,
        public readonly array $functions,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getFd() : int {
        return $this->fd;
    }

    /**
     * {@inheritdoc}
     */
    public function getIp() : string {
        return $this->ip;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientId() : string {
        return $this->clientId;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() : array {
        return $this->functions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFunction(string $function) : bool {
        return in_array($function, $this->functions);
    }

}
