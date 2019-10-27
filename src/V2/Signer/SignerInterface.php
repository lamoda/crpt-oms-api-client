<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Signer;

interface SignerInterface
{
    public function sign(string $data): string;
}