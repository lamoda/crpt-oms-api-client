<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Lamoda\OmsClient\Exception\OmsClientExceptionInterface;
use Lamoda\OmsClient\Exception\OmsGeneralErrorException;
use Lamoda\OmsClient\Exception\OmsRequestErrorException;
use Lamoda\OmsClient\Exception\OmsSignerErrorException;
use Lamoda\OmsClient\Serializer\SerializerInterface;
use Lamoda\OmsClient\V2\Dto\CloseICArrayResponse;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequest;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICResponse;
use Lamoda\OmsClient\V2\Dto\GetICBufferStatusResponse;
use Lamoda\OmsClient\V2\Dto\GetICsFromOrderResponse;
use Lamoda\OmsClient\V2\Dto\PingResponse;
use Lamoda\OmsClient\V2\Signer\SignerInterface;

final class OmsApi
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var RequestToExtension
     */
    private $requestToExtension;

    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->requestToExtension = new RequestToExtension();
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function createOrderForEmissionIC(
        string $token,
        string $omsId,
        CreateOrderForEmissionICRequest $request,
        SignerInterface $signer = null
    ): CreateOrderForEmissionICResponse {
        $extension = $this->requestToExtension->getExtensionByCreateOrderForEmissionICRequest($request);

        $url = sprintf('/api/v2/%s/orders', (string)$extension);
        $body = $this->serializer->serialize($request);

        $headers = [];
        $headers = $this->appendSignatureHeader($headers, $body, $signer);

        $result = $this->request($token, 'POST', $url, [
            'omsId' => $omsId,
        ], $body, $headers);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(CreateOrderForEmissionICResponse::class, $result);
    }

    public function getICBufferStatus(
        Extension $extension,
        string $token,
        string $omsId,
        string $orderId,
        string $gtin
    ): GetICBufferStatusResponse {
        $url = sprintf('/api/v2/%s/buffer/status', (string)$extension);
        $result = $this->request($token, 'GET', $url, [
            'omsId' => $omsId,
            'orderId' => $orderId,
            'gtin' => $gtin,
        ]);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(GetICBufferStatusResponse::class, $result);
    }

    public function getICsFromOrder(
        Extension $extension,
        string $token,
        string $omsId,
        string $orderId,
        string $gtin,
        int $quantity,
        string $lastBlockId = '0'
    ): GetICsFromOrderResponse {
        $url = sprintf('/api/v2/%s/codes', (string)$extension);
        $result = $this->request($token, 'GET', $url, [
            'omsId' => $omsId,
            'orderId' => $orderId,
            'gtin' => $gtin,
            'quantity' => $quantity,
            'lastBlockId' => $lastBlockId,
        ]);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(GetICsFromOrderResponse::class, $result);
    }

    public function closeICArray(
        Extension $extension,
        string $token,
        string $omsId,
        string $orderId,
        string $gtin,
        string $lastBlockId
    ): CloseICArrayResponse {
        $url = sprintf('/api/v2/%s/buffer/close', (string)$extension);
        $result = $this->request($token, 'POST', $url, [
            'omsId' => $omsId,
            'orderId' => $orderId,
            'gtin' => $gtin,
            'lastBlockId' => $lastBlockId,
        ]);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(CloseICArrayResponse::class, $result);
    }

    public function ping(Extension $extension, string $token, string $omsId): PingResponse
    {
        $url = sprintf('/api/v2/%s/ping', (string)$extension);
        $result = $this->request($token, 'GET', $url, ['omsId' => $omsId]);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(PingResponse::class, $result);
    }

    /**
     * @throws OmsRequestErrorException
     */
    private function request(
        string $token,
        string $method,
        string $uri,
        array $query = [],
        $body = null,
        $headers = []
    ): string {
        $options = [
            RequestOptions::BODY => $body,
            RequestOptions::HEADERS => array_merge($headers, [
                'Content-Type' => 'application/json',
                'clientToken' => $token,
            ]),
            RequestOptions::QUERY => $query,
            RequestOptions::HTTP_ERRORS => true,
        ];

        $uri = ltrim($uri, '/');

        try {
            $result = $this->client->request($method, $uri, $options);
        } catch (\Throwable $exception) {
            /* @noinspection PhpUnhandledExceptionInspection */
            throw $this->handleRequestException($exception);
        }

        return (string)$result->getBody();
    }

    private function handleRequestException(\Throwable $exception): OmsClientExceptionInterface
    {
        if ($exception instanceof BadResponseException) {
            $response = $exception->getResponse();
            $responseBody = $response ? (string)$response->getBody() : '';
            $responseCode = $response ? $response->getStatusCode() : 0;

            return OmsRequestErrorException::becauseOfError($responseCode, $responseBody, $exception);
        }

        return OmsGeneralErrorException::becauseOfError($exception);
    }

    private function appendSignatureHeader(array $headers, string $data, SignerInterface $signer = null): array
    {
        if ($signer === null) {
            return $headers;
        }

        try {
            $headers['X-Signature'] = $signer->sign($data);
        } catch (\Throwable $exception) {
            throw OmsSignerErrorException::becauseOfError($exception);
        }

        return $headers;
    }
}
