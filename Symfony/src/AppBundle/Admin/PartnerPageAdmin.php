<?php

namespace AppBundle\Admin;

use AppBundle\Entity\PartnerPage;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PartnerPageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('PartnerPage')
            ->with('PartnerPage Infos', array('class' => 'col-md-6'))
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

            ->tab('Partners')
            ->with('Partners')
            ->add('partners', 'sonata_type_collection', array(
                'type_options' => array('delete' => false),
                'required' => true), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
            ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('publication')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('publication')
        ;
    }

    public function prePersist($object)
    {
        $this->setpage($object);
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $this->setpage($object);
        $this->saveFile($object);
    }

    public function setpage($object){

        foreach ($object->getVisuels() as $visuel) {
            if($visuel->getMedia()->getPath() == null)
            {
                $visuel->getMedia()->setTitle('EMPTY');
                $visuel->getMedia()->setPath('EMPTY');
                $visuel->getMedia()->setStatus(1);
                $visuel->getMedia()->setPage('Partner_Page');
            }
        }

        foreach ($object->getPartners() as $partner) {
//            var_dump($partner->getPath());
//            die();
            if($partner->getMedia()->getPath() == null)
            {
                $partner->getMedia()->setTitle('EMPTY');
                $partner->getMedia()->setPath('EMPTY');
                $partner->getMedia()->setStatus(1);
                $partner->getMedia()->setPage('Partner_Page');
            }
            if($partner->getPath() == null)
            {
                $partner->setPath('EMPTY');
            }
        }
    }

    public function saveFile($object)
    {
        foreach ($object->getVisuels() as $visuel) {
            $visuel->getMedia()->upload();
            $visuel->setPartnerPage($object);
        }

        foreach ($object->getPartners() as $partner) {
            $partner->getMedia()->upload();
            $partner->upload();
            $partner->setPartnerPage($object);
        }
    }

    public function toString($object)
    {
        return $object instanceof PartnerPage
            ? $object->getId()
            : 'PartnerPage';
    }
}