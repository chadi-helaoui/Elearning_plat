<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user = null;

    #[ORM\Column]
    private ?int $nbReponsesOK = null;

    #[ORM\Column]
    private ?int $nbQuestions = null;

    #[ORM\ManyToOne(inversedBy: 'resultats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qcm $qcm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbReponsesOK(): ?int
    {
        return $this->nbReponsesOK;
    }

    public function setNbReponsesOK(int $nbReponsesOK): self
    {
        $this->nbReponsesOK = $nbReponsesOK;

        return $this;
    }

    public function getNbQuestions(): ?int
    {
        return $this->nbQuestions;
    }

    public function setNbQuestions(int $nbQuestions): self
    {
        $this->nbQuestions = $nbQuestions;

        return $this;
    }

    public function getQcm(): ?Qcm
    {
        return $this->qcm;
    }

    public function setQcm(?Qcm $qcm): self
    {
        $this->qcm = $qcm;

        return $this;
    }
}
