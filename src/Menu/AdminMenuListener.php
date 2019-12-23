<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $child = $menu->getChild('catalog');

        $child->addChild('invalid_barcodes', [
            'route' => 'loevgaard_sylius_barcode_admin_invalid_barcodes'
        ])
            ->setLabel('loevgaard_sylius_barcode.ui.invalid_barcodes')
            ->setLabelAttribute('icon', 'barcode')
        ;
    }
}
