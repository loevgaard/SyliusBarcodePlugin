<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product\CreateSimpleProductPage;
use Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product\UpdateSimpleProductPage;

final class ManagingProductsContext implements Context
{
    /**
     * @var CreateSimpleProductPage
     */
    private $createSimpleProductPage;

    /**
     * @var UpdateSimpleProductPage
     */
    private $updateSimpleProductPage;

    public function __construct(CreateSimpleProductPage $createSimpleProductPage, UpdateSimpleProductPage $updateSimpleProductPage)
    {
        $this->createSimpleProductPage = $createSimpleProductPage;
        $this->updateSimpleProductPage = $updateSimpleProductPage;
    }

    /**
     * @When I set its barcode to :barcode
     */
    public function iSetItsBarcodeTo($barcode): void
    {
        $this->createSimpleProductPage->setBarcode($barcode);
    }
}
