<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use Loevgaard\SyliusBrandPlugin\Event\PostBarcodeCheckEvent;
use Loevgaard\SyliusBrandPlugin\Event\PreBarcodeCheckEvent;
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
        $barcodeAware->markBarcodeAsChecked();

        $this->eventDispatcher->dispatch(PostBarcodeCheckEvent::NAME, new PostBarcodeCheckEvent($barcodeAware, $validator->isValid(), $validator->getType()));
    }
}
