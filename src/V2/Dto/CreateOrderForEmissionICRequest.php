<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

abstract class CreateOrderForEmissionICRequest
{
    // Способ выпуска товаров в оборот
    public const RELEASE_METHOD_TYPE_PRODUCTION = 'PRODUCTION'; // Производство в РФ
    public const RELEASE_METHOD_TYPE_IMPORT = 'IMPORT'; // Ввезен в РФ (Импорт)
    public const RELEASE_METHOD_TYPE_REMAINS = 'REMAINS'; // Маркировка остатков
    public const RELEASE_METHOD_TYPE_CROSSBORDER = 'CROSSBORDER'; // Ввезен в РФ из стран ЕАЭС
    public const RELEASE_METHOD_TYPE_REMARK = 'REMARK'; // Перемаркировка

    // Способ изготовления
    public const CREATE_METHOD_TYPE_SELF_MADE = 'SELF_MADE'; // Самостоятельно
    public const CREATE_METHOD_TYPE_CEM = 'CEM'; // ЦЭМ
    public const CREATE_METHOD_TYPE_CM = 'CM'; // Контрактное производство
    public const CREATE_METHOD_TYPE_CL = 'CL'; // Логистический склад
    public const CREATE_METHOD_TYPE_CA = 'CA'; // Комиссионная площадка

    /**
     * @var OrderProduct[]
     */
    private $products;

    abstract public function getContactPerson(): string;
    abstract public function getReleaseMethodType(): string;
    abstract public function getCreateMethodType(): string;
    abstract public function getProductionOrderId(): string;

    /**
     * @param OrderProduct[] $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    final public function getProducts(): array
    {
        return $this->products;
    }
}
