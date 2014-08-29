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
            ->add('roles','text',['label'=>'Type','disabled'=>'true'])
            ->add('account_balance','text',['label'=>'Account Balance','disabled'=>'true'])
            ->add('create_time','text',['label'=>'Date Joined','disabled'=>'true'])
            ->add('username','text',['label'=>'System Login Name','disabled'=>'true'])

            ->add('name','text',['label'=>'Nickname'])
            ->add('email','text',['label'=>'E-mail'])
            ->add('phone','text',['label'=>'Phone'])
            ->add('timezone','text',['label'=>'Timezone'])
            ->add('introduction','textarea',['label'=>'Self Introduction'])
            //->add('Courses')
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
