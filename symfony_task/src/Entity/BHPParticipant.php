<?php

namespace App\Entity;

use App\Repository\BHPParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BHPParticipantRepository::class)]
class BHPParticipant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: BHP::class, inversedBy: 'BHPParticipants')]
    #[ORM\JoinColumn(nullable: false)]
    private $bhp;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $company;

    #[ORM\Column(type: 'text', nullable: true)]
    private $signature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBhp(): ?BHP
    {
        return $this->bhp;
    }

    public function setBhp(?BHP $bhp): self
    {
        $this->bhp = $bhp;

        return $this;
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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }
}
