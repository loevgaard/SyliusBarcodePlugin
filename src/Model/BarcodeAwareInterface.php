<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Model;

use DateTimeInterface;

interface BarcodeAwareInterface
{
    public function getBarcode(): ?string;

    public function setBarcode(?string $barcode): void;

    public function isBarcodeChecked(): bool;

    public function getBarcodeChecked(): ?DateTimeInterface;

    public function setBarcodeChecked(?DateTimeInterface $barcodeChecked): void;

    public function isBarcodeValid(): bool;

    public function setBarcodeValid(bool $barcodeValid): void;

    /**
     * Marks the barcode as checked and sets the valid variable
     */
    public function markBarcodeAsChecked(bool $valid): void;
}
