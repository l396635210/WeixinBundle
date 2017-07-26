<?php

namespace Liz\WeiXinBundle\Form;

use Liz\WeiXinBundle\Entity\ClickButton;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClickButtonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('key', ChoiceType::class, [
                'choices' => ClickButton::getClickTypes(),
            ])
            ->add('createTime', 'time')
            ->add('grabRuleId')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liz\WeiXinBundle\Entity\ClickButton'
        ));
    }
}
