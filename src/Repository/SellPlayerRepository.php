<?php

namespace App\Repository;

use App\Entity\SellPlayer;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SellPlayer>
 *
 * @method SellPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SellPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SellPlayer[]    findAll()
 * @method SellPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SellPlayer::class);
    }

    public function save(SellPlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SellPlayer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Total Purchases By Team

    public function getTotalPurchaseAmountByTeamId(int $teamId): float
    {
        $foundTeam = $this->getEntityManager()->find(Team::class, $teamId);
        
        $qb = $this->createQueryBuilder('sp');
        $qb->select('SUM(sp.PlayerAmount)')
            ->andWhere('sp.Category = :category')
            ->andWhere('sp.Buyer = :foundTeam')
            ->setParameters([
                'category' => 'Buy',
                'foundTeam' => $foundTeam,
            ]);
            
        $query = $qb->getQuery();
        $result = $query->getSingleScalarResult();
        
        return $result ? (float) $result : 0.0;
    }

    public function getAllTeamPurchases($teamId)
    {
        $foundTeam = $this->getEntityManager()->find(Team::class, $teamId);

        return $this->createQueryBuilder('sp')
                    ->select('sp.PlayerAmount as playerAmount, p.Name as playerName, p.Surname as playerSurname')
                    ->andWhere('sp.Category = :category')
                    ->andWhere('sp.Buyer = :foundTeam')
                    ->setParameters([
                        'category' => 'Buy',
                        'foundTeam' => $foundTeam,
                    ])
                    ->join('sp.Player', 'p')
                    ->getQuery()
                    ->getResult();
    }

 
}
