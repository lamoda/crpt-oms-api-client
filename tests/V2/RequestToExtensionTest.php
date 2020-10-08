<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\V2;

use Lamoda\OmsClient\Exception\OmsGeneralErrorException;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequest;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLight;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLp;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestPerfum;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestShoes;
use Lamoda\OmsClient\V2\Extension;
use Lamoda\OmsClient\V2\RequestToExtension;
use PHPUnit\Framework\TestCase;

final class RequestToExtensionTest extends TestCase
{
    /**
     * @var RequestToExtension
     */
    private $requestToExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestToExtension = new RequestToExtension();
    }

    /**
     * @dataProvider dataCreateOrderForEmissionICRequestToExtensionInvalid
     */
    public function testCreateOrderForEmissionICRequestToExtensionInvalid($request)
    {
        $this->expectException(OmsGeneralErrorException::class);

        $this->requestToExtension->getExtensionByCreateOrderForEmissionICRequest($request);
    }

    /**
     * @dataProvider dataCreateOrderForEmissionICRequestToExtensionValid
     */
    public function testCreateOrderForEmissionICRequestToExtensionValid(
        CreateOrderForEmissionICRequest $request,
        Extension $expectedExtension
    ): void {
        $extension = $this->requestToExtension->getExtensionByCreateOrderForEmissionICRequest($request);

        $this->assertEquals((string)$expectedExtension, (string)$extension);
    }

    public function dataCreateOrderForEmissionICRequestToExtensionValid(): array
    {
        return [
            [
                'request' => new CreateOrderForEmissionICRequestLight('', '', '', '', '', new \DateTime(), []),
                'expectedExtension' => Extension::light()
            ],
            [
                'request' => new CreateOrderForEmissionICRequestLp('', '', '', '', []),
                'expectedExtension' => Extension::lp()
            ],
            [
                'request' => new CreateOrderForEmissionICRequestPerfum('', '', '', '', []),
                'expectedExtension' => Extension::perfum()
            ],
            [
                'request' => new CreateOrderForEmissionICRequestShoes('', '', '', '', []),
                'expectedExtension' => Extension::shoes()
            ],
        ];
    }

    public function dataCreateOrderForEmissionICRequestToExtensionInvalid(): iterable
    {
        yield [
            'request' => new class() extends CreateOrderForEmissionICRequest {
                public function __construct()
                {
                    parent::__construct([]);
                }
            }
        ];
    }
}
