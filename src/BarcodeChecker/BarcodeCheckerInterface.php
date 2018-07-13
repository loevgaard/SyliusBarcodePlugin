<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\BarcodeChecker;


use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;

interface BarcodeCheckerInterface
{
    public function check(BarcodeAwareInterface $barcodeAware): void;
}
