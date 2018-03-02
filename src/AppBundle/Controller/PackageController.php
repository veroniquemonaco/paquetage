<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PackageController extends Controller
{
    /**
     * @Route("/package", name="package")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

//        $form = $this->createForm();
//        $form->handleRequest();



        $produits = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('front/package.html.twig', array(
            'produits' => $produits,
        ));
    }

}