<?php

namespace Flossiraptor\GearmandManager;

use Flossiraptor\GearmandManager\Exception\GearmandUnreachableException;
use Flossiraptor\GearmandManager\Util\AdministrativeProtocol;

/**
 * Query the information available from a Gearmand job server.
 */
class Manager
{

    /**
     * The default IP address of the Gearmand job server.
     */
    const string DEFAULT_GEARMAND_HOST = '127.0.0.1';

    /**
     * The default port where the Gearmand job server listens.
     */
    const int DEFAULT_GEARMAND_PORT = 4730;

    /**
     * A socket connection to the Gearmand job server.
     */
    protected $socket;

    /**
     * Constructor.
     *
     * @param string $host
     *   Hostname/IP address of the Gearmand job server. Defaults to 127.0.0.1.
     * @param int $port
     *   Port where the Gearmand job server is listening. Defaults to 4730.
     */
    public function __construct(
        protected string $host = self::DEFAULT_GEARMAND_HOST,
        protected int $port = self::DEFAULT_GEARMAND_PORT,
    ) {
        $this->socket = @fsockopen($host, $port);
        if ($this->socket === FALSE)
        {
            throw new GearmandUnreachableException('The Gearmand job server could not be reached');
        }
    }

    /**
     * Close the connection to the Gearmand job server.
     */
    public function __destruct() {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() : array {
        return array_column($this->status(), 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function workers() : array {
        $result = [];
        foreach ($this->send('workers') as $line) {
            $result[] = AdministrativeProtocol::parseWorkerLine($line);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function status() : array {
        $result = [];
        foreach ($this->send('status') as $line) {
            $status = AdministrativeProtocol::parseStatusLine($line);
            $result[$status->name] = $status;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function prioritystatus() : array {
        $result = [];
        foreach ($this->send('prioritystatus') as $line) {
            $status = AdministrativeProtocol::parsePriorityStatusLine($line);
            $result[$status->name] = $status;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function maxqueue(
        string $function,
        int $maxQueueSize = ManagerInterface::NO_QUEUE_LIMIT,
    ) : void
    {
        $command = sprintf('maxqueue %s %d', $function, $maxQueueSize);
        $this->send($command)->current();
    }

    /**
     * {@inheritdoc}
     */
    public function maxqueueWithPriorities(
        string $function,
        int $maxQueueSizeHigh = ManagerInterface::NO_QUEUE_LIMIT,
        int $maxQueueSizeNormal = ManagerInterface::NO_QUEUE_LIMIT,
        int $maxQueueSizeLow = ManagerInterface::NO_QUEUE_LIMIT,
    ) : void
    {
        $command = sprintf(
            'maxqueue %s %d %d %d',
            $function,
            $maxQueueSizeHigh,
            $maxQueueSizeNormal,
            $maxQueueSizeLow,
        );
        $this->send($command)->current();
    }

    /**
     * {@inheritdoc}
     */
    public function version(): string {
        return $this->send('version')->current();
    }

    /**
     * Send a message to the Gearmand job server and process the results.
     *
     * @return \Generator
     *   Each line of the response from the job server.
     */
    protected function send($request) : \Generator {
        fwrite($this->socket, "{$request}\n", strlen($request) + 1);
        while ($line = fgets($this->socket)) {
            $line = trim($line);
            if ($line === '.') {
                return;
            }
            yield $line;
        }
    }

}
