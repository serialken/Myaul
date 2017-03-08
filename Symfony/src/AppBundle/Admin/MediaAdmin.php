<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MediaAdmin extends Admin
{

    public $supportsPreviewMode = true;

    public $pages = array(
        'Acensi_Page' => 'Acensi_Page',
        'Home_Page' => 'Home_Page',
        'Inscription_Dev_Page' => 'Inscription_Dev_Page',
        'Inscription_Multi_Page' => 'Inscription_Multi_Page',
        'Inscription_Solo_Page' => 'Inscription_Solo_Page',
        'Stream_Page' => 'Stream_Page',
        'Partner_Page' => 'Partner_Page',
        'Tournament' => 'Tournament',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
//        $object = $this->getSubject();
//        $container = $this->getConfigurationPool()->getContainer();
//        $fullPath =     $container->get('request')->getBasePath().'/'.$object->getWebPath();
        $formMapper
            ->tab('Media')
            ->with('Picture', array('class' => 'col-md-6'))
            ->add('file','file',array(
//                        'help' => is_file($object->getAbsolutePath() . $object->getPath()) ? '<img src="' . $fullPath . $object->getPlanPath() . '" class="admin-preview" />' : 'Picture is not avialable',
                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                'attr' => array(
                    'class' => 'sonata-medium-file'
                ),
                'label'=>'Select a file:',
                'required' => false
            ))
//                        ->add('_action', 'actions', array(
//                            'actions' => array(
//                                'show' => array('template' => 'AppBundle:CRUD:preview_picture.html.twig'),
//                                'edit' => array(),
//                                'delete' => array(),
//                            )
//                        ))
            ->add('link', 'text', array('required' => false))
            ->end()

            ->with('Informations complémentaires', array('class' => 'col-md-6'))
            ->add('page', 'hidden', array('attr'=>array("hidden"=>true)))
            ->add('status', 'hidden', array('attr'=>array("hidden"=>true)))
//            ->add('status','choice',array(
//                'choices' => array(
//                    '1' =>'afficher',
//                    '0' => 'cacher',
//                ),
//                'expanded' => true,
//                'label' => ' Options d\'Affichage'
//            ))
            ->add('num_order', 'integer', array(
                'label' => 'Ordre D\'affichage'
            ))
            ->end()
            ->end()

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
            ->add('title')
            ->add('link')
//            ->add('status','doctrine_orm_choice', array(
//                'label' => 'Statut du media'),
//                'choice',
//                array(
//                    'choices' => array(
//                        '1' =>'Display',
//                        '0' => 'Hide',
//                    ),
//                    'expanded' => true,
//                ))

            ->add('num_order','doctrine_orm_choice', array(
                'label' => 'Page du site'),
                'choice',
                array(
                    'choices' =>array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6'
                    ),
                    'expanded' => true,
//                    'multiple' => true,
                ))
        ;

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('link')
//            ->add('status','boolean')
            ->add('num_order')
            ->add('social_network', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Social_network',
                'property' => 'name',
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof Media
            ? $object->getId()
            : 'Media';
    }

    public function prePersist($object)
    {
        $object->setStatus(1);
        $this->manageEmbeddedImageAdmins($object);
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $object->setStatus(1);
        $this->manageEmbeddedImageAdmins($object);
        $this->saveFile($object);
    }

    public function saveFile($object) {
        $object->upload();
    }

    public function getTemplate($object)
    {
        switch ($object) {
            case 'preview':
                return 'AppBundle:CRUD:preview.html.twig';
                break;
            default:
                return parent::getTemplate($object);
                break;
        }
    }
}