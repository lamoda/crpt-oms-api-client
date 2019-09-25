<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\V2;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Lamoda\OmsClient\Exception\OmsGeneralErrorException;
use Lamoda\OmsClient\Exception\OmsRequestErrorException;
use Lamoda\OmsClient\Serializer\SerializerInterface;
use Lamoda\OmsClient\V2\Dto\CloseICArrayResponse;
use Lamoda\OmsClient\V2\Dto\GetICBufferStatusResponse;
use Lamoda\OmsClient\V2\Dto\GetICsFromOrderResponse;
use Lamoda\OmsClient\V2\Extension;
use Lamoda\OmsClient\V2\OmsApi;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

/**
 * @covers \Lamoda\OmsClient\V2\OmsApi
 */
final class OmsApiTest extends TestCase
{
    private const TOKEN = 'abcdefg12345678';
    private const API_RESPONSE = '{stub_result}';
    private const OMS_ID = '123456';
    private const ORDER_ID = 'af7a55ae-83de-470b-a1bd-6bbf657106ef';
    private const GTIN = '046000012345';
    private const MARKING_CODE = "010467003301005321gJk6o54AQBJfX\u{001d}91ffd0\u{001d}92LGYcm3FRQrRdNOO+8t0pz78QTyxxBmYKhLXaAS03jKV7oy+DWGy1SeU+BZ8o7B8+hs9LvPdNA7B6NPGjrCm34A==";
    private const LAST_BLOCK_ID = '123456';

    /**
     * @var ClientInterface | MockObject
     */
    private $client;
    /**
     * @var SerializerInterface | MockObject
     */
    private $serializer;
    /**
     * @var OmsApi
     */
    private $api;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $this->createMock(ClientInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->api = new OmsApi(
            $this->client,
            $this->serializer
        );
    }

    public function testExceptionWithHttpCode(): void
    {
        $this->client
            ->method('request')
            ->willThrowException(new BadResponseException('Bad response', $this->createMock(RequestInterface::class)));

        $this->expectException(OmsRequestErrorException::class);
        $this->api->getICBufferStatus(Extension::light(), self::TOKEN, self::OMS_ID, self::ORDER_ID, self::GTIN);
    }

    public function testGeneralException(): void
    {
        $this->client
            ->method('request')
            ->willThrowException(new \RuntimeException());

        $this->expectException(OmsGeneralErrorException::class);
        $this->api->getICBufferStatus(Extension::light(), self::TOKEN, self::OMS_ID, self::ORDER_ID, self::GTIN);
    }

    /**
     * @dataProvider dataCorrectUsageOfExtensions
     */
    public function testCorrectUsageOfExtensions(Extension $extension, string $extensionName): void
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                sprintf('api/v2/%s/buffer/status', $extensionName),
                $this->anything()
            )
            ->willReturn(
                (new Response())
                    ->withBody(stream_for(self::API_RESPONSE))
            );

        $expectedResult = new GetICBufferStatusResponse('', '', '', 0, 0, 0, [], '');
        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->willReturn($expectedResult);

        $this->api->getICBufferStatus($extension, self::TOKEN, self::OMS_ID, self::ORDER_ID, self::GTIN);
    }

    public function dataCorrectUsageOfExtensions(): array
    {
        return [
            [
                Extension::light(),
                'light',
            ],
            [
                Extension::pharma(),
                'pharma',
            ],
        ];
    }

    public function testGetICBufferStatus(): void
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                'api/v2/light/buffer/status',
                [
                    RequestOptions::BODY => null,
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                        'clientToken' => self::TOKEN,
                    ],
                    RequestOptions::QUERY => [
                        'omsId' => self::OMS_ID,
                        'orderId' => self::ORDER_ID,
                        'gtin' => self::GTIN,
                    ],
                    RequestOptions::HTTP_ERRORS => true,
                ]
            )
            ->willReturn(
                (new Response())
                    ->withBody(stream_for(self::API_RESPONSE))
            );

        $expectedResult = new GetICBufferStatusResponse('', '', '', 0, 0, 0, [], '');
        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with(
                GetICBufferStatusResponse::class,
                self::API_RESPONSE
            )
            ->willReturn($expectedResult);

        $result = $this->api->getICBufferStatus(Extension::light(), self::TOKEN, self::OMS_ID, self::ORDER_ID,
            self::GTIN);

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetICsFromOrder(): void
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                'api/v2/light/codes',
                [
                    RequestOptions::BODY => null,
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                        'clientToken' => self::TOKEN,
                    ],
                    RequestOptions::QUERY => [
                        'omsId' => self::OMS_ID,
                        'orderId' => self::ORDER_ID,
                        'gtin' => self::GTIN,
                        'quantity' => 2,
                        'lastBlockId' => '1',
                    ],
                    RequestOptions::HTTP_ERRORS => true,
                ]
            )
            ->willReturn(
                (new Response())
                    ->withBody(stream_for(self::API_RESPONSE))
            );

        $expectedResult = new GetICsFromOrderResponse(self::OMS_ID, [self::MARKING_CODE], '2');
        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with(
                GetICsFromOrderResponse::class,
                self::API_RESPONSE
            )
            ->willReturn($expectedResult);

        $result = $this->api->getICsFromOrder(Extension::light(), self::TOKEN, self::OMS_ID, self::ORDER_ID, self::GTIN,
            2, '1');

        $this->assertEquals($expectedResult, $result);
    }

    public function testCloseICArray(): void
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'api/v2/light/buffer/close',
                [
                    RequestOptions::BODY => null,
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                        'clientToken' => self::TOKEN,
                    ],
                    RequestOptions::QUERY => [
                        'omsId' => self::OMS_ID,
                        'orderId' => self::ORDER_ID,
                        'gtin' => self::GTIN,
                        'lastBlockId' => self::LAST_BLOCK_ID,
                    ],
                    RequestOptions::HTTP_ERRORS => true,
                ]
            )
            ->willReturn(
                (new Response())
                    ->withBody(stream_for(self::API_RESPONSE))
            );

        $expectedResult = new CloseICArrayResponse(self::OMS_ID);
        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with(
                CloseICArrayResponse::class,
                self::API_RESPONSE
            )
            ->willReturn($expectedResult);

        $result = $this->api->closeICArray(
            Extension::light(),
            self::TOKEN,
            self::OMS_ID,
            self::ORDER_ID,
            self::GTIN,
            self::LAST_BLOCK_ID
        );

        $this->assertEquals($expectedResult, $result);
    }

}