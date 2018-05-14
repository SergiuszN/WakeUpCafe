<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bench;
use AppBundle\Repository\BenchRepository;
use AppBundle\Util\TimeHelper;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationAdminForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request = Request::createFromGlobals();
        $date = ($request->get('date')) ? new \DateTime($request->get('date')) : $options['data']->getDate();
        $bench = $options['data']->getBench();

        $builder
            ->add('date', DateType::class, array('label' => 'Date:', 'data' => $date))
            ->add('name', TextType::class, array('label' => 'Name:'))
            ->add('bench', EntityType::class, array(
                'class' => Bench::class,
                'choice_label' => 'name',
                'label' => 'Table:',
                'query_builder' => function(BenchRepository $repository) use ($bench, $date) {
                    return $repository->findFreeBenchForDate($bench, $date);
                },
                'required' => true
            ))
            ->add('numberOfPerson', NumberType::class, array('label' => 'Number Of Person:'))
            ->add('state', CheckboxType::class, array('required' => false, 'label' => 'state', 'data' => true))
            ->add('save', SubmitType::class, array('label' => 'Save'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_reservation_form';
    }
}
