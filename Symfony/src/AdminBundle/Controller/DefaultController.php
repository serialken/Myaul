<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Export answer
     *
     * @return Response
     */
    public function exportmediaAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $answers = $em->getRepository('AppBundle:Media')->findAll();
        $handle = fopen('php://memory', 'r+');

        foreach ($answers as $answer) {
            fputcsv($handle, [$answer->getTitle(), $answer->getPath(), $answer->getLink()],';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-medias.csv"'
        ));
    }

    /**
     * Export answer
     *
     * @return Response
     */
    public function exportinscriptionmultiAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $answers = $em->getRepository('InscriptionBundle:InscriptionMulti')->findAll();
        $handle = fopen('php://memory', 'r+');

        foreach ($answers as $answer) {
            fputcsv($handle, [
                $answer->getId(),
                $answer->getStringCreatedAt(),
                $answer->getLastName(),
                $answer->getFirstName(),
                $answer->getStringBirthDay(),
                $answer->getMail(),
                $answer->getPhoneNumber(),
                $answer->getNickName(),
                $answer->getSchool(),
                $answer->getStringDegreeDate(),
                $answer->getMajor(),
                $answer->getKnown(),
                $answer->getMean(),
                $answer->getTeamName(),
                $answer->getCaptainUser(),
                $answer->getThink(),
            ],';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-inscription-multi.csv"'
        ));
    }

    /**
     * Export answer
     *
     * @return Response
     */
    public function exportinscriptionsoloAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $answers = $em->getRepository('InscriptionBundle:InscriptionSolo')->findAll();
        $handle = fopen('php://memory', 'r+');

        foreach ($answers as $answer) {
            fputcsv($handle, [
                $answer->getId(),
                $answer->getStringCreatedAt(),
                $answer->getLastName(),
                $answer->getFirstName(),
                $answer->getStringBirthDay(),
                $answer->getMail(),
                $answer->getPhoneNumber(),
                $answer->getNickName(),
                $answer->getSchool(),
                $answer->getStringDegreeDate(),
                $answer->getMajor(),
                $answer->getKnown(),
                $answer->getMean(),
                $answer->getGameUser(),
                $answer->getLastRankJuillet(),
                $answer->getLastRankAout(),
                $answer->getThink(),
            ],
                ';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-solo.csv"'
        ));
    }

    /**
     * Export answer
     *
     * @return Response
     */
    public function exportinscriptiondevAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $answers = $em->getRepository('InscriptionBundle:InscriptionDev')->findAll();
        $handle = fopen('php://memory', 'r+');

        foreach ($answers as $answer) {
            fputcsv($handle, [
                $answer->getId(),
                $answer->getStringCreatedAt(),
                $answer->getLastName(),
                $answer->getFirstName(),
                $answer->getStringBirthDay(),
                $answer->getMail(),
                $answer->getPhoneNumber(),
                $answer->getNickName(),
                $answer->getSchool(),
                $answer->getStringDegreeDate(),
                $answer->getMajor(),
                $answer->getKnown(),
                $answer->getMean(),
                $answer->getTongue()
                ,
            ],';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-dev.csv"'
        ));
    }

    public function mailAction($name)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom(array('aul@acensi.fr' => 'John Doe'))
            ->setTo('aul@acensi.fr')
            ->setBody('le message est bien envoyé')
        ;

        $mailer = $this->get('mailer');
        $mailer->send($message);
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
        return $this->render('AdminBundle:Default:mail.html.twig', array('name' => $name));
    }
}
