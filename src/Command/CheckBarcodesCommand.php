<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeCheckerInterface;
use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckBarcodesCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    /**
     * @var BarcodeCheckerInterface
     */
    private $barcodeChecker;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductVariantRepositoryInterface $productVariantRepository,
        BarcodeCheckerInterface $barcodeChecker
    ) {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->productVariantRepository = $productVariantRepository;
        $this->barcodeChecker = $barcodeChecker;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('loevgaard:barcode:check')
            ->setDescription('Checks barcodes on products')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $productVariants = $this->getProductVariants();
        foreach ($productVariants as $productVariant) {
            $this->barcodeChecker->check($productVariant);
            $this->entityManager->flush();
        }
    }

    /**
     * @return BarcodeAwareInterface[]|\Generator
     */
    private function getProductVariants(): \Generator
    {
        /** @var Pagerfanta $pager */
        $pager = $this->productVariantRepository->createPaginator([
            'barcodeChecked' => null,
        ]);

        for ($page = 1; $page < $pager->getNbPages(); ++$page) {
            $pager->setCurrentPage($page);

            foreach ($pager->getCurrentPageResults() as $pageResult) {
                yield $pageResult;
            }
        }
    }
}
