<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('description', TextareaType::class)
            ->add('priority',TextType::class)
            ->add('date')
            ->add('statut', ChoiceType::class, [
                'choices'  => [
                    'To do' => 'To do',
                    'In progress' => 'In progress',
                    'Done' => 'Done',
                ],
            ])

            ->add('heroes', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',

            ])
            ->add('submit', SubmitType::class, ['label' => 'Create'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
