<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['cours.read']],
    denormalizationContext: ['groups' => ['cours.write']],
    collectionOperations: [
        'get',
        'post' => ['security' => 'is_granted("ROLE_ENS")']
    ],
    itemOperations: [
        'get',
        'put' => ['security' => 'is_granted("ROLE_ETUD") and object.getOwner() == user'],
        'delete' => ['security' => 'is_granted("ROLE_ETUD") and object.getOwner() == user'],
        'patch' => ['security' => 'is_granted("ROLE_ETUD") and object.getOwner() == user'],

    ],
    attributes: ["pagination_items_per_page" => 5]
)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank(),
        Groups(['cours.read', 'cours.write'])
    ]
    private ?string $nomCours = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank(),
        Groups(['cours.read', 'cours.write'])
    ]    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank(),
        Groups(['cours.read', 'cours.write'])
    ]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank(),
        Groups(['cours.read', 'cours.write'])
    ]
    #[Assert\Choice(["Débutant", "Intermédiare", "Avancée"])]
    private ?string $difficulte = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[Groups(['cours.read', 'cours.write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[Groups(['cours.read', 'cours.write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne]
    #[Groups(['cours.read', 'cours.write'])]
    private ?User $owner = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): self
    {
        $this->nomCours = $nomCours;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
