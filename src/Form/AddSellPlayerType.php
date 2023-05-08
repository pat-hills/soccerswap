<?php

namespace App\Form;

use App\Entity\SellPlayer;
use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddSellPlayerType extends AbstractType
{
    private $teamRepository;
    //private $displayedPlayerTeam;
    //private $teamId;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
       // $this->displayedPlayerTeam = $displayedPlayerTeam;
        //$this->teamId = $teamId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $displayedPlayerTeamOption = $options['displayedPlayerTeamOption'];
        $PlayerAmountOption = $options['PlayerAmountOption'];

        $builder
        ->add('PlayerAmount', IntegerType::class, [
            'label' => 'Player Amount',
            'data' => $PlayerAmountOption, // set default value to 100
            'attr' => [
                'class' => 'form-control',
                'readonly' => true
            ]
        ])

        ->add('Category', ChoiceType::class, [
            'choices' => [
                'Buy' => 'Buy',
            ],
            'placeholder' => 'Select Transaction Type',
            'required' => true,
            'multiple' => false,
            'attr' => [
                'class' => 'form-control'
            ],
            'choice_label' => function ($choice, $key, $value) {
                return $value;
            },
        ])

        ->add('Buyer', EntityType::class, [
            'class' => Team::class,
            'choices' => $this->teamRepository->getTeamBuyer($displayedPlayerTeamOption),
            'choice_label' => 'name',
            'placeholder' => 'Select Team Buyer',
            'required' => true,
            'multiple' => false,
            'attr' => [
                'class' => 'form-control'
            ],
        ]);
        
        $builder->add('add', SubmitType::class, [
            'label' => 'Buy'
        ]);

        //$builder->setName('sell_player_form');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SellPlayer::class,
            'displayedPlayerTeamOption' => null,
            'PlayerAmountOption' => null,
        ]);
    }
}
