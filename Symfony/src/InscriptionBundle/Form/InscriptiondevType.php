<?php

namespace InscriptionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\School;
class InscriptiondevType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', 'text')
            ->add('firstName', 'text')
            ->add('mail', 'email')
            ->add('birthDay', 'birthday')
            ->add('major', 'text')
            ->add('nickname', 'text')
            ->add('phoneNumber', 'integer',array(
                'max_length' => 18,
                'invalid_message' => 'Votre numéro de téléphone ne peut pas comporter plus de 18 chiffres'
            ))
            ->add('degreeDate', 'date')
            ->add('school', 'text')
            ->add('known','choice',array(
                'choices' => array(
                    'false' => 'Non',
                    'true' => 'Oui'
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('mean','choice',array(
                'choices' => array(
                    'Par un(e) ami(e)'=>'Par un(e) ami(e)',
                    'Dans mon école / université'=>'Dans mon école / université',
                    'Dans un salon / un forum école'=>'Dans un salon / un forum école',
                    'Lors d\'un stage'=>'Lors d\'un stage',
                    'Via l\'ACENSI Université League'=>'Via l\'ACENSI University League',
                    'Sur Facebook'=>'Sur Facebook',
                    'Sur Twitter'=>'Sur Twitter',
                    'Sur LinkedIn'=>'Sur LinkedIn',
                    'Sur le site Web d\'ACENSI'=>'Sur le site Web d\'ACENSI',
                    'Autre'=>'Autre',
                )
            ))
            ->add('tongue','choice',array(
                'choices' => array(
                    'C#' => 'C#',
                    'Java' => 'Java',
                    'PHP' => 'PHP',
                    'C++' => 'C++',
                    'JavaScript' => 'JavaScript'
                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('save', 'submit',array(
                    'label' => 'Envoyer',
                    'attr' => array('class' => 'submitButtonDev')
                )
            );
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InscriptionBundle\Entity\InscriptionDev'
        ));
    }
}
