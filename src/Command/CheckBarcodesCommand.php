<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeCheckerInterface;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckBarcodesCommand extends Command
{
    /** @var EntityManagerInterface */
    private $productVariantManager;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var BarcodeCheckerInterface */
    private $barcodeChecker;

    public function __construct(
        EntityManagerInterface $productVariantManager,
        ProductVariantRepositoryInterface $productVariantRepository,
        BarcodeCheckerInterface $barcodeChecker
    ) {
        parent::__construct();

        $this->productVariantManager = $productVariantManager;
        $this->productVariantRepository = $productVariantRepository;
        $this->barcodeChecker = $barcodeChecker;
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
        $productVariants = $this->getProductVariants();
        foreach ($productVariants as $productVariant) {
            $this->barcodeChecker->check($productVariant);
            $this->productVariantManager->flush();
        }

        return 0;
    }

    /**
     * @return BarcodeAwareInterface[]|Generator
     */
    private function getProductVariants(): Generator
    {
        /** @var Pagerfanta $pager */
        $pager = $this->productVariantRepository->createPaginator([
            'barcodeChecked' => null,
        ]);

        for ($page = 1; $page < $pager->getNbPages(); ++$page) {
            $pager->setCurrentPage($page);

            yield from $pager->getCurrentPageResults();
        }
    }
}
