<?php

namespace TournamentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use TournamentBundle\Entity\Tournament;

class TournamentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab(' Infos du Tournoi')
                ->with('Tournament', array('class' => 'col-md-6'))

                    ->add('year','integer', array('label' => 'Année'))
                    ->add('name','text')
                    ->add('game','text',array('label'=>'Label','sonata_help'=>'Ecrivez ici le nom à indiquer dans l\'url'))
                    ->add('rank', 'text', array('required' => false))
                    ->add('datetime', 'date', array('attr'=>array("hidden"=>true)))
                    ->add('publication','choice',array(
                        'choices' => array(
                            '1' =>'Display',
                            '0' => 'Hide',
                        ),
                        'expanded' => true,
                    ))
                    ->add('devcup','choice',array(
                        'choices' => array(
                            '1' =>'oui',
                            '0' => 'non',
                        ),
                        'label' => 'Est-ce que ce tournois est la Dev Cup ?',
                        'expanded' => true
                    ))
                ->end()
            ->end()

            ->tab('Visuels')
                ->with('Visuels')
                    ->add('visuels', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Pastilles')
                ->with('Pastille')
                    ->add('pastilles', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('En quelques mots')
                ->with('Descriptif')
                    ->add('few_words', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Deroulement De L\'Edition')
                ->with('Event')
                    ->add('events', 'sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                        'required' => true), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                    ))
                ->end()
            ->end()

            ->tab('Retour Edition sur l\'Edition Precedente')
                ->with('Editions')
                    ->add('editions', 'sonata_type_collection', array(
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
            ->add('year')
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
            ->add('year')
            ->add('game')
            ->add('publication','boolean')
        ;
    }

    public function prePersist($object) {
        $this->setpage($object);
        $object->setDatetime(new\DateTime());
        $this->setEmpty($object);
        $this->saveFile($object);
    }

    public function preUpdate($object) {
        $this->setpage($object);
        $object->setDatetime(new\DateTime());
        $this->saveFile($object);
    }

    public function setpage($object){
        foreach ($object->getFewWords() as $few_word){
            if ($few_word->getMedia()) {
                $few_word->getMedia()->setStatus(1);
                $few_word->getMedia()->setPage('Tournament');
                $few_word->setDescription(str_replace("\n", "<br/>",$few_word->getDescription()));

            }
        }
        foreach ($object->getEvents() as $event){
            if ($event->getMedia()) {
                $event->getMedia()->setStatus(1);
                $event->getMedia()->setPage('Tournament');
                $event->setDescription(str_replace("\n", "<br/>", $event->getDescription()));
            }
        }
        foreach ($object->getEditions() as $edition){
            if ($edition->getMedia())
                $edition->getMedia()->setStatus(1);
                $edition->getMedia()->setPage('Tournament');
        }
        foreach ($object->getVisuels() as $visuel){
            if ($visuel->getMedia())
                $visuel->getMedia()->setStatus(1);
                $visuel->getMedia()->setPage('Tournament');
        }
        foreach ($object->getPastilles() as $pastille){
            if ($pastille->getMedia())
                $pastille->getMedia()->setStatus(1);
                $pastille->getMedia()->setPage('Tournament');
        }
        foreach ($object->getPartner() as $partner){
            if ($partner->getMedia())
                $partner->getMedia()->setStatus(1);
                $partner->getMedia()->setPage('Tournament');
        }
    }

    public function setEmpty($object){
        foreach ($object->getVisuels() as $visuel) {
            if($visuel->getMedia()->getPath() == null)
            {
                $visuel->getMedia()->setTitle('EMPTY');
                $visuel->getMedia()->setPath('EMPTY');
            }
        }

        foreach ($object->getPastilles() as $pastille) {
            if($pastille->getMedia()->getPath() == null)
            {
                $pastille->getMedia()->setTitle('EMPTY');
                $pastille->getMedia()->setPath('EMPTY');
            }
        }

        foreach ($object->getFewWords() as $few_word) {
            if($few_word->getMedia()->getPath() == null)
            {
                $few_word->getMedia()->setTitle('EMPTY');
                $few_word->getMedia()->setPath('EMPTY');
            }
        }

        foreach ($object->getEditions() as $edition) {
            if($edition->getMedia()->getPath() == null)
            {
                $edition->getMedia()->setTitle('EMPTY');
                $edition->getMedia()->setPath('EMPTY');
            }
        }

        foreach ($object->getEvents() as $events) {
            if($events->getMedia()->getPath() == null)
            {
                $events->getMedia()->setTitle('EMPTY');
                $events->getMedia()->setPath('EMPTY');
            }
        };
    }
    public function saveFile($object) {

        foreach ($object->getVisuels() as $visuel) {
            $visuel->setTournament($object);
            $visuel->getMedia()->upload();
        }

        foreach ($object->getPastilles() as $pastille) {
            $pastille->setTournament($object);
            $pastille->getMedia()->upload();

        }

        foreach ($object->getFewWords() as $few_word) {
            $few_word->setTournament($object);
            $few_word->getMedia()->upload();

        }

        foreach ($object->getEditions() as $edition) {
            $edition->setTournament($object);
            $edition->getMedia()->upload();
        }

        foreach ($object->getEvents() as $events) {
            $events->setTournament($object);
            $events->getMedia()->upload();
        };
    }

    public function toString($object)
    {
        return $object instanceof Tournament
            ? $object->getId()
            : 'Tournament';
    }
}