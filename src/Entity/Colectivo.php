<?php

namespace App\Entity;

use App\Repository\ColectivoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColectivoRepository::class)]
class Colectivo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\OneToMany(mappedBy: 'Colectivo', targetEntity: Relacioncolectivo::class)]
    private Collection $relacioncolectivos;

    public function __construct()
    {
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

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

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
            $relacioncolectivo->setColectivo($this);
        }

        return $this;
    }

    public function removeRelacioncolectivo(Relacioncolectivo $relacioncolectivo): self
    {
        if ($this->relacioncolectivos->removeElement($relacioncolectivo)) {
            // set the owning side to null (unless already changed)
            if ($relacioncolectivo->getColectivo() === $this) {
                $relacioncolectivo->setColectivo(null);
            }
        }

        return $this;
    }
}
