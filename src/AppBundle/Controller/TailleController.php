<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Taille;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Taille controller.
 *
 * @Route("taille")
 */
class TailleController extends Controller
{
    /**
     * Lists all taille entities.
     *
     * @Route("/", name="taille_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tailles = $em->getRepository('AppBundle:Taille')->findAll();

        return $this->render('taille/index.html.twig', array(
            'tailles' => $tailles,
        ));
    }

    /**
     * Creates a new taille entity.
     *
     * @Route("/new", name="taille_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $taille = new Taille();
        $form = $this->createForm('AppBundle\Form\TailleType', $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taille);
            $em->flush();

            return $this->redirectToRoute('taille_show', array('id' => $taille->getId()));
        }

        return $this->render('taille/new.html.twig', array(
            'taille' => $taille,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a taille entity.
     *
     * @Route("/{id}", name="taille_show")
     * @Method("GET")
     */
    public function showAction(Taille $taille)
    {
        $deleteForm = $this->createDeleteForm($taille);

        return $this->render('taille/show.html.twig', array(
            'taille' => $taille,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing taille entity.
     *
     * @Route("/{id}/edit", name="taille_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Taille $taille)
    {
        $deleteForm = $this->createDeleteForm($taille);
        $editForm = $this->createForm('AppBundle\Form\TailleType', $taille);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taille_edit', array('id' => $taille->getId()));
        }

        return $this->render('taille/edit.html.twig', array(
            'taille' => $taille,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a taille entity.
     *
     * @Route("/{id}", name="taille_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Taille $taille)
    {
        $form = $this->createDeleteForm($taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($taille);
            $em->flush();
        }

        return $this->redirectToRoute('taille_index');
    }

    /**
     * Creates a form to delete a taille entity.
     *
     * @param Taille $taille The taille entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Taille $taille)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('taille_delete', array('id' => $taille->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
