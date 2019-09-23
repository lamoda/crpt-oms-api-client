<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Impl\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Lamoda\OmsClient\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SymfonySerializerAdapterFactory
{
    public static function create(): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $encoder = new JsonEncoder();

        $symfonySerializer = new Serializer([$normalizer], [$encoder]);

        return new SymfonySerializerAdapter($symfonySerializer);
    }
}
