<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security' => 'is_granted("ROLE_ADMIN")']
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")'],
        'put' => ['security' => 'is_granted("ROLE_ADMIN")'],
        'patch' => ['security' => 'is_granted("ROLE_ENS")']

    ]
)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Cours::class)]
    #[Assert\NotBlank()]
    private Collection $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setEtudiant($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getEtudiant() === $this) {
                $cour->setEtudiant(null);
            }
        }

        return $this;
    }
}
