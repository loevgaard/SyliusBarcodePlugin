<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Model;

use DateTime;

trait ProductVariantTrait
{
    /**
     * @var string|null
     */
    protected $barcode;

    /**
     * The date where the barcode was checked
     *
     * @var DateTime|null
     */
    protected $barcodeChecked;

    /**
     * @var bool
     */
    protected $barcodeValid = false;

    /**
     * {@inheritdoc}
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * {@inheritdoc}
     */
    public function setBarcode(?string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * {@inheritdoc}
     */
    public function isBarcodeChecked(): bool
    {
        return $this->barcodeChecked instanceof DateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getBarcodeChecked(): ?DateTime
    {
        return $this->barcodeChecked;
    }

    /**
     * {@inheritdoc}
     */
    public function setBarcodeChecked(?DateTime $barcodeChecked): void
    {
        $this->barcodeChecked = $barcodeChecked;
    }

    /**
     * @return bool
     */
    public function isBarcodeValid(): bool
    {
        return $this->barcodeValid;
    }

    /**
     * @param bool $barcodeValid
     */
    public function setBarcodeValid(bool $barcodeValid): void
    {
        $this->barcodeValid = $barcodeValid;
    }

    /**
     * {@inheritdoc}
     */
    public function markBarcodeAsChecked(bool $valid): void
    {
        $this->barcodeChecked = new DateTime();
        $this->barcodeValid = $valid;
    }
}
