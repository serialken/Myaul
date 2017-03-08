<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\MediaacensiTypeType;
use AppBundle\Form\Medialast_editionType;
use AppBundle\Form\MediaplanningType;

class EditController extends Controller
{

    public function edit_medialast_editionAction($id,Request $request)
    {
        if (!$id) {
            throw $this->createNotFoundException(
                'Please write the id ' . $id
            );
        }

        $em = $this->getDoctrine()->getEntityManager();
        $media = $em->getRepository('AppBundle:Media')->findOneBy(array('id' => $id));

        if (!$media) {
            throw $this->createNotFoundException(
                'No media found for id ' . $id
            );
        }

        $form = $this->get('form.factory')->create(new Medialast_editionType(), $media);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return new Response('Media updated successfully');
        }

        return $this->render('AppBundle:Form:media.html.twig', array(
            'form' => $form->createView(),
            'media'   => $media->getName()));
    }

    public function edit_mediaplanningAction($id,Request $request)
    {
        if (!$id) {
            throw $this->createNotFoundException(
                'Please write the id ' . $id
            );
        }

        $em = $this->getDoctrine()->getEntityManager();
        $media = $em->getRepository('AppBundle:Media')->findOneBy(array('id' => $id));

        if (!$media) {
            throw $this->createNotFoundException(
                'No media found for id ' . $id
            );
        }

        $form = $this->get('form.factory')->create(new MediaplanningType(), $media);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return new Response('Media updated successfully');
        }

        return $this->render('AppBundle:Form:planning.html.twig', array(
            'form' => $form->createView(),
            'media'   => $media->getName()));
    }
}
