<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2;

final class Extension
{
    /**
     * @var string
     */
    private $name;

    /**
     * OmsApiExtension constructor.
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function light(): self
    {
        return new static('light');
    }

    public static function pharma(): self
    {
        return new static('pharma');
    }

    public static function tobacco(): self
    {
        return new static('tobacco');
    }

    public static function milk(): self
    {
        return new static('milk');
    }

    public static function tires(): self
    {
        return new static('tires');
    }

    public static function photo(): self
    {
        return new static('photo');
    }

    public static function perfum(): self
    {
        return new static('perfum');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}