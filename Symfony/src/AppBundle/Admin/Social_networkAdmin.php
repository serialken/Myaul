<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Social_network;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Social_networkAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Social Network')
                ->with('Social Network', array('class' => 'col-md-7'))
                    ->add('name','text')
                ->end()
            ->end()

            ->tab('Media')
                ->with('Media', array('class' => 'col-md-7'))
                    ->add('media','sonata_type_admin', array('delete' => false), array())
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

    public function prePersist($object) {
        $this->saveFile($object);
    }

    public function preUpdate($object) {
        $this->saveFile($object);
    }

    public function saveFile($object) {

        if($object->getMedia()->getFile() != null){
            $path = '/pictures/'.$object->getMedia()->getFile()->getClientOriginalName();
            $object->getMedia()->path = $path;
            $object->getMedia()->setStatus(1);
            $object->getMedia()->setPage('Home_Page');
            $object->getMedia()->upload();
        }
    }

    public function toString($object)
    {
        return $object instanceof Social_network
            ? $object->getId()
            : 'Social_network';
    }

}