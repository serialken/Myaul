<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AcensiAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Acensi', array('class' => 'col-md-3'))
                ->add('description','text')
                ->add('logo','text')
                ->add('legalNotice','text')
            ->end()
            ->with('Media', array('class' => 'col-md-7'))
                ->add('media','sonata_type_admin', array(), array())
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
            ->add('description')
            ->add('logo')
            ->add('legalNotice')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('description')
            ->add('logo')
            ->add('legalNotice')
        ;
    }

    public function prePersist($object) {
        $this->setpage($object);
        $this->saveFile($object);
    }

    public function preUpdate($object) {
        $this->setpage($object);
        $this->saveFile($object);
    }

    public function setpage($object){
        foreach ($object->getLast_edition() as $last_edition) {
            if($last_edition->getMedia()->getPath() == null)
                $last_edition->getMedia()->setPage('Acensi_Page');
        }

        foreach ($object->getMedia() as $media) {
            if($media->getPath() == null)
                $media->setPage('Acensi_Page');
        }

        foreach ($object->getAcensi() as $acensi) {
            if($acensi->getMedia()->getPath() == null)
                $acensi->getMedia()->setPage('Acensi_Page');
        }
        foreach ($object->getPartner() as $partner) {
            if($partner->getMedia()->getPath() == null)
                $partner->getMedia()->setPage('Acensi_Page');
        }
        foreach ($object->getPlanning() as $planning) {
            if($planning->getMedia()->getPath() == null)
                $planning->getMedia()->setPage('Acensi_Page');
        }
        foreach ($object->getSocial_network() as $social_network) {
            if($social_network->getMedia()->getPath() == null)
                $social_network->getMedia()->setPage('Acensi_Page');
        }
    }

    public function saveFile($object) {

        if($object->getMedia()->getFile() != null){
            $path = '/pictures/'.$object->getMedia()->getFile()->getClientOriginalName();
            $object->getMedia()->path =$path;
            $object->getMedia()->upload();
        }
    }

    public function toString($object)
    {
        return $object instanceof Acensi
            ? $object->getId()
            : 'Acensi';
    }

}