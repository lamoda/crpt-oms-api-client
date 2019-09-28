<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

abstract class CreateOrderForEmissionICRequest
{
    /**
     * @var OrderProduct[]
     */
    private $products;

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