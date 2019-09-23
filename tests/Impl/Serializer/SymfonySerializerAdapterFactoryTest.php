<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\Impl\Serializer;

use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapter;
use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapterFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapterFactory
 */
final class SymfonySerializerAdapterFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $result = SymfonySerializerAdapterFactory::create();

        $this->assertInstanceOf(SymfonySerializerAdapter::class, $result);
    }
}
