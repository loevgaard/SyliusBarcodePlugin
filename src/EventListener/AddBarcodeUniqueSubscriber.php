<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;

final class AddBarcodeUniqueSubscriber implements EventSubscriber
{
    private bool $uniqueEnabled;

    public function __construct(bool $uniqueEnabled)
    {
        $this->uniqueEnabled = $uniqueEnabled;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        $metadata = $event->getClassMetadata();

        if (!is_subclass_of($metadata->name, BarcodeAwareInterface::class, true)) {
            return;
        }

        if (!$this->uniqueEnabled) {
            return;
        }

        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $metadata->fieldMappings['barcode']['unique'] = true;
    }
}
