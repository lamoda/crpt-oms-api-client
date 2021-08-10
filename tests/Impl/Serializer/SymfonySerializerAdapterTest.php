<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\Impl\Serializer;

use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapterFactory;
use Lamoda\OmsClient\Serializer\SerializerInterface;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLight;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLp;
use Lamoda\OmsClient\V2\Dto\GetICsFromOrderResponse;
use Lamoda\OmsClient\V2\Dto\OrderProductLight;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapter
 */
final class SymfonySerializerAdapterTest extends TestCase
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = SymfonySerializerAdapterFactory::create(SymfonySerializerAdapterFactory::SYMFONY_VERSION_GREATER_OR_EQUAL_42);
    }

    /**
     * @dataProvider dataDeserialize
     */
    public function testDeserialize(string $class, string $data, object $expected): void
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
                        "010460165303004621\x3drxDV3M\x1d93VXQI",
                    ],
                    '20'
                ),
            ],
        ];
    }

    /**
     * @dataProvider dataSerialize
     */
    public function testSerialize(object $data, string $expected): void
    {
        $result = $this->serializer->serialize($data);

        $this->assertJsonStringEqualsJsonString($expected, $result);
    }

    public function dataSerialize(): array
    {
        return [
            [
                new CreateOrderForEmissionICRequestLp(
                    'Ivan Ivanov',
                    CreateOrderForEmissionICRequestLight::RELEASE_METHOD_TYPE_IMPORT,
                    CreateOrderForEmissionICRequestLight::CREATE_METHOD_TYPE_SELF_MADE,
                    'a1f83800-7329-4749-97f0-bbd831aaa9d1',
                    [
                        new OrderProductLight(
                            '0461234567',
                            12,
                            OrderProductLight::SERIAL_NUMBER_TYPE_OPERATOR,
                            2
                        ),
                    ]
                ),
                <<<JSON
{
  "contactPerson": "Ivan Ivanov",
  "releaseMethodType": "IMPORT",
  "createMethodType": "SELF_MADE",
  "productionOrderId": "a1f83800-7329-4749-97f0-bbd831aaa9d1",
  "products": [
    {
      "gtin": "0461234567",
      "quantity": 12,
      "serialNumberType": "OPERATOR",
      "templateId": 2,
      "serialNumbers": null
    }
  ]
}
JSON
            ],
        ];
    }
}
