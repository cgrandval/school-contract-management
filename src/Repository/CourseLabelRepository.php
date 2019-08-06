<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CourseLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CourseLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseLabel[]    findAll()
 * @method CourseLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseLabelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CourseLabel::class);
    }
}
