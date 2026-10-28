<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\ExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Setup how the exception handler works.
 */
class Exceptions extends BaseConfig
{
    /**
     * If true, then exceptions will be logged through Services::Log.
     */
    public bool $log = true;

    /**
     * Any status codes here will NOT be logged if logging is turned on.
     * @var list<int>
     */
    public array $ignoreCodes = [404];

    /**
     * Path to the directory that contains error views.
     */
    public string $errorViewPath = APPPATH . 'Views/errors';

    /**
     * Any data that you would like to hide from the debug trace.
     * @var list<string>
     */
    public array $sensitiveDataInTrace = [];

    /**
     * If set to `true`, DEPRECATED errors are only logged and no exceptions are thrown.
     */
    public bool $logDeprecations = true;

    /**
     * Log level threshold for deprecations.
     */
    public string $deprecationLogLevel = LogLevel::WARNING;

    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        return new ExceptionHandler($this);
    }
}
