<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArtWork;
use AppBundle\Entity\Favorite;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Artwork controller.
 *
 * @Route("artwork")
 */
class ArtWorkController extends Controller
{
    /**
     * Lists all artWork entities.
     *
     * @Route("/", name="artwork_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artWorks = $em->getRepository('AppBundle:ArtWork')->findAll();

        return $this->render('artwork/index.html.twig', array(
            'artWorks' => $artWorks,
        ));
    }

    /**
     * Creates a new artWork entity.
     *
     * @Route("/new", name="artwork_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $artWork = new Artwork();
        $form = $this->createForm('AppBundle\Form\ArtWorkType', $artWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artWork);
            $em->flush();

            return $this->redirectToRoute('artwork_show', array('id' => $artWork->getId()));
        }

        return $this->render('artwork/new.html.twig', array(
            'artWork' => $artWork,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a artWork entity.
     *
     * @Route("/{id}", name="artwork_show")
     * @Method("GET")
     */
    public function showAction(ArtWork $artWork)
    {
        $em = $this->getDoctrine()->getManager();
        $artWorks = $em->getRepository('AppBundle:ArtWork')->findAll();
        $deleteForm = $this->createDeleteForm($artWork);
        $favorite2 = $em->getRepository('AppBundle:Favorite')->findAll();

        return $this->render('artwork/show.html.twig', [
            'artWorks' => $artWorks,
            'artWork' => $artWork,
            'delete_form' => $deleteForm->createView(),
            'favorites' => $favorite2,
        ]);
    }

    /**
     * Displays a form to edit an existing artWork entity.
     *
     * @Route("/{id}/edit", name="artwork_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ArtWork $artWork)
    {
        $deleteForm = $this->createDeleteForm($artWork);
        $editForm = $this->createForm('AppBundle\Form\ArtWorkType', $artWork);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artwork_edit', array('id' => $artWork->getId()));
        }

        return $this->render('artwork/edit.html.twig', array(
            'artWork' => $artWork,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a artWork entity.
     *
     * @Route("/{id}", name="artwork_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ArtWork $artWork)
    {
        $form = $this->createDeleteForm($artWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($artWork);
            $em->flush();
        }

        return $this->redirectToRoute('artwork_index');
    }

    /**
     * Creates a form to delete a artWork entity.
     *
     * @param ArtWork $artWork The artWork entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ArtWork $artWork)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('artwork_delete', array('id' => $artWork->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param ArtWork $artWork
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/fav/{id}", name="artwork_fav")
     * @Method("GET")
     */
    public function favAction(ArtWork $artWork)
    {
        $em = $this->getDoctrine()->getManager();
        $favorite = new Favorite();
        $favorite->setOeuvre($artWork);
        $favorite->setUser($this->getUser());
        $favorite->setFavourite(1);
        $em->persist($favorite);
        $em->flush();
        return $this->redirectToRoute('artwork_show', array('id' => $artWork->getId()));

    }

    /**
     * @param Favorite $favorite
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/defav/{id}", name="artwork_defav")
     * @Method("GET")
     */
    public function delfavAction(Favorite $favorite)
    {
        $em = $this->getDoctrine()->getManager();
        $favorite->setFavourite(0);
        $em->flush();
        return $this->redirectToRoute('artwork_show', array('id' => $favorite->getOeuvre()->getId()));

    }

}
