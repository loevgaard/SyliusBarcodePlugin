<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product\CreateSimpleProductPage;
use Tests\Loevgaard\SyliusBarcodePlugin\Behat\Page\Admin\Product\UpdateSimpleProductPage;
use Webmozart\Assert\Assert;

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

    /**
     * @Then I should be notified that product with this barcode already exists
     */
    public function iShouldBeNotifiedThatBarcodeAlreadyExists()
    {
        Assert::same(
            $this->createSimpleProductPage->getValidationMessage('barcode'),
            'Variant barcode must be unique.'
        );
    }
}
