<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Loevgaard\SyliusBarcodePlugin\EventListener\AddIndicesSubscriber;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class AddIndicesSubscriberTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_subscribes_to_the_correct_event(): void
    {
        $subscriber = new AddIndicesSubscriber();
        $events = $subscriber->getSubscribedEvents();

        $this->assertSame([
            Events::loadClassMetadata,
        ], $events);
    }

    /**
     * @test
     */
    public function it_does_not_add_indices_when_subclass_is_wrong(): void
    {
        $metadata = $this->prophesize(ClassMetadata::class);
        $eventArgs = $this->getMockBuilder(LoadClassMetadataEventArgs::class)->disableOriginalConstructor()->getMock();

        $eventArgs->method('getClassMetadata')->willReturn($metadata);

        $metadata->getColumnNames()->shouldNotBeCalled();

        $subscriber = new AddIndicesSubscriber();
        $subscriber->loadClassMetadata($eventArgs);
    }

    /**
     * @test
     */
    public function it_adds_indices(): void
    {
        $class = new class() implements BarcodeAwareInterface {
            use ProductVariantTrait;
        };
        $metadata = $this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->getMock();
        $metadata->name = get_class($class);
        $metadata->table = [];
        $metadata->method('getColumnNames')->willReturn(['barcode_checked', 'barcode_valid']);

        $eventArgs = $this->getMockBuilder(LoadClassMetadataEventArgs::class)->disableOriginalConstructor()->getMock();

        $eventArgs->method('getClassMetadata')->willReturn($metadata);

        $subscriber = new AddIndicesSubscriber();
        $subscriber->loadClassMetadata($eventArgs);

        $this->assertSame([
            'indexes' => [
                [
                    'columns' => ['barcode_checked'],
                ],
                [
                    'columns' => ['barcode_valid'],
                ],
            ],
        ], $metadata->table);
    }
}
