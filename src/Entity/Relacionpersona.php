<?php

namespace App\Entity;

use App\Repository\RelacionpersonaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelacionpersonaRepository::class)]
class Relacionpersona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relacionpersonas')]
    private ?Persona $Persona1 = null;

    #[ORM\ManyToOne]
    private ?Persona $Persona2 = null;

    #[ORM\ManyToOne]
    private ?Tiporelacion $Tiporelacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersona1(): ?Persona
    {
        return $this->Persona1;
    }

    public function setPersona1(?Persona $Persona1): self
    {
        $this->Persona1 = $Persona1;

        return $this;
    }

    public function getPersona2(): ?Persona
    {
        return $this->Persona2;
    }

    public function setPersona2(?Persona $Persona2): self
    {
        $this->Persona2 = $Persona2;

        return $this;
    }

    public function getTiporelacion(): ?Tiporelacion
    {
        return $this->Tiporelacion;
    }

    public function setTiporelacion(?Tiporelacion $Tiporelacion): self
    {
        $this->Tiporelacion = $Tiporelacion;

        return $this;
    }

    public function __toString(): string
    {
        $tostring = $this->Persona1->getNombre()." ".$this->Persona1->getApellidos()." -> ".$this->Persona2->getNombre().
            " (".$this->Tiporelacion->getTipo().")";
        return $tostring;
    }
}
