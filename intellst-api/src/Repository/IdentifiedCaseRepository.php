<?php

namespace App\Repository;

use App\Entity\IdentifiedCase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IdentifiedCase|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdentifiedCase|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdentifiedCase[]    findAll()
 * @method IdentifiedCase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentifiedCaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdentifiedCase::class);
    }

    public function removeCases()
    {
        $date = new \DateTime();
        $date->modify('-90 day');

        return $this->createQueryBuilder('IdentifiedCase')
            ->delete()
            ->where('IdentifiedCase.firstDate < :date')
            ->setParameter(':date', $date)
            ->getQuery()
            ->execute();
    }

    public function getNewIdentifiedCase(int $day, float $temperature)
    {
        $date = new \DateTime();
        $date->modify("-" . $day . " day");

        return $this->createQueryBuilder('IdentifiedCase')
            ->where('IdentifiedCase.firstDate > :date')
            ->setParameter(':date', $date)
            ->andWhere('IdentifiedCase.temperature > :temperature')
            ->setParameter(':temperature', $temperature)
            ->getQuery()
            ->getResult();
    }

    public function getReturnAttempts(int $day, float $temperature, string $uuid): array
    {
        $date = new \DateTime();
        $date->modify("-" . $day . " day");

        return $this->createQueryBuilder('IdentifiedCase')
            ->where('IdentifiedCase.firstDate > :date')
            ->setParameter(':date', $date)
            ->andWhere('IdentifiedCase.temperature > :temperature')
            ->setParameter(':temperature', $temperature)
            ->andWhere('IdentifiedCase.uuid = :uuid')
            ->setParameter(':uuid', $uuid)
            ->getQuery()
            ->getResult();
    }

    public function getListOfReturnAttempts(string $uuid, $date): array
    {
        return $this->createQueryBuilder('IdentifiedCase')
            ->where('IdentifiedCase.firstDate > :date')
            ->setParameter(':date', $date)
            ->andWhere('IdentifiedCase.uuid = :uuid')
            ->setParameter(':uuid', $uuid)
            ->getQuery()
            ->getResult();
    }

    public function isEntranceAllowed(string $uuid): bool
    {
        $date = new \DateTime();
        $date->modify('-1 day');

        $result = $this->createQueryBuilder('IdentifiedCase')
            ->where('IdentifiedCase.allowEntrance > :date')
            ->setParameter(':date', $date)
            ->andWhere('IdentifiedCase.uuid = :uuid')
            ->setParameter(':uuid', $uuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result === null;
    }
}
