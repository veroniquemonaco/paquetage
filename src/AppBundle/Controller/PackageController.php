<?php


namespace AppBundle\Controller;



use AppBundle\Entity\Addproduct;
use AppBundle\Entity\Product;
use AppBundle\Entity\Taille;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PackageController extends Controller
{
    /**
     * @Route("/package", name="package")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AppBundle:Product')->findAll();

        if($request->isXmlHttpRequest()){
            $data = $request->get('addProduct');
            $qty = intval($data['qty']);
            $product = $em->getRepository(Product::class)
                ->findOneBy(['id' => $data['idPdt']]);
            $productId = $product->getId();
            $price = $product->getPrix();
            $amount = $price*$qty;
            $taille = $em->getRepository(Taille::class)->findOneBy(['id' => $data['taille']]);
            $addProduct = new Addproduct();
            $addProduct->setProduct($product);
            $addProduct->setTaille($taille);
            $addProduct->setQuantity($qty);



            $em->persist($addProduct);
            $em->flush();


            return new JsonResponse(array("addPdtId" => json_encode($addProduct->getProduct()->getId())));

        }

            return $this->render('front/package.html.twig', array(
                'produits' => $produits
            ));
    }



}