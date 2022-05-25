<?php

namespace App\Entity;

use App\Repository\BHPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BHPRepository::class)]
class BHP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'bhp', targetEntity: BHPParticipant::class, orphanRemoval: true)]
    private $BHPParticipants;

    public function __construct()
    {
        $this->BHPParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|BHPParticipant[]
     */
    public function getBHPParticipants(): Collection
    {
        return $this->BHPParticipants;
    }

    public function addBHPParticipant(BHPParticipant $participant): self
    {
        if (!$this->BHPParticipants->contains($participant)) {
            $this->BHPParticipants[] = $participant;
            $participant->setBhp($this);
        }

        return $this;
    }

    public function removeBHPParticipant(BHPParticipant $participant): self
    {
        if ($this->BHPParticipants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getBhp() === $this) {
                $participant->setBhp(null);
            }
        }

        return $this;
    }
}
