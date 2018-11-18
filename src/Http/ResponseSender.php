<?php

declare(strict_types = 1);

namespace Larium\Http;

use Psr\Http\Message\ResponseInterface;

class ResponseSender
{
    private $response;

    public static function new(ResponseInterface $response): self
    {
        return new self($response);
    }

    public function send(): string
    {
        if (!headers_sent()) {
            header(
                sprintf(
                    'HTTP/%s %s %s',
                    $this->response->getProtocolVersion(),
                    $this->response->getStatusCode(),
                    $this->response->getReasonPhrase()
                ),
                true,
                $this->response->getStatusCode()
            );

            foreach ($this->response->getHeaders() as $header => $values) {
                foreach ($values as $value) {
                    header($header.': '.$value, false, $this->response->getStatusCode());
                }
            }
        }

        return $this->response->getBody()->__toString();
    }

    private function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
