<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Loevgaard\SyliusBarcodePlugin\Message\Command\ProcessBatch;
use Setono\DoctrineORMBatcher\Batch\RangeBatchInterface;
use Setono\DoctrineORMBatcher\Factory\BatcherFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CheckBarcodesCommand extends Command
{
    /** @var EntityManagerInterface */
    private $productVariantManager;

    /** @var MessageBusInterface */
    private $commandBus;

    /** @var BatcherFactoryInterface */
    private $batcherFactory;

    /** @var string */
    private $productVariantClass;

    public function __construct(
        EntityManagerInterface $productVariantManager,
        MessageBusInterface $commandBus,
        BatcherFactoryInterface $batcherFactory,
        string $productVariantClass,
    ) {
        parent::__construct();

        $this->productVariantManager = $productVariantManager;
        $this->commandBus = $commandBus;
        $this->batcherFactory = $batcherFactory;
        $this->productVariantClass = $productVariantClass;
    }

    protected function configure(): void
    {
        $this
            ->setName('loevgaard:barcode:check')
            ->setDescription('Checks barcodes on products')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $qb = $this->productVariantManager->createQueryBuilder();
        $qb->select('o')
            ->from($this->productVariantClass, 'o')
            ->andWhere('o.barcodeChecked is null')
        ;

        $bestChoiceIdBatcher = $this->batcherFactory->createIdRangeBatcher($qb);

        /** @var RangeBatchInterface[] $batches */
        $batches = $bestChoiceIdBatcher->getBatches(50);
        foreach ($batches as $batch) {
            $this->commandBus->dispatch(new ProcessBatch($batch));
        }

        return 0;
    }
}
