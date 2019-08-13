<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;

final class AddIndicesSubscriber implements EventSubscriber
{
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

        $actualColumns = $metadata->getColumnNames();
        $requiredColumns = ['barcode_checked', 'barcode_valid'];

        $tableConfig = ['indexes' => []];

        foreach ($requiredColumns as $requiredColumn) {
            if(!in_array($requiredColumn, $actualColumns, true)) {
                return;
            }

            $tableConfig['indexes'][] = [
                'columns' => [$requiredColumn],
            ];
        }

        $metadata->table = array_merge_recursive($tableConfig, $metadata->table);
    }
}
