<?php

namespace Lamoda\OmsClient\V2\Dto;

final class GetIntegrationConnectionResponse
{
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_REJECTED = 'REJECTED';

    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $omsConnection;

    /**
     * @var string|null
     */
    private $rejectionReason;

    /**
     * @param string $status
     * @param string|null $omsConnection
     * @param string|null $rejectionReason
     */
    public function __construct(string $status, ?string $omsConnection, ?string $rejectionReason)
    {
        $this->status = $status;
        $this->omsConnection = $omsConnection;
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getOmsConnection(): ?string
    {
        return $this->omsConnection;
    }

    /**
     * @return string|null
     */
    public function getRejectionReason(): ?string
    {
        return $this->rejectionReason;
    }
}