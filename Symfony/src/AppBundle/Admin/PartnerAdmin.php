<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PartnerAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $categories = array(
            'Partenaire Officiel'=>'Partenaire Officiel',
            'Partenaire Techniques'=>'Partenaire Techniques',
            'Partenaire Medias'=>'Partenaire Medias',
        );
        $formMapper
            ->tab('Partner')
                ->with('Partner', array('class' => 'col-md-7'))
                    ->add('categorie', 'choice',array(
                        'choices' => $categories,
                        'label' => 'Partner Categorie'
                    ))
                    ->add('name','text')
                    ->add('description','textarea')
                    ->add('file','file',array(
                        'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                        'attr' => array(
                            'class' => 'sonata-medium-file'
                        ),
                        'label'=>'Select a Background Picture:',
                        'required' => false
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
        $datagridMapper->add('id')
            ->add('description')
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('description')
            ->add('name')
        ;
    }

    public function prePersist($object) {
        $this->saveFile($object);
    }

    public function preUpdate($object) {
        $this->saveFile($object);
    }

    public function saveFile($object) {
        $object->upload();
        if($object->getMedia()->getFile() != null){
            $path = '/pictures/'.$object->getMedia()->getFile()->getClientOriginalName();
            $object->getMedia()->path =$path;
            $object->getMedia()->upload();
        }


    }

    public function toString($object)
    {
        return $object instanceof Partner
            ? $object->getId()
            : 'Partner';
    }
}