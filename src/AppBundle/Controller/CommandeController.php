<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Addproduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends Controller
{
    /**
     * @Route("/commande", name="commande")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $session = new Session();
        if($session->has('panier'))
            $panier = $session->get('panier');

        $array = [];
        foreach ($panier as $index=>$addproduct) {
            $array[$index]['idpdt'] = $addproduct->getProduct()->getId();
            $array[$index]['libelle'] = $addproduct->getProduct()->getName();
            $array[$index]['qte'] = $addproduct->getQuantity();
            $array[$index]['taille'] = $addproduct->getTaille()->getName();
        }
        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setValider(1);
        $commande->setCommande($array);
        $commande->setReference(0);

        $em->persist($commande);
        $em->flush();

        return $this->render('front/commande.html.twig', array(
            'commande' => $commande,
            'user' => $user));

    }
}
