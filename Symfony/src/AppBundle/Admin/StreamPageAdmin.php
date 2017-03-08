<?php

namespace AppBundle\Admin;

use AppBundle\Entity\StreamPage;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StreamPageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('StreamPage')
                ->with('StreamPage Infos', array('class' => 'col-md-6'))
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
                        'required' => false), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Stream')
            ->with('Stream')
            ->add('streamings', 'sonata_type_collection', array(
                'type_options' => array('delete' => false),
                'required' => false), array(
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
        $this->setEmptyStreaming($object);
        $this->setEmptyVisuel($object);
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $this->setpage($object);
        $this->setEmptyStreaming($object);
        $this->saveFile($object);
    }

    public function setpage($object){
        foreach ($object->getVisuels() as $visuel) {
            if($visuel->getMedia()->getPath() == null)
            {
                $visuel->getMedia()->setStatus(1);
                $visuel->getMedia()->setPage('Stream_Page');
            }
        }
        foreach ($object->getStreamings() as $streaming) {
            if($streaming->getMedia()->getPath() == null)
            {
                $streaming->getMedia()->setStatus(1);
                $streaming->getMedia()->setPage('Stream_Page');
            }
        }
    }

    public function setEmptyVisuel($object)
    {
        foreach ($object->getVisuels() as $visuel) {
            if ($visuel->getMedia()->getTitle() == NULL) {
                $visuel->getMedia()->setTitle('EMPTY');
                $visuel->getMedia()->setPath( 'EMPTY');
            }
        }
    }
    public function setEmptyStreaming($object)
    {
        foreach ($object->getStreamings() as $stream) {
            if ($stream->getMedia()->getTitle() == NULL) {
                $stream->getMedia()->setTitle('EMPTY');
                $stream->getMedia()->setPath( 'EMPTY');
            }
        }
    }
    public function saveFile($object)
    {
        foreach ($object->getVisuels() as $visuel) {
                $visuel->setStreamPage($object);
                $visuel->getMedia()->upload();
        }

        foreach ($object->getStreamings() as $stream) {
            $stream->setStreamPage($object);
            $stream->getMedia()->upload();
        }
    }

    public function toString($object)
    {
        return $object instanceof StreamPage
            ? $object->getId()
            : 'StreamPage';
    }
}