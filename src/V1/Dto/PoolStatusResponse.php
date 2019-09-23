<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V1\Dto;

final class PoolStatusResponse
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_READY = 'READY';
    public const STATUS_CLOSED = 'CLOSED';

    /**
     * @var string
     */
    private $orderId;
    /**
     * @var string
     */
    private $orderLineId;
    /**
     * @var string
     */
    private $gtin;
    /**
     * @var string
     */
    private $status;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var int
     */
    private $left;

    public function __construct(
        string $orderId,
        string $orderLineId,
        string $gtin,
        string $status,
        int $quantity,
        int $left
    ) {
        $this->orderId = $orderId;
        $this->orderLineId = $orderLineId;
        $this->gtin = $gtin;
        $this->status = $status;
        $this->quantity = $quantity;
        $this->left = $left;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getOrderLineId(): string
    {
        return $this->orderLineId;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getLeft(): int
    {
        return $this->left;
    }
}
