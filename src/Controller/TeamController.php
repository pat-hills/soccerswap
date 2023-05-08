<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\AddTeamType;
use App\Repository\TeamRepository;
use App\Repository\SellPlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class TeamController extends AbstractController
{

    private $teamRepository;
    private $paginator;
    private $sellPlayerRepository;

    public function __construct(TeamRepository $teamRepository,PaginatorInterface $paginator, SellPlayerRepository $sellPlayerRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->paginator = $paginator;
        $this->sellPlayerRepository = $sellPlayerRepository;
    }

    #[Route('/teams', name: 'team.display')]
    public function index(Request $request): Response
    {
        $query = $this->teamRepository->getAllTeamsAndPlayers();
        $teamsAndPlayers = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('team/index.html.twig', [
            'teamsAndPlayers' => $teamsAndPlayers,
        ]);
    }


    #[Route('/add-team', name: 'team.add')]
    public function store(Request $request): Response
    {
        $form = $this->createForm(AddTeamType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {   
            $team = $form->getData();
            $team->setDateCreated(new \DateTime()); 
            $this->teamRepository->save($team,true);

            $session = $request->getSession(); 
            $session->set('team_name', $team->getName());
    
            //return new Response('Saved new Team with id '.$team->getId());
            return $this->redirectToRoute('player.add');
        }

        return $this->render('team/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/transactions', name: 'team.transactions')]
    public function teamTransactions(Request $request): Response
    {
        $session = $request->getSession();
        $sessionValueId = $session->get('buyer_id');
        $sessionValueName = $session->get('buyer_name');
        //Getting Team moneyBalance and formatting it to human readable
        $moneyBalance = $this->teamRepository->getTeamMoneyBalance($sessionValueId);
        $moneyBalanceFormatted = number_format($moneyBalance, 2);
        
         //Getting Team SUM Purchase and formatting it to human readable
         $teamPurchase = $this->sellPlayerRepository->getTotalPurchaseAmountByTeamId($sessionValueId);
         $teamPurchaseFormatted = number_format($teamPurchase, 2);

        //Getting all purchases of players
        $teamPurchasesList = $this->sellPlayerRepository->getAllTeamPurchases($sessionValueId);
        $teamPurchasesListPaginated = $this->paginator->paginate(
           $teamPurchasesList,
           $request->query->getInt('page', 1),
           5
       );

        return $this->render('team/transaction.html.twig', [
            'moneyBalance' => $moneyBalanceFormatted,
            'teamPurchaseFormatted' => $teamPurchaseFormatted,
            'teamPurchasesList' => $teamPurchasesListPaginated,
            'teamName' => $sessionValueName,
        ]);
    }


    
}
