<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Addproduct;
use AppBundle\Entity\ProductPackage;
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
            $array[$index]['prix'] = $addproduct->getPrice();
            $orderline = new ProductPackage();
            $orderline->setUser($user);
            $orderline->setIdpdt($addproduct->getProduct()->getId());
            $orderline->setLibellePdt($addproduct->getProduct()->getName());
            $orderline->setTaille($addproduct->getTaille()->getName());
            $orderline->setQty($addproduct->getQuantity());
            $orderline->setYearPaquetage(2018);
            $em->persist($orderline);
            $em->flush();
        }
        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setValider(1);
        $commande->setCommande($array);
        $commande->setReference(4);

        $em->persist($commande);
        $em->flush();

        return $this->render('front/commande.html.twig', array(
            'commande' => $commande,
            'user' => $user));

    }
}
