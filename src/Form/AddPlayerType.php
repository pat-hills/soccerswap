<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use App\Entity\Country;
use App\Repository\TeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AddPlayerType extends AbstractType

{
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'help' => 'Enter name of player',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                
            ])
            ->add('Surname', TextType::class, [
                'help' => 'Enter surname of player',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                
            ])
            ->add('PriceTag', NumberType::class, [
                'help' => 'Enter player price tag',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                
            ])
           // ->add('DateCreated')
           ->add('Team', EntityType::class, [
            'class' => Team::class,
            'choices' => $this->teamRepository->findAll(),
            'choice_label' => 'name',
            'placeholder' => 'Select Team',
            'required' => true,
            'multiple' => false,
            'attr' => [
                'class' => 'form-control',
                'autocomplete' => 'off',
            ],
        ]);

        $builder->add('add', SubmitType::class, [
            'label' => 'Add Player'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
