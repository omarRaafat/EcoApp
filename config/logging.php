<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'sms' => [
            'driver' => 'single',
            'path' => storage_path('logs/sms.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'national-warehouse' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Warehouses/national.log'),
            'level' => "info",
            'days' => 30,
        ],

        'torod-shipping' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Shipping/torod.log'),
            'level' => "info",
            'days' => 30,
        ],

        'torod-webhooks' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Webhooks/torod_webhooks.log'),
            'level' => "info",
            'days' => 60,
        ],

        'aramex-shipping' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Shipping/aramex_shipping.log'),
            'level' => "info",
            'days' => 100,
        ],

        'urway' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Urway/urway.log'),
            'level' => "info",
            'days' => 60,
        ],
        'tabby' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/tabby/tabby.log'),
            'level' => "info",
            'days' => 60,
        ],

        'bezz-warehouse-integration' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Warehouse/bezz_warehouse.log'),
            'level' => "info",
            'days' => 60,
        ],

        'transaction-events-errors' => [
            'driver' => 'daily',
            'path' => storage_path('logs/transactions/events/transaction-events-errors.log'),
            'level' => "info",
            'days' => 60,
        ],

        'spl-shipping' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Shipping/spl_shipping.log'),
        ],

        'notifications-events-errors' => [
            'driver' => 'daily',
            'path' => storage_path('logs/notifications/notifications-events-errors.log'),
            'level' => "info",
            'days' => 60,
        ],

        'webengage-events' => [
            'driver' => 'daily',
            'path' => storage_path('logs/Integrations/Webengage/webengage-events.log'),
            'level' => "info",
            'days' => 60,
        ],

        'customer-sms-errors' => [
            'driver' => 'daily',
            'path' => storage_path('logs/customer-sms/customer-sms.log'),
            'level' => "info",
            'days' => 60,
        ],

        'vendor-wallet-transactions' => [
            'driver' => 'daily',
            'path' => storage_path('logs/vendor-wallet/transactions.log'),
            'level' => "info",
            'days' => 60,
        ],
    ],

];
