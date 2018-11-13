<?php

namespace spec\Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeChecker;
use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BarcodeCheckerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BarcodeChecker::class);
    }

    public function let(EventDispatcherInterface $eventDispatcher): void
    {
        $this->beConstructedWith($eventDispatcher);
    }

    public function it_invalidates(BarcodeAwareInterface $barcodeAware): void
    {
        $barcodeAware->getBarcode()->willReturn('invalid');
        $barcodeAware->markBarcodeAsChecked(false)->shouldBeCalled();

        $this->check($barcodeAware);

    }
}
