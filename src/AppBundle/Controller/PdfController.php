<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends Controller
{

    /**
     * @Route("/pdf}", name="pdf")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $commandes = $em->getRepository(Commande::class)->findBy(array('user'=>$user));
        $commande = $commandes[count($commandes)-1];


        $html = $this->renderView('pdf/pdf.html.twig', array(
            'user' => $user,
            'commande' => $commande,
        ));

        $filename = sprintf('commande-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );

    }
}
