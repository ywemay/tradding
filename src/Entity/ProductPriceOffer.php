<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductPriceOfferRepository")
 */
class ProductPriceOffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;


    /**
     * @ORM\Column(type="datetime")
     */
    private $offer_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ValidUntil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOfferDate(): ?\DateTimeInterface
    {
        return $this->offer_date;
    }

    public function setOfferDate(\DateTimeInterface $offer_date): self
    {
        $this->offer_date = $offer_date;

        return $this;
    }

    public function getValidUntil(): ?string
    {
        return $this->ValidUntil;
    }

    public function setValidUntil(string $ValidUntil): self
    {
        $this->ValidUntil = $ValidUntil;

        return $this;
    }
}
