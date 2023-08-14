<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: OrderRecordRepository::class)]
#[ApiResource]
#[Broadcast]
class OrderRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $productName = null;

    #[ORM\Column]
    private ?int $vat = null;

    #[ORM\Column]
    private ?float $priceExcl = null;

    #[ORM\Column]
    private ?float $priceIncl = null;

    #[ORM\ManyToOne(inversedBy: 'orderRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $addedTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getVat(): ?int
    {
        return $this->vat;
    }

    public function setVat(int $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getPriceExcl(): ?float
    {
        return $this->priceExcl;
    }

    public function setPriceExcl(float $priceExcl): static
    {
        $this->priceExcl = $priceExcl;

        return $this;
    }

    public function getPriceIncl(): ?float
    {
        return $this->priceIncl;
    }

    public function setPriceIncl(float $priceIncl): static
    {
        $this->priceIncl = $priceIncl;

        return $this;
    }

    public function getAddedTo(): ?Order
    {
        return $this->addedTo;
    }

    public function setAddedTo(?Order $addedTo): static
    {
        $this->addedTo = $addedTo;

        return $this;
    }
}
