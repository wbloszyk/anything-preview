<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource]
#[Broadcast]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\OneToMany(mappedBy: 'addedTo', targetEntity: OrderRecord::class, orphanRemoval: true)]
    private Collection $orderRecords;

    public function __construct()
    {
        $this->orderRecords = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Zamówienie: '. ($this->id ?? 'nowe');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, OrderRecord>
     */
    public function getOrderRecords(): Collection
    {
        return $this->orderRecords;
    }

    public function addOrderRecord(OrderRecord $orderRecord): static
    {
        if (!$this->orderRecords->contains($orderRecord)) {
            $this->orderRecords->add($orderRecord);
            $orderRecord->setAddedTo($this);
        }

        return $this;
    }

    public function removeOrderRecord(OrderRecord $orderRecord): static
    {
        if ($this->orderRecords->removeElement($orderRecord)) {
            // set the owning side to null (unless already changed)
            if ($orderRecord->getAddedTo() === $this) {
                $orderRecord->setAddedTo(null);
            }
        }

        return $this;
    }
}
