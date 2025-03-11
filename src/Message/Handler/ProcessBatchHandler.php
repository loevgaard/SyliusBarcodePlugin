<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeCheckerInterface;
use Loevgaard\SyliusBarcodePlugin\Message\Command\ProcessBatch;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Setono\DoctrineORMBatcher\Query\QueryRebuilder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ProcessBatchHandler implements MessageHandlerInterface
{
    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var BarcodeCheckerInterface */
    private $barcodeChecker;

    public function __construct(ManagerRegistry $managerRegistry, BarcodeCheckerInterface $barcodeChecker)
    {
        $this->managerRegistry = $managerRegistry;
        $this->barcodeChecker = $barcodeChecker;
    }

    public function __invoke(ProcessBatch $message): void
    {
        $queryRebuilder = new QueryRebuilder($this->managerRegistry);

        $q = $queryRebuilder->rebuild($message->getBatch());

        /** @var BarcodeAwareInterface[] $variants */
        $variants = $q->getResult();

        $manager = $this->getManager($message->getBatch()->getClass());

        foreach ($variants as $variant) {
            $this->barcodeChecker->check($variant);
        }

        $manager->flush();
    }

    private function getManager(string $class): EntityManagerInterface
    {
        /** @var EntityManagerInterface|null $manager */
        $manager = $this->managerRegistry->getManagerForClass($class);

        if (null === $manager) {
            throw new InvalidArgumentException(sprintf('No manager associated with class %s', $class));
        }

        return $manager;
    }
}
