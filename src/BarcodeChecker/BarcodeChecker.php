<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\Event\PostBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Event\PreBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use violuke\Barcodes\BarcodeValidator;

final class BarcodeChecker implements BarcodeCheckerInterface
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function check(BarcodeAwareInterface $barcodeAware): void
    {
        $this->eventDispatcher->dispatch(new PreBarcodeCheckEvent($barcodeAware), PreBarcodeCheckEvent::NAME);

        $validator = new BarcodeValidator($barcodeAware->getBarcode());
        $valid = $validator->isValid();

        $barcodeAware->markBarcodeAsChecked($valid);

        $this->eventDispatcher->dispatch(new PostBarcodeCheckEvent($barcodeAware, $valid, $validator->getType()), PostBarcodeCheckEvent::NAME);
    }
}
