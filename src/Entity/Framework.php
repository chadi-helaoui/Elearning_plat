<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FrameworkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FrameworkRepository::class)]
#[ApiResource]
class Framework
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $nomFramework = null;

    #[ORM\ManyToOne(inversedBy: 'frameworks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Langage $langage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFramework(): ?string
    {
        return $this->nomFramework;
    }

    public function setNomFramework(string $nomFramework): self
    {
        $this->nomFramework = $nomFramework;

        return $this;
    }

    public function getLangage(): ?Langage
    {
        return $this->langage;
    }

    public function setLangage(?Langage $langage): self
    {
        $this->langage = $langage;

        return $this;
    }
}
