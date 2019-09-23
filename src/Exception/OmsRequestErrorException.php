<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Exception;

final class OmsRequestErrorException extends \RuntimeException implements OmsClientExceptionInterface
{
    /**
     * @var string
     */
    private $response;
    /**
     * @var int
     */
    private $responseCode;

    private function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function becauseOfError(int $responseCode, string $response, \Throwable $exception): self
    {
        $self = new static('Request to OMS finished with error', 0, $exception);
        $self->response = $response;
        $self->responseCode = $responseCode;

        return $self;
    }

    public static function becauseResponseIsIncorrect(int $responseCode, string $response): self
    {
        $self = new static('Request to OMS is incorrect');
        $self->response = $response;
        $self->responseCode = $responseCode;

        return $self;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
