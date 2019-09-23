<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\Impl\Serializer;

use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapter;
use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapterFactory;
use Lamoda\OmsClient\V2\Dto\GetICsFromOrderResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapter
 */
final class SymfonySerializerAdapterTest extends TestCase
{
    /**
     * @var SymfonySerializerAdapter
     */
    private $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = SymfonySerializerAdapterFactory::create();
    }

    /**
     * @dataProvider dataDeserialize
     */
    public function testDeserialize(string $class, $data, object $expected): void
    {
        $result = $this->serializer->deserialize($class, $data);

        $this->assertEquals($expected, $result);
    }

    public function dataDeserialize(): array
    {
        return [
            [
                GetICsFromOrderResponse::class,
                '{  "omsId" :  "CDF12109-10D3-11E6-8B6F-0050569977A1",  "codes" :  ["010460165303004621\\u003drxDV3M\\u001d93VXQI"],  "blockId" :  "20"}',
                new GetICsFromOrderResponse(
                    'CDF12109-10D3-11E6-8B6F-0050569977A1',
                    [
                        "010460165303004621\x3drxDV3M\x1d93VXQI"
                    ],
                    '20'
                )
            ]
        ];
    }
}
