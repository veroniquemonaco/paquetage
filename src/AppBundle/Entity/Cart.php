<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Addproduct", mappedBy="cart")
     */
    private $addproducts;

    /**
     * @return mixed
     */
    public function getAddproducts()
    {
        return $this->addproducts;
    }

    /**
     * @param mixed $addproducts
     */
    public function setAddproducts($addproducts)
    {
        $this->addproducts = $addproducts;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->addproducts = new ArrayCollection();
    }

    /**
     * Add addproduct
     *
     * @param \AppBundle\Entity\Addproduct $addproduct
     *
     * @return Cart
     */
    public function addAddproduct(\AppBundle\Entity\Addproduct $addproduct)
    {
        $this->addproducts[] = $addproduct;

        return $this;
    }

    /**
     * Remove addproduct
     *
     * @param \AppBundle\Entity\Addproduct $addproduct
     */
    public function removeAddproduct(\AppBundle\Entity\Addproduct $addproduct)
    {
        $this->addproducts->removeElement($addproduct);
    }
}
