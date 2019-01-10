<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product;

use Sylius\Behat\Page\Admin\Product\UpdateSimpleProductPage as BaseUpdatePage;

class UpdateSimpleProductPage extends BaseUpdatePage
{
    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'barcode' => '#sylius_product_variant_barcode',
        ]);
    }
}
