<?php

namespace App;

use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Http\Client\PendingRequest;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;

class HttpFactory extends \Illuminate\Http\Client\Factory
{
    /**
     * Create a new pending request instance for this factory.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function newPendingRequest()
    {
        $log = new Logger('HttpLogger');

        $log->pushHandler(
            new StreamHandler(
                storage_path(sprintf('logs/http/%d/%d/%s.log', date('Y'), date('m'), date('Y-m-d')))
            )
        );

        return (new PendingRequest($this))
            ->withOptions(['verify' => false])
            ->withMiddleware(Middleware::mapResponse(function (ResponseInterface $response) {
                $response->getBody()->rewind();

                return $response;
            }))->withMiddleware(Middleware::log(
                $log,
                new MessageFormatter('{method} {url} {req_body} - {code} - {res_body}')
            ));
    }
}
