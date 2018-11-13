<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Event;

use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use Symfony\Component\EventDispatcher\Event;

final class PostBarcodeCheckEvent extends Event
{
    public const NAME = 'loevgaard_sylius_barcode.post_barcode_check';

    /**
     * @var BarcodeAwareInterface
     */
    private $subject;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @var string
     */
    private $type;

    public function __construct(BarcodeAwareInterface $subject, bool $valid, string $type)
    {
        $this->subject = $subject;
        $this->valid = $valid;
        $this->type = $type;
    }

    /**
     * @return BarcodeAwareInterface
     */
    public function getSubject(): BarcodeAwareInterface
    {
        return $this->subject;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
