<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bench;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationAdminForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array('label' => 'Date:'))
            ->add('name', TextType::class, array('label' => 'Name:'))
            ->add('numberOfPerson', NumberType::class, array('label' => 'Number Of Person:'))
            ->add('bench', EntityType::class, array(
                'class' => Bench::class,
                'choice_label' => 'name',
                'label' => 'Table:',
                'required' => true
            ))
            ->add('state', CheckboxType::class, array('required' => false, 'label' => 'state'))
            ->add('save', SubmitType::class, array('label' => 'Save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_reservation_form';
    }
}
