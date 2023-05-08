<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAll()
    {
        return $this->createQueryBuilder('c')
                    ->orderBy('c.Name', 'ASC')
                     ->getQuery()
                    ->getResult();
    }

    public function getAllTeamsAndPlayers()
    {
        return $this->createQueryBuilder('t')
                    ->leftJoin('t.MyPlayers', 'p')
                    ->addSelect('p')
                    ->getQuery()
                    ->getResult();
    }

    //This method gets us the Team buyer the player
    //Or the one 'we' are selling to
    //Excluding the team of the selected player
    //Meaning the team of the selected player
    //Cannot be part of the list

    public function getTeamBuyer($displayedPlayerTeam)
    {
        return $this->createQueryBuilder('t')
                    ->where('t.Name != :teamName')
                    ->setParameter('teamName', "$displayedPlayerTeam")
                    ->getQuery()
                    ->getResult();
    }


    //This method updates the balance of the
    //Buyer which is the team buyer the player
    //We get the Team object as argument in the controller
    //Extract its current moneyBalance
    //Add the playerAmount as sales/income made
    //And Update the totals

    public function updateMoneyBalance(Team $team,$playerAmount,Player $player): void
    {
        $totalAmount = 0;
        $moneyBalance = 0;
        $teamId = $team->getId();
        $moneyBalance = $team->getMoneyBalance();
        //Debit Buyer
        $totalAmount = $moneyBalance - $playerAmount;
        //Credit Player's Team
        $playerTeamMoneyBal = $player->getTeam()->getMoneyBalance();
        $playerTeamAmt = $playerTeamMoneyBal + $playerAmount;
        $playerTeamId = $player->getTeam()->getId();

        //create team data as array
        $teamData = [
            $teamId => $totalAmount,
            $playerTeamId => $playerTeamAmt, 
        ];

        //we loop through data and use the id to find the record
        //and update the amount with the id
        foreach ($teamData as $teamId => $amount) {

            $entityManager = $this->getEntityManager();
            $team = $entityManager->getRepository(Team::class)->find($teamId);
            
            if ($team) {
                $team->setMoneyBalance($amount);
            }
        }
        
        $entityManager->flush();
    }

        //METRICS FOR BUYER/TEAMS

    //Get current money balance

    public function getTeamMoneyBalance(int $teamId): ?int
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.MoneyBalance')
           ->where('t.id = :id')
           ->setParameter('id', $teamId);

        return $qb->getQuery()->getSingleScalarResult();
    }
}
