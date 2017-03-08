<?php

namespace AppBundle\Admin;

use AppBundle\Entity\HomePage;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class HomePageAdmin extends Admin
{
//    public $supportsPreviewMode = true;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('HomePage')
                ->with('HomePage Infos', array('class' => 'col-md-6'))
                    ->add('name','text')
                    ->add('publication','choice',array(
                        'choices' => array(
                            '1' =>'Display',
                            '0' => 'Hide',
                        ),
                        'expanded' => true,
                    ))
                ->end()
            ->end()

            ->tab('Visuels')
                ->with('Visuels')
                    ->add('visuels', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Chiffres Cles')
                ->with('Info')
                    ->add('last_editions', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Planning')
                ->with('Phases')
                    ->add('plannings', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Selection des Partners')
                ->with('Partners')
                    ->add('partner','entity', array( 'property' => 'name','class' =>'AppBundle\Entity\Partner','expanded' => true, 'multiple' => true))
                ->end()
            ->end()

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('publication','doctrine_orm_choice', array(
                'label' => 'Publication du tournois'),
                'choice',
                array(
                    'choices' => array(
                        '1' =>'Display',
                        '0' => 'Hide',
                    ),
                    'expanded' => true,
                ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('publication','boolean')
        ;
    }

    public function prePersist($object)
    {
        $this->setEmpty($object);
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $this->setEmpty($object);
        $this->saveFile($object);
    }

    public function setEmpty($object){
        foreach ($object->getVisuels() as $visuel) {
            if($visuel->getMedia()->getPath() == null)
            {
                $visuel->getMedia()->setTitle('EMPTY');
                $visuel->getMedia()->setPath('EMPTY');
                $visuel->getMedia()->setStatus(1);
                $visuel->getMedia()->setPage('Home_Page');
            }
        }

        foreach ($object->getLastEditions() as $last_edition) {
            if($last_edition->getMedia()->getPath() == null)
            {
                $last_edition->getMedia()->setTitle('EMPTY');
                $last_edition->getMedia()->setPath('EMPTY');
                $last_edition->getMedia()->setStatus(1);
                $last_edition->getMedia()->setPage('Home_Page');
            }
        }

        foreach ($object->getPlannings() as $planning) {
            if($planning->getMedia()->getPath() == null)
            {
                $planning->getMedia()->setTitle('EMPTY');
                $planning->getMedia()->setPath('EMPTY');
                $planning->getMedia()->setStatus(1);
                $planning->getMedia()->setPage('Home_Page');
            }
        }
    }

    public function saveFile($object)
    {
        foreach ($object->getVisuels() as $visuel) {
            $visuel->setHomePage($object);
            $visuel->getMedia()->upload();
        }

        foreach ($object->getLastEditions() as $last_edition) {
            $last_edition->setHomePage($object);
            $last_edition->getMedia()->upload();
        }

        foreach ($object->getPlannings() as $planning) {
            $planning->setHomePage($object);
            $planning->getMedia()->upload();
        }
    }

    public function toString($object)
    {
        return $object instanceof HomePage
            ? $object->getId()
            : 'HomePage';
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