<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Streaming;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StreamingAdmin extends Admin
{


    protected function configureFormFields(FormMapper $formMapper)
    {
        $blocks = array(
            'block1' => 'block1',
            'block2' => 'block2',
            'block3' => 'block3',
            'block4' => 'block4',
            'block5' => 'block5'
        );
        $formMapper
            ->tab('Streaming')
                ->with('Steaming', array('class' => 'col-md-7'))
                    ->add('block', 'choice',array(
                        'choices' => $blocks,
                        'label' => 'Block'
                    ))
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
            ->add('id')
            ->add('block')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('block')
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
        return $object instanceof Streaming
            ? $object->getId()
            : 'Streaming';
    }

}