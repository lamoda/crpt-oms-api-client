<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Impl\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Lamoda\OmsClient\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SymfonySerializerAdapterFactory
{
    public const SYMFONY_VERSION_LESS_THAN_42 = 'symfony_version_less_42';
    public const SYMFONY_VERSION_GREATER_OR_EQUAL_42 = 'symfony_version_greater_or_equal_42';

    public static function create(string $symfonyVersion = self::SYMFONY_VERSION_LESS_THAN_42): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $symfonySerializer = new Serializer([
            self::createDateTimeNormalizer($symfonyVersion),
            new ObjectNormalizer($classMetadataFactory),
        ], [
            new JsonEncoder(),
        ]);

        return new SymfonySerializerAdapter($symfonySerializer);
    }

    private static function createDateTimeNormalizer(string $symfonyVersion): DateTimeNormalizer
    {
        // @codeCoverageIgnoreStart
        switch ($symfonyVersion) {
            case self::SYMFONY_VERSION_LESS_THAN_42:
                return new DateTimeNormalizer('Y-m-d');
            case self::SYMFONY_VERSION_GREATER_OR_EQUAL_42:
                return new DateTimeNormalizer([
                    'datetime_format' => 'Y-m-d'
                ]);
        }

        throw new \InvalidArgumentException(sprintf(
            'Given $symfonyVersion is invalid - "%s"',
            $symfonyVersion
        ));
        // @codeCoverageIgnoreEnd
    }
}
