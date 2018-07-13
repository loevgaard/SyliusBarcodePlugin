<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Entity;

use DateTime;

trait ProductVariantTrait
{
    /**
     * @var string
     */
    protected $barcode;

    /**
     * The date where the barcode was checked
     *
     * @var DateTime
     */
    protected $barcodeChecked;

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     */
    public function setBarcode(?string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return bool
     */
    public function isBarcodeChecked(): bool
    {
        return $this->barcodeChecked instanceof DateTime;
    }

    /**
     * @return DateTime|null
     */
    public function getBarcodeChecked(): ?DateTime
    {
        return $this->barcodeChecked;
    }

    /**
     * @param DateTime|null $barcodeChecked
     */
    public function setBarcodeChecked(?DateTime $barcodeChecked): void
    {
        $this->barcodeChecked = $barcodeChecked;
    }

    /**
     * Marks the barcode as checked
     */
    public function markBarcodeAsChecked(): void
    {
        $this->barcodeChecked = new DateTime();
    }
}
