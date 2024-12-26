<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CreateMonthlyLog
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $log = new Logger('ikp');
        $logFile = storage_path('logs/ikp-' . date('Y-m') . '.log');

        // Check if the file exists, if not, create it
        if (!file_exists($logFile)) {
            file_put_contents($logFile, ""); // Create an empty file
        }

        // Add the log file to Monolog
        $log->pushHandler(new StreamHandler($logFile));

        return $log;
    }
}
