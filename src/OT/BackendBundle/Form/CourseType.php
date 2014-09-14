<?php

namespace OT\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course_id')
            ->add('name')
            ->add('description')
            ->add('duration')
            ->add('price')
            ->add('status','choice',[
                'choices'=>[
                'ACTIVE'=>'Active',
                'Pending'=>'Pending',
                ]
                ])
            ->add('Category')
            ->add('Teachers','entity',['class'=>'OTBackendBundle:User','property'=>'id'])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OT\BackendBundle\Entity\Course'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ot_backendbundle_course';
    }
}
