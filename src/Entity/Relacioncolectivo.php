<?php

namespace App\Entity;

use App\Repository\RelacioncolectivoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelacioncolectivoRepository::class)]
class Relacioncolectivo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relacioncolectivos')]
    private ?Persona $Persona = null;

    #[ORM\ManyToOne(inversedBy: 'relacioncolectivos')]
    private ?Colectivo $Colectivo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersona(): ?Persona
    {
        return $this->Persona;
    }

    public function setPersona(?Persona $Persona): self
    {
        $this->Persona = $Persona;

        return $this;
    }

    public function getColectivo(): ?Colectivo
    {
        return $this->Colectivo;
    }

    public function setColectivo(?Colectivo $Colectivo): self
    {
        $this->Colectivo = $Colectivo;

        return $this;
    }

    public function __toString(): string
    {
        $tostring = $this->Persona->getNombre()." -> ".$this->Colectivo->getNombre();
        return $tostring;
    }
}
