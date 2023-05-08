<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\AddPlayerType;
use App\Form\AddSellPlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Repository\SellPlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class PlayerController extends AbstractController

{
    
    private $playerRepository;
    private $teamRepository;
    private $paginator;
    private $sellPlayerRepository;

    public function __construct(PlayerRepository $playerRepository,PaginatorInterface $paginator,
    TeamRepository $teamRepository, SellPlayerRepository $sellPlayerRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
        $this->sellPlayerRepository = $sellPlayerRepository;
        $this->paginator = $paginator;
    }

    //This method store/create a new player

    #[Route('/add-player', name: 'player.add')]
    public function store(Request $request): Response
    {
        $hasRecords = $this->playerRepository->hasRecords();

        $form = $this->createForm(AddPlayerType::class);
        $form->handleRequest($request);

        $session = $request->getSession();  
        $sessionTeamName = $session->get('team_name');

        //Form is checked and valiated

        if ($form->isSubmitted() && $form->isValid()) { 
            $player = $form->getData();
            $player->setDateCreated(new \DateTime());
            $this->playerRepository->save($player,true);

            //gets fullname of player registered player and pass
            //it to the flash and show if off

            $registeredPlayer = $player->getName()." ".$player->getSurname();

            $this->addFlash('success', 'Player, '.$registeredPlayer.', successfully added to team');

            return $this->redirectToRoute('player.add');
        }

        return $this->render('player/add.html.twig', [
            'form' => $form->createView(),
            'hasRecords' => $hasRecords,
            'sessionTeamName' => $sessionTeamName,
        ]);
    }


    #[Route('/players', name: 'player.display')]
    public function getAllPlayers(Request $request): Response
    {
        //Get all players, teams from the repository
        $query = $this->playerRepository->findAllPlayersWithTeams();

        $players = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('player/index.html.twig', [
            'players' => $players,
        ]);
    }



    #[Route('/player/{id}', name:'player.show')]
    public function show(Player $player, Request $request)
    {
        $form = $this->createForm(AddSellPlayerType::class,null,[
            'displayedPlayerTeamOption' => $player->getTeam()->getName(),
            'PlayerAmountOption' => $player->getPriceTag(),
        ]);

        $form->handleRequest($request);

        //call validation of form
        if ($form->isSubmitted() && $form->isValid()) {
            $playerId = $request->attributes->get('id');
            if ($playerId) {
                $foundPlayer = $this->playerRepository->find($playerId);
                if (!$foundPlayer) {
                    throw $this->createNotFoundException('No record for player found ');
                }

                $sellPlayer = $form->getData(); 
                $playerAmount = $sellPlayer->getPlayerAmount();
                $buyer = $sellPlayer->getBuyer();
                $category = $sellPlayer->getCategory();

                //We check if the the buyer/Team has enough balance
                //to purchase player
                //i.e if the category is Buy
                //But this 'category' is no longer needed and can be taken off
                //Concept of Selling Feature is taken off

                if ($playerAmount > $buyer->getMoneyBalance() && $category == "Buy"){

                    $this->addFlash('error','Buyer has insufficient money balance to buy player');
                    return $this->redirectToRoute('player.show',['id' => $playerId]);
                }

                $buyer_id = $buyer->getId(); 
                $buyer_name = $buyer->getName();

                $session = $request->getSession(); 
                $session->set('buyer_id', $buyer_id);
                $session->set('buyer_name', $buyer_name);

                $sellPlayer->setPlayer($player);
                $sellPlayer->setTransactionDate(new \DateTime());
                $this->sellPlayerRepository->save($sellPlayer,true);
            
                //we call update method to update moneyBalance of team/buyer
                //We credit the seller
                //And we debit the money balance of the Buyer
                $this->teamRepository->updateMoneyBalance($buyer,$playerAmount,$foundPlayer);

                //We call update method to update Player team with buyer
                $this->playerRepository->updatePlayerTeamByBuyer($foundPlayer,$buyer);

                return $this->redirectToRoute('team.transactions');
            }
        }
        
        return $this->render('player/show.html.twig', [
            'player' => $player,
            'playerTeam' => $player->getTeam()->getName(),
            'form' => $form->createView()
        ]);
    }

}
