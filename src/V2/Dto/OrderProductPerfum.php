<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class OrderProductPerfum extends OrderProduct
{
    /**
     * @var string Тип кода маркировки
     */
    private $cisType;

    /**
     * @var string ИНН/УНБ (или аналог) экспортера (становится обязательным, если поле releaseMethod =  «CROSSBORDER»)
     */
    private $exporterTaxpayerId;


    public function __construct(string $gtin, int $quantity, string $serialNumberType, int $templateId, string $cisType)
    {
        parent::__construct($gtin, $quantity, $serialNumberType, $templateId);

        $this->cisType = $cisType;
    }

    public function getCisType(): string
    {
        return $this->cisType;
    }

    public function getExporterTaxpayerId(): ?string
    {
        return $this->exporterTaxpayerId;
    }

    public function setExporterTaxpayerId(?string $exporterTaxpayerId): void
    {
        $this->exporterTaxpayerId = $exporterTaxpayerId;
    }
}