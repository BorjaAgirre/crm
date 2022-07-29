<?php

namespace App\Entity;

use App\Repository\TiporelacionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TiporelacionRepository::class)]
class Tiporelacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Tipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Tipocontrario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->Tipo;
    }

    public function setTipo(string $Tipo): self
    {
        $this->Tipo = $Tipo;

        return $this;
    }

    public function getTipocontrario(): ?string
    {
        return $this->Tipocontrario;
    }

    public function setTipocontrario(?string $Tipocontrario): self
    {
        $this->Tipocontrario = $Tipocontrario;

        return $this;
    }

    public function __toString(): string
    {
        return $this->Tipo;
    }
}
