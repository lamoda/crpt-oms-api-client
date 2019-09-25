<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\Tests\V2;

use Lamoda\OmsClient\V2\Extension;
use PHPUnit\Framework\TestCase;

final class ExtensionTest extends TestCase
{
    public function testPhoto(): void
    {
        $model = Extension::photo();
        $this->assertEquals('photo', $model->getName());
    }

    public function testPerfum(): void
    {
        $model = Extension::perfum();
        $this->assertEquals('perfum', $model->getName());
    }

    public function testTires(): void
    {
        $model = Extension::tires();
        $this->assertEquals('tires', $model->getName());
    }

    public function testLight(): void
    {
        $model = Extension::light();
        $this->assertEquals('light', $model->getName());
    }

    public function testPharma(): void
    {
        $model = Extension::pharma();
        $this->assertEquals('pharma', $model->getName());
    }

    public function testTobacco(): void
    {
        $model = Extension::tobacco();
        $this->assertEquals('tobacco', $model->getName());
    }

    public function testMilk(): void
    {
        $model = Extension::milk();
        $this->assertEquals('milk', $model->getName());
    }

    public function testStringify(): void
    {
        $model = Extension::milk();
        $this->assertEquals('milk', (string) $model);
    }
}
