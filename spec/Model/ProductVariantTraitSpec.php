<?php

declare(strict_types=1);

namespace spec\Loevgaard\SyliusBarcodePlugin\Model;

use DateTimeInterface;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait;
use PhpSpec\ObjectBehavior;

class ProductVariantTraitSpec extends ObjectBehavior
{
    public function let(): void
    {
        $class = new class() implements BarcodeAwareInterface {
            use ProductVariantTrait;
        };

        $this->beAnInstanceOf(get_class($class));
    }

    public function it_implements_barcode_aware_interface(): void
    {
        $this->shouldImplement(BarcodeAwareInterface::class);
    }

    public function it_marks_barcode_as_checked(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->isBarcodeChecked()->shouldReturn(true);
    }

    public function it_sets_marked_timestamp(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->getBarcodeChecked()->shouldReturnAnInstanceOf(DateTimeInterface::class);
    }

    public function it_marks_barcode_as_valid(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->isBarcodeValid()->shouldReturn(true);
    }
}
