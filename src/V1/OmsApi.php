<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V1;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Lamoda\OmsClient\Exception\OmsClientExceptionInterface;
use Lamoda\OmsClient\Exception\OmsGeneralErrorException;
use Lamoda\OmsClient\V1\Dto\PoolStatusResponse;
use Lamoda\OmsClient\Exception\OmsRequestErrorException;
use Lamoda\OmsClient\Serializer\SerializerInterface;

/**
 * @deprecated Since 2019.10.01 version 1 of OMS Api is no longer supported by CRPT.
 */
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

    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function poolStatus(string $token, string $orderId, string $orderLineId): PoolStatusResponse
    {
        $result = $this->request($token, 'GET', '/api/poolStatus', [
            'orderId' => $orderId,
            'orderLineId' => $orderLineId,
        ]);

        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->serializer->deserialize(PoolStatusResponse::class, $result);
    }

    public function codes(string $token, string $orderId, string $orderLineId, int $quantity): array
    {
        $result = $this->request($token, 'GET', '/api/codes', [
            'orderId' => $orderId,
            'orderLineId' => $orderLineId,
            'quantity' => $quantity,
        ]);

        try {
            $codes = \GuzzleHttp\json_decode($result, true);
        } catch (\InvalidArgumentException $exception) {
            throw OmsRequestErrorException::becauseOfError(0, $result, $exception);
        }

        if (!is_array($codes)) {
            throw OmsRequestErrorException::becauseResponseIsIncorrect(0, $result);
        }

        return $codes;
    }

    /**
     * @throws OmsClientExceptionInterface
     */
    private function request(string $token, string $method, string $uri, array $query = [], $body = null): string
    {
        $options = [
            RequestOptions::BODY => $body,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'clientToken' => $token,
            ],
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

        return (string) $result->getBody();
    }

    private function handleRequestException(\Throwable $exception): OmsClientExceptionInterface
    {
        if ($exception instanceof BadResponseException) {
            $response = $exception->getResponse();
            $responseBody = $response ? (string) $response->getBody() : '';
            $responseCode = $response ? $response->getStatusCode() : 0;

            return OmsRequestErrorException::becauseOfError($responseCode, $responseBody, $exception);
        }

        return OmsGeneralErrorException::becauseOfError($exception);
    }
}
