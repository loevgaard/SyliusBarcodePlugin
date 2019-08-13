<?php

declare(strict_types=1);

namespace spec\Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeChecker;
use Loevgaard\SyliusBarcodePlugin\Event\PostBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Event\PreBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
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

    public function it_validates(BarcodeAwareInterface $barcodeAware): void
    {
        $barcodeAware->getBarcode()->willReturn('4006381333931');
        $barcodeAware->markBarcodeAsChecked(true)->shouldBeCalled();

        $this->check($barcodeAware);
    }

    public function it_dispatches_events(EventDispatcherInterface $eventDispatcher, BarcodeAwareInterface $barcodeAware): void
    {
        $eventDispatcher->dispatch(Argument::type(PreBarcodeCheckEvent::class), PreBarcodeCheckEvent::NAME)->shouldBeCalledOnce();
        $eventDispatcher->dispatch(Argument::type(PostBarcodeCheckEvent::class), PostBarcodeCheckEvent::NAME)->shouldBeCalledOnce();

        $this->check($barcodeAware);
    }
}
