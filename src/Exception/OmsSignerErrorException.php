<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Exception;

final class OmsSignerErrorException extends \RuntimeException implements OmsClientExceptionInterface
{
    public static function becauseOfError(\Throwable $exception): self
    {
        return new static(sprintf(
            'Signer request finished with an error "%s"',
            $exception->getMessage()
        ), 0, $exception);
    }
}