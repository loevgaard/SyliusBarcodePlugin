<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Event\PostBarcodeCheckEvent;
use Loevgaard\SyliusBarcodePlugin\Event\PreBarcodeCheckEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use violuke\Barcodes\BarcodeValidator;

final class BarcodeChecker implements BarcodeCheckerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function check(BarcodeAwareInterface $barcodeAware): void
    {
        $this->eventDispatcher->dispatch(PreBarcodeCheckEvent::NAME, new PreBarcodeCheckEvent($barcodeAware));

        $validator = new BarcodeValidator($barcodeAware->getBarcode());
        $valid = (bool) $validator->isValid();

        $barcodeAware->markBarcodeAsChecked($valid);

        $this->eventDispatcher->dispatch(PostBarcodeCheckEvent::NAME, new PostBarcodeCheckEvent($barcodeAware, $valid, (string) $validator->getType()));
    }
}
