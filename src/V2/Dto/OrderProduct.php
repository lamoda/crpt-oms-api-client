<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

abstract class OrderProduct
{
    // Способ формирования индивидуального серийного номера
    public const SERIAL_NUMBER_TYPE_SELF_MADE = 'SELF_MADE'; // Самостоятельно
    public const SERIAL_NUMBER_TYPE_OPERATOR = 'OPERATOR'; // Оператором ГИС МТ

    // Тип кода маркировки
    public const MARKING_TYPE_UNIT = 'UNIT'; // Единица товара
    public const MARKING_TYPE_BUNDLE  = 'BUNDLE'; // Комплект
    public const MARKING_TYPE_GROUP = 'GROUP'; // Групповая потребительская упаковка
    public const MARKING_TYPE_SET = 'SET'; // Набор

    // Шаблоны кодов маркировки (пока мы используем только первый)
    public const MARKING_TEMPLATE_FIRST  = 1; // 01 + GTIN + 21 + serial (13 chars)
    public const MARKING_TEMPLATE_SECOND = 2; // 01 + GTIN + 21 + serial (13 chars)

    /**
     * @var string КТ (GTIN) продукта
     */
    private $gtin;
    /**
     * @var int Количество КМ
     */
    private $quantity;
    /**
     * @var string Способ генерации серийных номеров.
     */
    private $serialNumberType;
    /**
     * @var string[] | null Массив серийных номеров (Это поле указывается, если serialNumber = SELF_MADE)
     */
    private $serialNumbers;
    /**
     * @var integer Идентификатор шаблона КМ
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