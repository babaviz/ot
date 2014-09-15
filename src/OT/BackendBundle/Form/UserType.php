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
                'ADMIN'=>'Administrator',
                'TEACHER'=>'Teacher',
                'LEARNER'=>'Learner'
                ]
                ])
            ->add('account_balance')
            ->add('create_time','date',['widget'=>'single_text'])
            ->add('timezone','choice',[
                    'choices'=>[
                    'Asia/Hong_Kong'=>'Asia Taiwan/Hong Kong/China',
                    'America/New_York'=>'US Eastern Time',
                    'America/Chicago'=>'US Central Time',
                    'America/Denver'=>'US Mountain Time',
                    'America/Phoenix'=>'US Mountain Time (no DST)',
                    'America/Los_Angeles'=>'US Pacific Time',
                    'America/Anchorage'=>'US Alaska Time',
                    'America/Adak'=>'US Hawaii-Aleutian Time',
                    'Pacific/Honolulu'=>'Hawaii-Aleutian Time (no DST)'
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
