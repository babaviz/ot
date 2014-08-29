<?php

namespace OT\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransferToType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', 'text', ['label'=>'From (full name)'])
            ->add('to','text', ['label'=>'To (full name)'])
            ->add('amount','text')
            ->add('note','textarea',['data'=>'Manual Transaction'])
            ->add('submit','submit',['label'=>'Transfer'])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OT\BackendBundle\Form\Model\TransferTo',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'transfer_to';
    }
}
