<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class CreateOrderForEmissionICRequestShoes extends CreateOrderForEmissionICRequest
{
    /**
     * @var string Контактное лицо
     */
    private $contactPerson;
    /**
     * @var string Способ выпуска товаров в оборот
     */
    private $releaseMethodType;
    /**
     * @var string Способ изготовления СИ
     */
    private $createMethodType;
    /**
     * @var string Идентификатор производственного заказа
     */
    private $productionOrderId;

    /**
     * @param string $contactPerson
     * @param string $releaseMethodType
     * @param string $createMethodType
     * @param string $productionOrderId
     * @param OrderProductShoes[] $products
     */
    public function __construct(
        string $contactPerson,
        string $releaseMethodType,
        string $createMethodType,
        string $productionOrderId,
        array $products
    ) {
        parent::__construct($products);

        $this->contactPerson = $contactPerson;
        $this->releaseMethodType = $releaseMethodType;
        $this->createMethodType = $createMethodType;
        $this->productionOrderId = $productionOrderId;
    }

    public function getContactPerson(): string
    {
        return $this->contactPerson;
    }

    public function getReleaseMethodType(): string
    {
        return $this->releaseMethodType;
    }

    public function getCreateMethodType(): string
    {
        return $this->createMethodType;
    }

    public function getProductionOrderId(): string
    {
        return $this->productionOrderId;
    }
}