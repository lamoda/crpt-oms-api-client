<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class PoolInfo
{
    public const STATUS_REQUEST_ERROR = 'REQUEST_ERROR';
    public const STATUS_REQUESTED = 'REQUESTED';
    public const STATUS_IN_PROCESS = 'IN_PROCESS';
    public const STATUS_READY = 'READY';
    public const STATUS_CLOSED = 'CLOSED';
    public const STATUS_DELETED = 'DELETED';
    public const STATUS_REJECTED = 'REJECTED';

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
    private $leftInRegistrar;
    /**
     * @var string
     */
    private $registrarId;
    /**
     * @var bool
     */
    private $isRegistrarReady;
    /**
     * @var int
     */
    private $registrarErrorCount;
    /**
     * @var int
     */
    private $lastRegistrarErrorTimestamp;

    public function __construct(
        string $status,
        int $quantity,
        int $leftInRegistrar,
        string $registrarId,
        bool $isRegistrarReady,
        int $registrarErrorCount,
        int $lastRegistrarErrorTimestamp
    ) {
        $this->status = $status;
        $this->quantity = $quantity;
        $this->leftInRegistrar = $leftInRegistrar;
        $this->registrarId = $registrarId;
        $this->isRegistrarReady = $isRegistrarReady;
        $this->registrarErrorCount = $registrarErrorCount;
        $this->lastRegistrarErrorTimestamp = $lastRegistrarErrorTimestamp;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getLeftInRegistrar(): int
    {
        return $this->leftInRegistrar;
    }

    public function getRegistrarId(): string
    {
        return $this->registrarId;
    }

    public function isRegistrarReady(): bool
    {
        return $this->isRegistrarReady;
    }

    public function getRegistrarErrorCount(): int
    {
        return $this->registrarErrorCount;
    }

    public function getLastRegistrarErrorTimestamp(): int
    {
        return $this->lastRegistrarErrorTimestamp;
    }
}
