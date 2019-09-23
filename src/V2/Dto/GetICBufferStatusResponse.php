<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class GetICBufferStatusResponse
{
    public const BUFFER_STATUS_ACTIVE = 'active';
    public const BUFFER_STATUS_CLOSED = 'closed';

    /**
     * @var string
     */
    private $omsId;
    /**
     * @var string
     */
    private $orderId;
    /**
     * @var string
     */
    private $gtin;
    /**
     * @var int
     */
    private $totalCodes;
    /**
     * @var int
     */
    private $unavailableCodes;
    /**
     * @var int
     */
    private $leftInBuffer;
    /**
     * @var PoolInfo[]
     */
    private $poolInfos;
    /**
     * @var string
     */
    private $bufferStatus;

    /**
     * GetICBufferStatusResponse constructor.
     *
     * @param string $omsId
     * @param string $orderId
     * @param string $gtin
     * @param int $totalCodes
     * @param int $unavailableCodes
     * @param int $leftInBuffer
     * @param PoolInfo[] $poolInfos
     * @param string $bufferStatus
     */
    public function __construct(
        string $omsId,
        string $orderId,
        string $gtin,
        int $totalCodes,
        int $unavailableCodes,
        int $leftInBuffer,
        array $poolInfos,
        string $bufferStatus
    ) {
        $this->omsId = $omsId;
        $this->orderId = $orderId;
        $this->gtin = $gtin;
        $this->totalCodes = $totalCodes;
        $this->unavailableCodes = $unavailableCodes;
        $this->leftInBuffer = $leftInBuffer;
        $this->poolInfos = $poolInfos;
        $this->bufferStatus = $bufferStatus;
    }

    public function getOmsId(): string
    {
        return $this->omsId;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function getTotalCodes(): int
    {
        return $this->totalCodes;
    }

    public function getUnavailableCodes(): int
    {
        return $this->unavailableCodes;
    }

    public function getLeftInBuffer(): int
    {
        return $this->leftInBuffer;
    }

    /**
     * @return PoolInfo[]
     */
    public function getPoolInfos(): array
    {
        return $this->poolInfos;
    }

    public function getBufferStatus(): string
    {
        return $this->bufferStatus;
    }
}
