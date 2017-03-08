<?php

namespace InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use InscriptionBundle\Entity\InscriptionMulti;
use InscriptionBundle\Entity\InscriptionSolo;
use InscriptionBundle\Entity\InscriptionDev;
use InscriptionBundle\Form\InscriptionsoloType;
use InscriptionBundle\Form\InscriptionmultiType;
use InscriptionBundle\Form\InscriptiondevType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    private function sendMail($subject, $mailType, $inscription)
    {
        // le mail est en dur parce que pas prévu dans les specs et dans le BO... Temporaire!!!
        $message = \Swift_Message::newInstance();
        $logo = $message->embed(\Swift_Image::fromPath('Visuels/logo-aul.png'));
        $fb = $message->embed(\Swift_Image::fromPath('Visuels/FACEBOOK_ICON.png'));
        $twitter = $message->embed(\Swift_Image::fromPath('Visuels/TWITTER_ICON.png'));
        $instagram = $message->embed(\Swift_Image::fromPath('Visuels/INSTAGRAM_ICON.png'));
        $message->setContentType('text/html')
            ->setSubject($subject)
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($inscription->getMail())
            ->setBody($this->renderView("InscriptionBundle:Mail:$mailType.html.twig", array(
                "logo" => $logo,
                "fb" => $fb,
                "twitter" => $twitter,
                "instagram" => $instagram,
            )))
        ;

        $this->get('mailer')->send($message);
    }

    public function indexAction()
    {
        return $this->render('InscriptionBundle:Default:index.html.twig');
    }

    public function inscriptionsoloAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $inscription = new InscriptionSolo();
        $form = $this->get('form.factory')->create(new InscriptionsoloType(), $inscription);
        $game = $request->query->get('game');
        $tournament = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('game' => $game));
        $visuel = $em->getRepository('AppBundle:Visuel')->findBy(array('block' => 'inscription', 'tournament' => $tournament));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            $this->sendMail('Confirmation Inscription AUL 2016 [Heartstone]', 'confirm_hs', $inscription);

            $message = 'Votre Inscription a bien été prise en compte';

            return $this->redirect($this->generateUrl('inscriptionbundle_solo', array(
                'visuel' => $visuel,
                'name' => 'Solo',
                'game' => $game,
                'message'=>$message,
            )));
        }

        return $this->render('InscriptionBundle:Default:inscription_solo.html.twig', array(
            'visuel' => $visuel,
            'form' => $form->createView(),
            'name' => 'Solo',
            'game' => $game,
        ));
    }

    public function inscriptionmultiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $inscription = new InscriptionMulti();
        $form = $this->get('form.factory')->create(new InscriptionmultiType(), $inscription);
        $game = $request->query->get('game');
        $tournament = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('game' => $game));
        $visuel = $em->getRepository('AppBundle:Visuel')->findBy(array('block' => 'inscription', 'tournament' => $tournament));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            $this->sendMail('Confirmation Inscription AUL 2016 [League of Legends]', 'confirm_lol', $inscription);

            $message = 'Votre Inscription a bien été prise en compte';

            return $this->redirect($this->generateUrl('inscriptionbundle_multi', array(
                'visuel' => $visuel,
                'name' => 'Multi',
                'game' => $game,
                'message'=>$message,
            )));
        }

        return $this->render('InscriptionBundle:Default:inscription_multi.html.twig', array(
            'visuel' => $visuel,
            'form' => $form->createView(),
            'name' => 'Multi',
            'game' => $game,
        ));
    }

    public function inscriptiondevAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $inscription = new InscriptionDev();
        $form = $this->get('form.factory')->create(new InscriptiondevType(), $inscription);
        $game = $request->query->get('game');
        $tournament = $em->getRepository('TournamentBundle:Tournament')->findOneBy(array('game' => $game));
        $visuel = $em->getRepository('AppBundle:Visuel')->findBy(array('block' => 'inscription', 'tournament' => $tournament));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $length = count($inscription->getTongue());
            $tongues = '';
            for ($i=0; $i<$length; $i++) {
                if ($i == 0) {
                    $tongues = $tongues.$inscription->getTongue()[$i];
                } else {
                    $tongues = $tongues.'-'.$inscription->getTongue()[$i];
                }
            }
            $inscription->setTongue($tongues);
            $em->persist($inscription);
            $em->flush();

            $this->sendMail('Confirmation Inscription AUL 2016 [Dev Cup]', 'confirm_dev', $inscription);

            $message = 'Votre Inscription a bien été prise en compte';

            return $this->redirect($this->generateUrl('inscriptionbundle_dev', array(
                'visuel' => $visuel,
                'name' => 'Multi',
                'game' => $game,
                'message'=>$message,
            )));
        }

        return $this->render('InscriptionBundle:Default:inscription_dev.html.twig', array(
            'visuel' => $visuel,
            'form' => $form->createView(),
            'name' => 'Dev',
            'game' => $game,
        ));
    }

    public function inscriptionchoiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Get All visuel of all tournament of this year
        $list_tournament_visuels = $em->getRepository('TournamentBundle:Pastille')->findAll();

        $visuels = array();
        $i = 0;
        foreach ($list_tournament_visuels as $list_tournament_visuel) {
            $visuels[$list_tournament_visuel->getMedia()->getNumOrder()] = $list_tournament_visuel;
            $i++;
        }
        ksort($visuels);
        return $this->render('InscriptionBundle:Default:inscription_choice.html.twig', array(
            'visuels'=>$visuels
        ));
    }

    public function schoolAction(Request $request)
    {
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $schools = $em->getRepository('InscriptionBundle:School')->searchByNom($value);

        $json = array();
        foreach ($schools as $school) {
            $json[] = array(
                'label' => $school->getNom(),
                'value' => $school->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

}
