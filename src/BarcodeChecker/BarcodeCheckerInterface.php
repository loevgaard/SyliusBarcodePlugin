<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\BarcodeChecker;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;

interface BarcodeCheckerInterface
{
    public function check(BarcodeAwareInterface $barcodeAware): void;
}
