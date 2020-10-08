<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class OrderProductShoes extends OrderProduct
{
    /**
     * @var string ИНН/УНБ (или аналог) экспортера (становится обязательным, если поле releaseMethod =  «CROSSBORDER»)
     */
    private $exporterTaxpayerId;

    public function getExporterTaxpayerId(): ?string
    {
        return $this->exporterTaxpayerId;
    }

    public function setExporterTaxpayerId(?string $exporterTaxpayerId): void
    {
        $this->exporterTaxpayerId = $exporterTaxpayerId;
    }
}