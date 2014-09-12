<?php

namespace OT\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeekplanType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teacher','entity',['class'=>'OTBackendBundle:User','property'=>'username'])
            ->add('weekday','choice',[
                'choices'=>[
                '1'=>'Monday',
                '2'=>'Tuesday',
                '3'=>'Wednesday',
                '4'=>'Thursday',
                '5'=>'Friday',
                '6'=>'Saturday',
                '7'=>'Sunday'
                ]
                ])
            ->add('start_hour')
            ->add('start_minute')
            ->add('end_hour')
            ->add('end_minute')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OT\BackendBundle\Entity\Weekplan'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ot_backendbundle_weekplan';
    }
}