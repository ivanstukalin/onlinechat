<?php

namespace App\Http;

use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Slim\Psr7\Factory\StreamFactory;

class HttpRequestFactory
{
    public function __construct(
        private StreamFactory $streamFactory = new StreamFactory(),
        private UriFactory $uriFactory = new UriFactory(),
    )
    {
    }

    public function prepare(): RequestInterface {
        $method   = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $headers  = new Headers(getallheaders());
        $url      = $this->uriFactory->createUri(urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $body     = $this->streamFactory->createStream();
        $cookies  = $_COOKIE;

        return new Request(
            $method,
            $url,
            $headers,
            $cookies,
            [],
            $body
        );
    }
}