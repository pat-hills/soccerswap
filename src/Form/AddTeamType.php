<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Rules\UniqueEntry;


class AddTeamType extends AbstractType
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',TextType::class, [
                'help' => 'Enter name of team',
                'constraints' => [
                    new UniqueEntry([
                        'entityClass' => 'App\Entity\Team',
                        'field' => 'Name',
                    ]),
                ],
                'attr' => [
                    'autocomplete' => 'off',
                ],
                
            ])
            ->add('MoneyBalance',NumberType::class, [
                'help' => 'Money Balance is your amount to help buy/sell of players',
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choices' => $this->countryRepository->findAllCountries(),
                'choice_label' => 'name',
                'placeholder' => 'Select a country',
                'required' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ]);

        $builder
            ->add('add', SubmitType::class, [
                'label' => 'Add Team'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
