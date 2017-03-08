<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Last_EditionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Last Edition')
                ->with('Last Edition', array('class' => 'col-md-7'))
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
        $datagridMapper->add('description')

        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('description')
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
        return $object instanceof Last_Edition
            ? $object->getId()
            : 'Last_Edition';
    }

}