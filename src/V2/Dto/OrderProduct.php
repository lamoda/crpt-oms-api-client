<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

abstract class OrderProduct
{
    public const SERIAL_NUMBER_TYPE_SELF_MADE = 'SELF_MADE';
    public const SERIAL_NUMBER_TYPE_OPERATOR = 'OPERATOR';

    /**
     * @var string
     */
    private $gtin;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var string
     */
    private $serialNumberType;
    /**
     * @var string[] | null
     */
    private $serialNumbers;
    /**
     * @var integer
     */
    private $templateId;

    public function __construct(string $gtin, int $quantity, string $serialNumberType, int $templateId)
    {
        $this->gtin = $gtin;
        $this->quantity = $quantity;
        $this->serialNumberType = $serialNumberType;
        $this->templateId = $templateId;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSerialNumberType(): string
    {
        return $this->serialNumberType;
    }

    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    public function getSerialNumbers(): ?array
    {
        return $this->serialNumbers;
    }

    public function setSerialNumbers(?array $serialNumbers): void
    {
        $this->serialNumbers = $serialNumbers;
    }
}