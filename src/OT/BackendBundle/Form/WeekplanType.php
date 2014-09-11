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
            ->add('weekday')
            ->add('start_hour')
            ->add('start_minute')
            ->add('end_hour')
            ->add('end_minute')
            //->add('User')
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
