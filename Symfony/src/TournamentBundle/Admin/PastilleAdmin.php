<?php

namespace TournamentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PastilleAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $types = array(
            'Multi'=>'Multi',
            'Solo'=>'Solo',
            'DevCup'=>'DevCup'
        );
        $formMapper
            ->tab('Pastille')
                ->with('Media', array('class' => 'col-md-7'))
                    ->add('type','choice',array(
                        'choices' => $types,
                        'label' => 'Type',
                        'help' => 'Indiquez vers quel type de jeu la pastille est liée'
                    ))
                    ->add('media','sonata_type_admin', array('delete' => false), array())
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
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
        return $object instanceof Pastille
            ? $object->getId()
            : 'Pastille';
    }

}