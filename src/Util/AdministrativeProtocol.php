<?php

namespace Flossiraptor\GearmandManager\Util;

use Flossiraptor\GearmandManager\Response\{
    GMPriorityStatus,
    GmPriorityStatusInterface,
    GmStatus,
    GmStatusInterface,
    GMWorker,
    GmWorkerInterface,
};

/**
 * Utility to parse responses from the administrative protocol.
 */
class AdministrativeProtocol {

    /**
     * Parse the data for a single worker.
     *
     * The format is:
     * FD IP-ADDRESS CLIENT-ID : FUNCTION ...
     *
     * @param string $line
     *  One line from the 'workers' adminstrative command.
     *
     * @return \GearmanUI\Manager\GmWorkerInterface
     *   The worker definition.
     */
    public static function parseWorkerLine(string $line) : GmWorkerInterface {
        [$data, $functions] = explode(':', $line, 2);
        [$fd, $ip, $client_id] = sscanf($data, '%d %s %s');
        $functions = array_filter(explode(' ' , trim($functions)));

        return new GMWorker(
            fd: $fd,
            ip: $ip,
            clientId: $client_id,
            functions: $functions,
        );
    }

    /**
     * Parse the data for a single function status.
     *
     * The format is:
     * FUNCTION\tTOTAL\tRUNNING\tAVAILABLE_WORKERS
     *
     * @param string $line
     *  One line from the 'status' adminstrative command.
     *
     * @return \GearmanUI\Manager\GmStatusInterface
     *   The status for a Gearman function.
     */
    public static function parseStatusLine(string $line) : GmStatusInterface {
        [$name, $queued, $running, $workers] = sscanf($line, "%s\t%d\t%d\t%d");
        return new GMStatus(
            name: $name,
            queued: $queued,
            running: $running,
            workers: $workers,
        );
    }

    /**
     * Parse the data with priority for a single function status.
     *
     * The format is:
     * FUNCTION\tHIGH-QUEUED\tNORMAL-QUEUED\tLOW-QUEUED\tAVAILABLE_WORKERS
     *
     * @param string $line
     *  One line from the 'prioritystatus' adminstrative command.
     *
     * @return \GearmanUI\Manager\GmPriorityStatusInterface
     *   The status with priority for a Gearman function.
     */
    public static function parsePriorityStatusLine(string $line) : GmPriorityStatusInterface {
        [$name, $queuedHigh, $queuedNormal, $queuedLow, $workers] = sscanf($line, "%s\t%d\t%d\t%d\t%d\t%d");
        return new GMPriorityStatus(
            name: $name,
            queuedHigh: $queuedHigh,
            queuedNormal: $queuedNormal,
            queuedLow: $queuedLow,
            workers: $workers,
        );
    }

}
