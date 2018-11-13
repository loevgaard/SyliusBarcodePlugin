<?php

namespace spec\Loevgaard\SyliusBarcodePlugin\Model;

use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantStub;
use PhpSpec\ObjectBehavior;

class ProductVariantStubSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductVariantStub::class);
    }

    public function it_marks_barcode_as_checked(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->isBarcodeChecked()->shouldReturn(true);
    }

    public function it_sets_marked_timestamp(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->getBarcodeChecked()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    public function it_marks_barcode_as_valid(): void
    {
        $this->markBarcodeAsChecked(true);
        $this->isBarcodeValid()->shouldReturn(true);
    }
}
