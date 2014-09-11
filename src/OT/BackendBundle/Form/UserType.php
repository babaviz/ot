<?php

namespace OT\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('role','choice',[
                'choices'=>[
                'Administrator'=>'ADMIN',
                'Teacher'=>'TEACHER',
                'Learner'=>'LEARNER'
                ]
                ])
            ->add('account_balance')
            ->add('create_time','date',['widget'=>'single_text'])
            ->add('timezone','text')
            ->add('introduction')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OT\BackendBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ot_backendbundle_user';
    }
}
