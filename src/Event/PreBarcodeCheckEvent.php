<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Event;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class PreBarcodeCheckEvent extends Event
{
    /** @deprecated will be removed in v2 */
    public const NAME = 'loevgaard_sylius_barcode.pre_barcode_check';

    /** @var BarcodeAwareInterface */
    private $subject;

    public function __construct(BarcodeAwareInterface $subject)
    {
        $this->subject = $subject;
    }

    public function getSubject(): BarcodeAwareInterface
    {
        return $this->subject;
    }
}
