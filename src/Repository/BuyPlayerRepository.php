<?php

namespace App\Repository;

use App\Entity\BuyPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BuyPlayer>
 *
 * @method BuyPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuyPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuyPlayer[]    findAll()
 * @method BuyPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuyPlayer::class);
    }

    public function save(BuyPlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BuyPlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
