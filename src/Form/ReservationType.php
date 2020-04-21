<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('number')
            ->add('time', DateTimeType::class,[
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ]
            ])
            ->add('mail')
            ->add('telephone', TelType::class)
            ->add('commentary')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
