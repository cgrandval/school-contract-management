<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Intervener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Intervener|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervener|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervener[]    findAll()
 * @method Intervener[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervenerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Intervener::class);
    }
}
