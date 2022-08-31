<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse = null;

    #[ORM\Column(type: "array")]
    private array $propositions = [];

    #[ORM\ManyToOne(targetEntity: Qcm::class, cascade: ["persist", "remove", "merge"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qcm $qcm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getPropositions(): array
    {
        return $this->propositions;
    }

    public function setPropositions(array $propositions): self
    {
        $this->propositions = $propositions;

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
