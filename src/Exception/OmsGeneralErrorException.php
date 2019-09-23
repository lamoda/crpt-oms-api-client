<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Exception;

final class OmsGeneralErrorException extends \RuntimeException implements OmsClientExceptionInterface
{
    public static function becauseOfError(\Throwable $exception): self
    {
        return new static(sprintf(
            'Request to OMS finished with error "%s"',
            $exception->getMessage()
        ), 0, $exception);
    }
}