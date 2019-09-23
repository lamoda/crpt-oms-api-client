<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Impl\Serializer;

use Lamoda\OmsClient\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

final class SymfonySerializerAdapter implements SerializerInterface
{
    /**
     * @var SymfonySerializer
     */
    private $serializer;

    public function __construct(SymfonySerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function deserialize(string $class, $data): object
    {
        return $this->serializer->deserialize($data, $class, 'json');
    }
}
