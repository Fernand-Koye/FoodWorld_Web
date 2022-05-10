<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('quantite')
            ->add('prix')
            ->add('imgsrc',FileType::class, array('data_class' => null))
            ->add('saison', ChoiceType::class, ['attr' => ['class' => 'form-control'],
                'choices'  => [
                'été' => "été",
                'printemps' => "printemps",
                'hiver' => "hiver",
                ],
            ])
            ->add('dateMiseEnRayon')
            ->add('datePeremption')
            ->add('idRestaurant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
