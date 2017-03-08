<?php

namespace TournamentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use TournamentBundle\Entity\Event;

class EventAdmin extends Admin
{


    protected function configureFormFields(FormMapper $formMapper)
{
    $formMapper
        ->tab('Event')
            ->with('Event', array('class' => 'col-md-7'))
                ->add('name','text')
                ->add('description','text')
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
        $datagridMapper->add('id')
            ->add('description')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('description')
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
            $object->getMedia()->path =$path;
            $object->getMedia()->upload();
        }
    }


    public function toString($object)
    {
        return $object instanceof Event
            ? $object->getId()
            : 'Event';
    }}