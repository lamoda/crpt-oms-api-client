<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Serializer;

interface SerializerInterface
{
    public function deserialize(string $class, $data): object;
}
