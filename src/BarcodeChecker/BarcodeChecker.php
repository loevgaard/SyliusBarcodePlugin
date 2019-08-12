<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\Event\PostBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Event\PreBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use violuke\Barcodes\BarcodeValidator;

final class BarcodeChecker implements BarcodeCheckerInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = LegacyEventDispatcherProxy::decorate($eventDispatcher);

        $this->eventDispatcher = $eventDispatcher;
    }

    public function check(BarcodeAwareInterface $barcodeAware): void
    {
        $this->eventDispatcher->dispatch(new PreBarcodeCheckEvent($barcodeAware), PreBarcodeCheckEvent::NAME);

        $validator = new BarcodeValidator($barcodeAware->getBarcode());
        $valid = (bool) $validator->isValid();

        $barcodeAware->markBarcodeAsChecked($valid);

        $this->eventDispatcher->dispatch(new PostBarcodeCheckEvent($barcodeAware, $valid, (string) $validator->getType()), PostBarcodeCheckEvent::NAME);
    }
}
