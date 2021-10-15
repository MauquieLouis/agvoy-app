<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Region;
use App\Entity\Owner;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('summary')
            ->add('description')
            ->add('capacity')
            ->add('superficy')
            ->add('price')
            ->add('address')
            ->add('region', EntityType::class,[
                'class' => Region::class,
                'placeholder' =>'Choisir la region',
                'multiple' => true,
                'required' => false,
                'choice_label' =>function($region){
                return ($region->getCountry().' : '.$region->getName());}
            ])
            ->add('owner',EntityType::class,[
                'class' => Owner::class,
                'placeholder' =>'Choisir le propriétaire',
                'required' => false,
                'choice_label' =>function($owner){
                return ($owner->getFamilyName());}
                ])
            ->add('image',FileType::class,[
               'label' => 'choisir une image', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
