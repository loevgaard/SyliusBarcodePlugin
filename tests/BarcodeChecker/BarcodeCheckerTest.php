<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tests\Loevgaard\SyliusBarcodePlugin\Application\Entity\ProductVariant;

class BarcodeCheckerTest extends TestCase
{
    public function testCheckInvalid()
    {
        $barcodeChecker = $this->getBarcodeChecker();

        $product = new ProductVariant();
        $product->setBarcode('invalid');

        $barcodeChecker->check($product);

        $this->assertFalse($product->isBarcodeValid());
        $this->assertInstanceOf(\DateTime::class, $product->getBarcodeChecked());
    }

    public function testCheckValid()
    {
        $barcodeChecker = $this->getBarcodeChecker();

        $product = new ProductVariant();
        $product->setBarcode('4006381333931');

        $barcodeChecker->check($product);

        $this->assertTrue($product->isBarcodeValid());
        $this->assertInstanceOf(\DateTime::class, $product->getBarcodeChecked());
    }

    private function getBarcodeChecker(): BarcodeChecker
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        return new BarcodeChecker($eventDispatcher);
    }
}
