<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product;

use Sylius\Behat\Page\Admin\Product\CreateSimpleProductPage as BaseCreatePage;

class CreateSimpleProductPage extends BaseCreatePage
{
    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function setBarcode($barcode): void
    {
        $this->getElement('barcode')->setValue($barcode);
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'barcode' => '#sylius_product_variant_barcode',
        ]);
    }
}
