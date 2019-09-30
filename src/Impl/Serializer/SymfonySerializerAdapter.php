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
        $result = $this->serializer->deserialize($data, $class, 'json');
        assert(is_object($result));

        return $result;
    }

    public function serialize(object $data): string
    {
        $result = $this->serializer->serialize($data, 'json');
        assert(is_string($result));

        return $result;
    }
}
