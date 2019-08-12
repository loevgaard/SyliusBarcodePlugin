<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Event;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Symfony\Component\EventDispatcher\Event;

final class PostBarcodeCheckEvent extends Event
{
    /** @deprecated will be removed in v2 */
    public const NAME = 'loevgaard_sylius_barcode.post_barcode_check';

    /** @var BarcodeAwareInterface */
    private $subject;

    /** @var bool */
    private $valid;

    /** @var string */
    private $type;

    public function __construct(BarcodeAwareInterface $subject, bool $valid, string $type)
    {
        $this->subject = $subject;
        $this->valid = $valid;
        $this->type = $type;
    }

    public function getSubject(): BarcodeAwareInterface
    {
        return $this->subject;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
