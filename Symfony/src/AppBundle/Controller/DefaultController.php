<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Form\MediaacensiTypeType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function homepageAction()
    {
        //Connexion Doctrine
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        //Get All visuel of all tournament of this year
        $list_tournament_visuels = $em->getRepository('TournamentBundle:Pastille')->findAll(array('num_order' => 'ASC'));

        $visuels = array();
        $i = 0;
        foreach ($list_tournament_visuels as $list_tournament_visuel) {
            $visuels[$list_tournament_visuel->getMedia()->getNumOrder()] = $list_tournament_visuel;
            $i++;
        }
        if (!empty($visuels)) {
            ksort($visuels);
        }

        //Get Home Page
        $homepage = $em->getRepository('AppBundle:HomePage')->findOneBy(array('publication' => true));
        if (empty($homepage)) {
            die("Erreur : Pas de homepage renseignée en backoffice");
        }
        $homepage_id = $homepage->getId();

        //Get All Visuels
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
        foreach ($homepage->getVisuels() as $visu) {
            while ($i < 5) {
                if ($visu->getBlock() == $blocks[$i] && $visu->getMedia()->getStatus()) {
                    $main_visuel[$i] = $visu->getMedia();
                }
                $i++;
            }
            $i = 0;
        }


        //Get Media Partner
        //->get partner id from associative table, hompage_partner
        $partners_id = $conn->fetchAll("SELECT partner_id FROM homepage_partner WHERE homepage_id =$homepage_id");
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
        if (!empty($partners)) {
            ksort($partners);
        }

        //Get Social Network
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findAll();

        //Get the Last Edition
        $list_last_edition_medias = $em->getRepository('AppBundle:Last_edition')->findBy(array('homepage' => $homepage));
        $k = 0;
        foreach ($list_last_edition_medias as $list_last_edition_media) {
            $last_edition_medias[$list_last_edition_media->getMedia()->getNumOrder()] = $list_last_edition_media;
            $k++;
        }
        ksort($last_edition_medias);

        //Get the Planning
        $list_plannings = $em->getRepository('AppBundle:Planning')->findBy(array('homepage' => $homepage));
        $l = 0;
        foreach ($list_plannings as $list_planning) {
            $plannings[$list_planning->getMedia()->getNumOrder()] = $list_planning;
            $l++;
        }
        ksort($plannings);
        $game_tournament_selection = $list_tournament;

        return $this->render('AppBundle:HomePage:homepage.html.twig', array(
                'medias' => $medias,
                'visuels' => $visuels,
                'main_visuel' => $main_visuel,
                'plannings' => $plannings,
                'partners' => $partners,
                'logo_socials' => $logo_socials,
                'game_tournament_selection' => $game_tournament_selection,
                'date' => $date,
                'last_edition_medias' => $last_edition_medias,
            ));
    }

    public function headerAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Social Network
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        //Get the Social Network Name
        $socialnetworks = array();
        $i = 0;
        foreach ($logo_socials as $logo_social) {
            array_push($socialnetworks, $logo_social->getName());
            $i++;
        }
        $game_tournament_selection = $list_tournament;

        //Get Social Network
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        return $this->render('AppBundle:Header:header.html.twig', array(
            'socialnetworks' => $socialnetworks,
            'game_tournament_selection' => $game_tournament_selection,
            'logo_socials' => $logo_socials
        ));
    }

    public function visuelAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Main Visuel
        $main_visuel = $em->getRepository('AppBundle:Visuel')->findOneBy(array('block' => 'block1', 'media' => $medias))->getMedia();

        return $this->render('AppBundle:HomePage:visuel.html.twig', array('main_visuel' => $main_visuel));
    }

    public function editionAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        //Get All visuel of all tournament of this year
        $list_tournament_visuels = $em->getRepository('AppBundle:Visuel')->findBy(array('tournament' => $list_tournament));


        $visuels = array();
        $i = 0;
        foreach ($list_tournament_visuels as $list_tournament_visuel) {

            array_push($visuels, $list_tournament_visuel->getMedia());
            $i++;
        }
        return $this->render('AppBundle:HomePage:edition.html.twig', array('visuels' => $visuels, 'date' => $date));
    }

    public function last_editionAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get the Last Edition
        $last_edition_medias = $em->getRepository('AppBundle:Last_edition')->findBy(array('media' => $medias));

        return $this->render('AppBundle:HomePage:last_edition.html.twig', array('last_edition_medias' => $last_edition_medias));
    }

    public function planningAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get the Planning
        $plannings = $em->getRepository('AppBundle:Planning')->findBy(array('media' => $medias));

        return $this->render('AppBundle:HomePage:planning.html.twig', array('plannings' => $plannings));
    }

    public function partnerAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Media Partner
        $list_partners = $em->getRepository('AppBundle:Partner')->findBy(array('media' => $medias));
        $partners = array();
        $i = 0;
        foreach ($list_partners as $list_partner) {
            $partners[$list_partner->getMedia()->getNumOrder()] = $list_partner;
            $i++;
        }
        ksort($partners);

        return $this->render('AppBundle:HomePage:partner.html.twig', array('partners' => $partners));
    }


    public function footerAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get Media's:  HomePage Statut Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Main visuel of the Tournament Page
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));
        $game_tournament_selection = $list_tournament;

        //Get Social Network
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        return $this->render('AppBundle:Footer:footer.html.twig', array(
            'logo_socials' => $logo_socials,
            'game_tournament_selection' => $game_tournament_selection
        ));
    }

    public function faqAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get FOOTER
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Get FOOTER_LOGO
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        //GET HEADER
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        $visuel = $em->getRepository('AppBundle:Media')->findOneBy(array('page' => 'FAQ'));

        //Get the Social Network Name
        $socialnetworks = array();
        $i = 0;
        foreach ($logo_socials as $logo_social) {
            array_push($socialnetworks, $logo_social->getName());
            $i++;
        }
        $game_tournament_selection = $list_tournament;

        return $this->render('AppBundle:FAQ:FAQ.html.twig', array('game_tournament_selection' => $game_tournament_selection,
            'visuel' => $visuel,
            'logo_socials' => $logo_socials,
            'socialnetworks' => $socialnetworks));

    }

    public function mlAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get FOOTER
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Get FOOTER_LOGO
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        //GET HEADER
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();

        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        $visuel = $em->getRepository('AppBundle:Media')->findOneBy(array('page' => 'FAQ'));

        //Get the Social Network Name
        $socialnetworks = array();
        $i = 0;
        foreach ($logo_socials as $logo_social) {
            array_push($socialnetworks, $logo_social->getName());
            $i++;
        }
        $game_tournament_selection = $list_tournament;

        return $this->render('AppBundle:ML:ml.html.twig', array(
            'game_tournament_selection' => $game_tournament_selection,
            'visuel' => $visuel,
            'logo_socials' => $logo_socials,
            'socialnetworks' => $socialnetworks));

    }

    public function proposAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Get FOOTER
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Home_Page', 'status' => true));

        //Get Get FOOTER_LOGO
        $logo_socials = $em->getRepository('AppBundle:Social_network')->findBy(array('media' => $medias));

        //GET HEADER
        $last_tournament_published = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('publication' => true), array('year' => 'DESC'));

        //Current Year
        if ($last_tournament_published == null) {
            die("Error 69: Pas de Tournois publié !!!");
        }
        $date = $last_tournament_published->getYear();


        //Get All Tournament of the actual year
        $list_tournament = $em->getRepository('TournamentBundle:Tournament')->findBy(array('year' => $date));

        $visuel = $em->getRepository('AppBundle:Media')->findOneBy(array('page' => 'FAQ'));

        //Get the Social Network Name
        $socialnetworks = array();
        $i = 0;
        foreach ($logo_socials as $logo_social) {
            array_push($socialnetworks, $logo_social->getName());
            $i++;
        }
        $game_tournament_selection = $list_tournament;

        return $this->render('AppBundle:Propos:propos.html.twig', array(
            'game_tournament_selection' => $game_tournament_selection,
            'visuel' => $visuel,
            'logo_socials' => $logo_socials,
            'socialnetworks' => $socialnetworks));

    }

    public function streamAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stream_page = $em->getRepository('AppBundle:StreamPage')->findBy(array('publication' => true));

        $list_streams = $em->getRepository('AppBundle:Streaming')->findBy(array('streampage' => $stream_page, 'block' => 'block3'));
        $k = 0;
        foreach ($list_streams as $list_stream) {
            $stream_block3[$list_stream->getMedia()->getNumOrder()] = $list_stream;
            $k++;
        }
        ksort($stream_block3);

        $list_streams = $em->getRepository('AppBundle:Streaming')->findBy(array('streampage' => $stream_page, 'block' => 'block2'));
        $k = 0;
        foreach ($list_streams as $list_stream) {
            $stream_block2[$list_stream->getMedia()->getNumOrder()] = $list_stream;
            $k++;
        }
        ksort($stream_block2);

        $visuel = $em->getRepository('AppBundle:Visuel')->findBy(array('streampage' => $stream_page));
        $visuels = array(
            '0' => array(),
            '1' => array(),
            '2' => array(),
            '3' => array(),
            '4' => array(),
        );
        foreach ($visuel as $visu) {
            if ($visu->getBlock() == 'block1') {
                array_push($visuels[0], $visu);
            } elseif ($visu->getBlock() == 'block2') {
                array_push($visuels[1], $visu);
            } elseif ($visu->getBlock() == 'block3') {
                array_push($visuels[2], $visu);
            } elseif ($visu->getBlock() == 'block4') {
                array_push($visuels[3], $visu);
            }
        }

        //Get Media's:  StreamPage Status Published
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Stream_Page', 'status' => true, 'id' => $list_streams[0]->getMedia()->getId(), 'num_order' => 'ASC'));
        $medias_visuel = $em->getRepository('AppBundle:Media')->findBy(array('page' => 'Stream_Page', 'status' => true, 'id' => $visuel[0]->getMedia()->getId()));

        return $this->render('AppBundle:stream:stream.html.twig', array('medias' => $medias,
            'visuel' => $visuel,
            'visuels' => $visuels,
            'stream_block2' => $stream_block2,
            'stream_block3' => $stream_block3,
            'medias_visuel' => $medias_visuel));
    }

    public function contactAction(Request $request)
    {

        $contact = new Contact();
        $form = $this->get('form.factory')->create(new ContactType(), $contact);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('AUL CONTACT')
                ->setFrom(array($contact->getMail()))
                ->setTo('aul@acensi.fr')
                ->setBody(
                    'nom: ' . $contact->getLastname() . "<br>" . "<br>" .
                    'prénom: ' . $contact->getFirstname() . "<br>" . "<br>" .
                    'comment: ' . "<br>" . "<br>" . $contact->getComment() . "<br>"
                    , 'text/html');

            $mailer = $this->get('mailer');
            $mailer->send($message);
            $spool = $mailer->getTransport()->getSpool();
            $transport = $this->get('swiftmailer.transport.real');
            $spool->flushQueue($transport);

            $info = 'Votre message a bien été envoyé';

            $contact = new Contact();
            $form = $this->get('form.factory')->create(new ContactType(), $contact);

            return $this->render('AppBundle:Contact:contact.html.twig', array(
                'form' => $form->createView(),
                'name' => 'Contact',
                'info' => $info
            ));
        }
        return $this->render('AppBundle:Contact:contact.html.twig', array(
            'form' => $form->createView(),
            'name' => 'Contact',
        ));
    }
}
