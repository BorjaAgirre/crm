<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $Apellidos = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Apodo = null;

    #[ORM\ManyToOne]
    private ?Genero $Genero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Nacimiento = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comentarios = null;

    #[ORM\OneToMany(mappedBy: 'Persona1', targetEntity: Relacionpersona::class)]
    private Collection $relacionpersonas;

    #[ORM\OneToMany(mappedBy: 'Persona', targetEntity: Relacioncolectivo::class)]
    private Collection $relacioncolectivos;

    public function __construct()
    {
        $this->relacionpersonas = new ArrayCollection();
        $this->relacioncolectivos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(?string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->Apellidos;
    }

    public function setApellidos(?string $Apellidos): self
    {
        $this->Apellidos = $Apellidos;

        return $this;
    }

    public function getApodo(): ?string
    {
        return $this->Apodo;
    }

    public function setApodo(?string $Apodo): self
    {
        $this->Apodo = $Apodo;

        return $this;
    }

    public function getGenero(): ?Genero
    {
        return $this->Genero;
    }

    public function setGenero(?Genero $Genero): self
    {
        $this->Genero = $Genero;

        return $this;
    }

    public function getNacimiento(): ?\DateTimeInterface
    {
        return $this->Nacimiento;
    }

    public function setNacimiento(?\DateTimeInterface $Nacimiento): self
    {
        $this->Nacimiento = $Nacimiento;

        return $this;
    }

    public function getComentarios(): ?string
    {
        return $this->Comentarios;
    }

    public function setComentarios(?string $Comentarios): self
    {
        $this->Comentarios = $Comentarios;

        return $this;
    }

    public function __toString(): string
    {
        $nombrecompleto = $this->Nombre." ".$this->Apellidos;
        if (isset($this->Apodo) && $this->Apodo !== '') {
            $nombrecompleto .= " (".$this->Apodo.")";
        }

        return $nombrecompleto;
    }
    /**
     * @return Collection<int, Relacionpersona>
     */
    public function getRelacionpersonas(): Collection
    {
        return $this->relacionpersonas;
    }

    public function addRelacionpersona(Relacionpersona $relacionpersona): self
    {
        if (!$this->relacionpersonas->contains($relacionpersona)) {
            $this->relacionpersonas->add($relacionpersona);
            $relacionpersona->setPersona1($this);
        }

        return $this;
    }

    public function removeRelacionpersona(Relacionpersona $relacionpersona): self
    {
        if ($this->relacionpersonas->removeElement($relacionpersona)) {
            // set the owning side to null (unless already changed)
            if ($relacionpersona->getPersona1() === $this) {
                $relacionpersona->setPersona1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Relacioncolectivo>
     */
    public function getRelacioncolectivos(): Collection
    {
        return $this->relacioncolectivos;
    }

    public function addRelacioncolectivo(Relacioncolectivo $relacioncolectivo): self
    {
        if (!$this->relacioncolectivos->contains($relacioncolectivo)) {
            $this->relacioncolectivos->add($relacioncolectivo);
            $relacioncolectivo->setPersona($this);
        }

        return $this;
    }

    public function removeRelacioncolectivo(Relacioncolectivo $relacioncolectivo): self
    {
        if ($this->relacioncolectivos->removeElement($relacioncolectivo)) {
            // set the owning side to null (unless already changed)
            if ($relacioncolectivo->getPersona() === $this) {
                $relacioncolectivo->setPersona(null);
            }
        }

        return $this;
    }
}
