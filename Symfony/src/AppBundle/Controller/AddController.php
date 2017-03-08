<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Media;
use AppBundle\Form\MediaacensiTypeType;
use AppBundle\Form\Medialast_editionType;
use AppBundle\Form\MediapartnerType;
use AppBundle\Form\MediaplanningType;
use AppBundle\Entity\Last_edition;
use AppBundle\Form\Last_editionType;
use AppBundle\Entity\Skill;
use AppBundle\Form\SkillType;


class AddController extends Controller
{
    public function add_mediaacensiAction(Request $request)
    {
        $media = new Media();
        $form = $this->get('form.factory')->create(new MediaacensiType(), $media);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('appbundle_last_edition', array('id' => $media->getId())));
        }
        return $this->render('AppBundle:Form:acensi.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function add_medialast_editionAction(Request $request)
    {
        $media = new Media();
        $form = $this->get('form.factory')->create(new Medialast_editionType(), $media);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $media->upload();
            $em->persist($media);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('appbundle_last_edition', array('id' => $media->getId())));
        }
        return $this->render('AppBundle:Form:last_edition.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function add_mediapartnerAction(Request $request)
    {
        $media = new Media();
        $form = $this->get('form.factory')->create(new MediapartnerType(), $media);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('appbundle_last_edition', array('id' => $media->getId())));
        }
        return $this->render('AppBundle:Form:partner.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function add_mediaplanningAction(Request $request)
    {
        $media = new Media();
        $form = $this->get('form.factory')->create(new MediaplanningType(), $media);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $media->upload();
            $em->persist($media);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('appbundle_planning', array('id' => $media->getId())));
        }
        return $this->render('AppBundle:Form:planning.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function last_editionAction(Request $request)
    {
        $edition = new Last_edition();
        $form = $this->get('form.factory')->create(new Last_editionType(), $edition);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($edition);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('edition_platform_view', array('id' => $edition->getId())));
        }
        return $this->render('AppBundle:Form:last_edition.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function planningAction(Request $request)
    {
        $planning = new Planning();
        $form = $this->get('form.factory')->create(new SkillType(), $planning);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planning);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('edition_platform_view', array('id' => $planning->getId())));
        }
        return $this->render('AppBundle:Form:planning.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
