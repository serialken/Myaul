<?php

namespace TournamentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use TournamentBundle\Entity\Tournament;

class DefaultController extends Controller
{
    public function tournamentAction($game)
    {
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if (($date = $last_tournament_published->getYear()) == NULL)
            die("Error 69: Pas de Tournois publié !!!");

        $tournament = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('year' => $date, 'game' => $game));
        $tournament_id = $tournament->getId();

        $visuels = $em->getRepository('AppBundle:Visuel')->findBy(array('tournament' => $tournament->getId()));

        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Tournament'));

        //->get partner id from associative table, hompage_partner
        $partners_id = $conn->fetchAll("SELECT partner_id FROM tournament_partner WHERE tournament_id =$tournament_id");
        $count = count($partners_id);
        $partner_ids = array();
        for ($i = 0; $i < $count; $i++) {
            array_push($partner_ids, $partners_id[$i]['partner_id']);
        }
        $list_partners = $em->getRepository('AppBundle:Partner')->findBy(array('id' => $partner_ids));
        $partners = array();
        $i = 0;
        foreach ($list_partners as $list_partner) {
            $partners[$list_partner->getMedia()->getNumOrder()] = $list_partner;
            $i++;
        }
        ksort($partners);

        $blocks = array('block1', 'block2', 'block3', 'block4', 'block5');
        $main_visuel = array(
            '0' => null,
            '1' => null,
            '2' => null,
            '3' => null,
            '4' => null,
        );
        $i = 0;
        //Dispatch all visuels media by block
        foreach ($tournament->getVisuels() as $visu) {
            while ($i < 5) {
                if ($visu->getBlock() == $blocks[$i] && $visu->getMedia()->getStatus()) {
                    $main_visuel[$i] = $visu->getMedia();
                }
                $i++;
            }
            $i = 0;
        }

        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        $plannnings = $em->getRepository('AppBundle:Planning')->findBy(array('media' => $medias));

        $socialnetworks = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));


        $date_tournois = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        $list_editions = $em->getRepository('TournamentBundle:Edition')->findBy(array('tournament' => $date_tournois, 'tournament' => $tournament_id));

        $i = 0;
        $editions = null;
        foreach ($list_editions as $list_edition) {
            $editions[$list_edition->getMedia()->getNumOrder()] = $list_edition;
            $i++;
        }
        if (!empty($editions)) {
            ksort($editions);
        }


        $infos = $em->getRepository('AppBundle:Planning')->findBy(array('media' => $medias));

        $few_words = $em->getRepository('TournamentBundle:few_word')->findBy(array('tournament' => $tournament));

        $get_few_word_medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Tournament'));
        $few_word_medias = $em->getRepository('TournamentBundle:few_word')->findBy(array('media' => $get_few_word_medias, 'tournament' => $tournament));

        $list_events = $em->getRepository('TournamentBundle:Event')->findBy(array('tournament' => $tournament));
        $j = 0;
        $events = null;
        foreach ($list_events as $list_event) {
            $events[$list_event->getMedia()->getNumOrder()] = $list_event;
            $j++;
        }
        if (!empty($events)) {
            ksort($events);
        }

        $event_page = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Tournament'));
        $event_medias = $em->getRepository('TournamentBundle:Event')->findBy(array('media' => $event_page, 'tournament' => $tournament));

        $game_tournament_selection = $em->getRepository('TournamentBundle:Tournament')->findBy(array('game' => $game, 'year' => $date));


        //$game_tournament_selection = array_merge($select_tournament_names,$select_game_names);

        return $this->render('TournamentBundle:Tournament:GamingCup.html.twig', array(
            'medias' => $medias,
            'main_visuel' => $main_visuel,
            'socialnetworks' => $socialnetworks,
            'editions' => $editions,
            'visuel' => $visuels,
            'plannings' => $plannnings,
            'partners' => $partners,
            'logo_socials' => $logo_socials,
            'infos' => $infos,
            'tournament' => $tournament,
            'few_words' => $few_words,
            'few_word_medias' => $few_word_medias,
            'events' => $events,
            'event_medias' => $event_medias,
            'game_tournament_selection' => $game_tournament_selection,
            'date' => $date
        ));
    }

    public function partnerAction()
    {
        $categories = array(
            '0' => 'Partenaire Officiel',
            '1' => 'Partenaire Techniques',
            '2' => 'Partenaire Medias',
        );

        $em = $this->getDoctrine()->getManager();

        $partnerpage = $em->getRepository('AppBundle:PartnerPage')->findOneBy(array('publication' => true));
        $mainvisuel = $em->getRepository('AppBundle:Visuel')->findOneBy(array('block' => 'block1', 'partnerpage' => $partnerpage));

        $partners = $em->getRepository('AppBundle:Partner')->findAll();
        $list_partners_techniques = $em->getRepository('AppBundle:Partner')->findBy(array('categorie' => 'Partenaire Techniques'));
        $partners_technique = array();
        $j = 0;
        foreach ($list_partners_techniques as $list_partners_technique) {
            $partners_technique[$list_partners_technique->getMedia()->getNumOrder()] = $list_partners_technique;
            $j++;
        }

        ksort($partners_technique);

        $list_partners_officiels = $em->getRepository('AppBundle:Partner')->findBy(array('categorie' => 'Partenaire Officiel'));
        $partners_officiel = array();
        $j = 0;
        foreach ($list_partners_officiels as $list_partners_officiel) {
            $partners_officiel[$list_partners_officiel->getMedia()->getNumOrder()] = $list_partners_officiel;
            $j++;
        }
        ksort($partners_officiel);

        $list_partners_medias = $em->getRepository('AppBundle:Partner')->findBy(array('categorie' => 'Partenaire Medias'));
        $partners_media = array();
        $j = 0;
        foreach ($list_partners_medias as $list_partners_media) {
            $partners_media[$list_partners_media->getMedia()->getNumOrder()] = $list_partners_media;
            $j++;
        }
        ksort($partners_media);

        $cpt = count($partners);
        $view_partners = array();
        for ($i = 0; $i < $cpt; $i++) {
            $vue_partners = $em->getRepository('AppBundle:Media')->findBy(array('id' => $partners[$i]->getMedia()->getId()));
            array_push($view_partners, $vue_partners);
        }

        //$socialnetworks = $em->getRepository('AppBundle:Social_network')->getSocialNetwork();
        $socialnetworks = $em->getRepository('AppBundle:Social_network')->findAll();

        //$logo_socials= $em->getRepository('AppBundle:Media')->getLogoSocialNetwork('Home_Page');
        $logo_socials = $em->getRepository('AppBundle:media')->findBy(array('page' => 'Home_Page'));

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Social Network
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if (($date = $last_tournament_published->getYear()) == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        //Get the Social Network Name
        $socialnetworks = array();
        $i = 0;
        foreach ($logo_socials as $logo_social) {
            array_push($socialnetworks, $logo_social->getName());
            $i++;
        }

        $visuels_partner = $em->getRepository('AppBundle:PartnerPage')->findOneBy(array('publication' => true));

        $blocks = array('block1', 'block2', 'block3', 'block4');
        $main_visuel = array(
            '0' => null,
            '1' => null,
            '2' => null,
            '3' => null,
        );
        $i = 0;
        //Dispatch all visuels media by block
        if ($visuels_partner != null) {
            foreach ($visuels_partner->getVisuels() as $visu) {
                while ($i < 4) {
                    if ($visu->getBlock() == $blocks[$i] && $visu->getMedia()->getStatus()) {
                        $main_visuel[$i] = $visu->getMedia();
                    }
                    $i++;
                }
                $i = 0;
            }
        } else
            echo 'Error6.9: Aucun visuel pour cette page !!!';


        $game_tournament_selection = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        $tournament = $em->getRepository('TournamentBundle:tournament')->findOneBy(array('year' => $date));

        $visuels = $em->getRepository('AppBundle:Visuel')->findOneBy(array('tournament' => $tournament->getId()));

        return $this->render('TournamentBundle:Tournament:partner.html.twig', array('partners_technique' => $partners_technique,
            'partners_media' => $partners_media,
            'partners_officiel' => $partners_officiel,
            'main_visuel' => $main_visuel,
            'visuels' => $visuels,
            'game_tournament_selection' => $game_tournament_selection,
            'socialnetworks' => $socialnetworks,
            'logo_socials' => $logo_socials,
            'view_partners' => $view_partners,
            'mainvisuel' => $mainvisuel
        ));

//        $advert = new Tournament();
//        $advert->setGame("Recherche développeur !");
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($advert);
//        $em->flush(); // C'est à ce moment qu'est généré le slug
//
//        return new Response('Slug généré : '.$advert->getSlug());
    }


}
