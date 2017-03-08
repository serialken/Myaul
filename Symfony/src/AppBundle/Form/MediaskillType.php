<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaplanningType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $pages = array(
            'Acensi_Page' => 'Acensi_Page',
            'Home_Page' => 'Home_Page',
            'Inscription_Dev_Page' => 'Inscription_Dev_Page',
            'Inscription_Multi_Page' => 'Inscription_Multi_Page',
            'Inscription_Solo_Page' => 'Inscription_Solo_Page',
            'Partner_Page' => 'Partner_Page',
            'User_Page' => 'User_Page',
        );

        $builder
            ->add('title', 'text')
            ->add('name', 'text')
            ->add('file')
            ->add('link', 'text',array('required' => false))
            ->add('status', 'choice',array(
                'choices' => array(
                    '1' =>'Display',
                    '0' => 'Hide',
                ),
                'expanded' => true,
            ))
            ->add('page', 'choice',array(
                'choices' => $pages,
            ))
            ->add('num_order', 'integer')
            ->add('Skill', new SkillType())
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Media'
        ));
    }
}
