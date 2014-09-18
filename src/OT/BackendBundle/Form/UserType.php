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
            ->add('name','text',['label'=>'Nickname'])
            ->add('password','password')
            ->add('email')
            ->add('phone')
            ->add('role','choice',[
                'choices'=>[
                'ROLE_ADMIN'=>'Administrator',
                'ROLE_TEACHER'=>'Teacher',
                'ROLE_LEARNER'=>'Learner'
                ]
                ])
            ->add('account_balance')
            ->add('create_time','date',['widget'=>'single_text'])
            ->add('timezone','choice',[
                    'choices'=>[
                    'Asia/Hong_Kong'=>'Asia Taiwan/Hong Kong/China',
                    'America/New_York'=>'US Eastern Time: New York',
                    'America/Chicago'=>'US Central Time: Chicago',
                    'America/Denver'=>'US Mountain Time: Denver',
                    'America/Phoenix'=>'US Mountain Time (no DST): Phonenix',
                    'America/Los_Angeles'=>'US Pacific Time: Los_Angeles',
                    'America/Anchorage'=>'US Alaska Time: Anchorage',
                    'America/Adak'=>'US Hawaii-Aleutian Time: Adak',
                    'Pacific/Honolulu'=>'US Hawaii-Aleutian Time (no DST): Honolulu'
                    ]
                ]
                )
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
