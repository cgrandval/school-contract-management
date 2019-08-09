<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    /**
     * @param string $prefix
     *
     * @return Contract[]
     */
    public function findContractsWithNumberBeginningOn(string $prefix): array
    {
        return $this->createQueryBuilder('contract')
            ->andWhere('contract.number like :prefix')
            ->orderBy('contract.number', 'ASC')
            ->setParameter('prefix', $prefix.'%')
            ->getQuery()
            ->getResult()
        ;
    }
}
