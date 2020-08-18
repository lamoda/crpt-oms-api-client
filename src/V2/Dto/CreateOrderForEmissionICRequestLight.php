<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

use DateTimeInterface;

final class CreateOrderForEmissionICRequestLight extends CreateOrderForEmissionICRequest
{
    public const RELEASE_METHOD_TYPE_PRODUCTION = 'PRODUCTION';
    public const RELEASE_METHOD_TYPE_IMPORT = 'IMPORT';
    public const RELEASE_METHOD_TYPE_REMAINS = 'REMAINS';
    public const RELEASE_METHOD_TYPE_REMARK = 'REMARK';

    public const CREATE_METHOD_TYPE_SELF_MADE = 'SELF_MADE';
    public const CREATE_METHOD_TYPE_CEM = 'CEM';

    /**
     * @var string
     */
    private $contactPerson;
    /**
     * @var string
     */
    private $releaseMethodType;
    /**
     * @var string
     */
    private $createMethodType;
    /**
     * @var string
     */
    private $productionOrderId;
    /**
     * @var string
     */
    private $contractNumber;
    /**
     * @var DateTimeInterface
     */
    private $contractDate;

    /**
     * CreateOrderForEmissionICRequestLight constructor.
     * @param string $contactPerson
     * @param string $releaseMethodType
     * @param string $createMethodType
     * @param string $productionOrderId
     * @param string $contractNumber
     * @param DateTimeInterface $contractDate
     * @param OrderProduct[] $products
     */
    public function __construct(
        string $contactPerson,
        string $releaseMethodType,
        string $createMethodType,
        string $productionOrderId,
        string $contractNumber,
        DateTimeInterface $contractDate,
        array $products
    ) {
        parent::__construct($products);

        $this->contactPerson = $contactPerson;
        $this->releaseMethodType = $releaseMethodType;
        $this->createMethodType = $createMethodType;
        $this->productionOrderId = $productionOrderId;
        $this->contractNumber = $contractNumber;
        $this->contractDate = $contractDate;
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

    public function getContractNumber(): string
    {
        return $this->contractNumber;
    }

    public function getContractDate(): DateTimeInterface
    {
        return $this->contractDate;
    }
}