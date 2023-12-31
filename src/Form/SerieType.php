<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('overview')
            ->add('status', ChoiceType::class,[
                'choices'=>[
                    'Cancelled' => 'Cancelled',
                    'Ended' => 'Ended',
                    'Returning'=>'Returning'
                ],
                'multiple' => false,
                'expanded' =>false
            ])
            ->add('vote', NumberType::class,[
                'html5'=>true
            ])
            ->add('popularity', NumberType::class, [
                'html5'=>true
            ])
            ->add('genres')
            ->add('firstAirDate', DateType::class, [
                'html5'=>true,
                'widget'=>'single_text'
            ])
            ->add('lastAirDate', DateType::class, [
                'html5'=>true,
                'widget'=>'single_text'
            ])
            ->add('backdropFile', FileType::class, [
                'mapped'=>false
            ])
            ->add('posterFile', FileType::class, [
                'mapped'=>false
            ])
            ->add('tmdbId')
            //->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
