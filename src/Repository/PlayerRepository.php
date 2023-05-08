<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Team;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function save(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Getting a player by id
    public function findPlayerById($id): ?Player
    {
        return $this->getEntityManager()->find(Player::class, $id);
    }

    public function findAllPlayersWithTeams()
    {
        return $this->createQueryBuilder('p')
                    ->select('p.Name as player_name, p.Surname as player_surname, p.id as pid, t.Name as team_name')
                    ->join('p.Team', 't')
                    ->getQuery()
                    ->getResult();
    }

    //This method help us to 
    // to update the team of the player
    // to its buyer
    //Meaning once a team buys the player
    // the player belongs to the current buyers team

    public function updatePlayerTeamByBuyer(Player $player, Team $team): void
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'UPDATE App\Entity\Player p
            SET p.Team = :team
            WHERE p.id = :id'
        )
        ->setParameter('team', $team)
        ->setParameter('id', $player->getId());

        $query->execute();
    }

    //check if we have atleast one record
    public function hasRecords(): bool
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('COUNT(p.id)')
            ->setMaxResults(1);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result > 0;
    }
}
