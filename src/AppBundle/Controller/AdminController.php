<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agence;
use AppBundle\Entity\Commande;
use AppBundle\Entity\User;
use AppBundle\Form\ExportCommandesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Valid;

class AdminController extends Controller
{
    /**
     * @Route("/admin/exports", name="export_commandes")
     */
    public function ExportCommandesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository(Commande::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        $commandesSearch='';

        $form = $this->createForm(ExportCommandesType::class);
        $form->handleRequest($request);

//        $form = $this->createFormBuilder()
//            ->add('agence', EntityType::class, [
//                'class'=>Agence::class,
//                'choice_label'=>'name'
//            ])
//            ->add('user', EntityType::class, [
//                'class'=>User::class,
//                'choice_label'=>'username'
//            ])
//            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $agence = $data['agence']->getName();
            dump($data);

            $commandesSearch = $em->getRepository(Commande::class)->searchBy($agence);
            dump($commandesSearch);
        }

        return $this->render('admin/exports.html.twig', array(
            'commandes' => $commandes,
            'form' => $form->createView(),
            'users'=>$users,
            'commandesSearch'=>$commandesSearch,
            'data'=>$agence
        ));
    }
}
