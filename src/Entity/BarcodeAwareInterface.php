<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Entity;

use DateTime;

interface BarcodeAwareInterface
{
    /**
     * @return string|null
     */
    public function getBarcode(): ?string;

    /**
     * @param string|null $barcode
     */
    public function setBarcode(?string $barcode): void;

    /**
     * @return bool
     */
    public function isBarcodeChecked(): bool;

    /**
     * @return DateTime|null
     */
    public function getBarcodeChecked(): ?DateTime;

    /**
     * @param DateTime|null $barcodeChecked
     */
    public function setBarcodeChecked(?DateTime $barcodeChecked): void;

    /**
     * Marks the barcode as checked
     */
    public function markBarcodeAsChecked(): void;
}
