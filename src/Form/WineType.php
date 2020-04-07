<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Color;
use App\Entity\Region;
use App\Entity\Wine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('color',Entitytype::class, [
                //je choisis ici vers quelle entité
                'class' => Color::class,
                //je choisi aussi quelle champs dans auteur
                'choice_label' => 'name'])
            ->add('appellation',Entitytype::class, [
                //je choisis ici vers quelle entité
                'class' => Appellation::class,
                //je choisi aussi quelle champs dans auteur
                'choice_label' => 'name'])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
