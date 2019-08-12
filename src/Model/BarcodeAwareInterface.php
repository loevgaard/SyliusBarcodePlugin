<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Model;

use DateTime;

interface BarcodeAwareInterface
{
    public function getBarcode(): ?string;

    public function setBarcode(?string $barcode): void;

    public function isBarcodeChecked(): bool;

    public function getBarcodeChecked(): ?DateTime;

    public function setBarcodeChecked(?DateTime $barcodeChecked): void;

    public function isBarcodeValid(): bool;

    public function setBarcodeValid(bool $barcodeValid): void;

    /**
     * Marks the barcode as checked and sets the valid variable
     */
    public function markBarcodeAsChecked(bool $valid): void;
}
