<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Message\Handler;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Loevgaard\SyliusBarcodePlugin\BarcodeChecker\BarcodeCheckerInterface;
use Loevgaard\SyliusBarcodePlugin\Message\Command\ProcessBatch;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
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

    /**
     * @throws StringsException
     */
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

    /**
     * @throws StringsException
     */
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
