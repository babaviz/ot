<?php

namespace OT\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookedTimeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_time')
            ->add('end_time')
            ->add('status')
            ->add('TransactionRecord')
            //->add('Course')
            //->add('Teacher')
            //->add('Learner')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OT\BackendBundle\Entity\BookedTime'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ot_backendbundle_bookedtime';
    }
}
