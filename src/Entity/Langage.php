<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LangageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LangageRepository::class)]
#[ApiResource]
class Langage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'langage', targetEntity: Framework::class)]
    private Collection $frameworks;

    public function __construct()
    {
        $this->frameworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Framework>
     */
    public function getFrameworks(): Collection
    {
        return $this->frameworks;
    }

    public function addFramework(Framework $framework): self
    {
        if (!$this->frameworks->contains($framework)) {
            $this->frameworks->add($framework);
            $framework->setLangage($this);
        }

        return $this;
    }

    public function removeFramework(Framework $framework): self
    {
        if ($this->frameworks->removeElement($framework)) {
            // set the owning side to null (unless already changed)
            if ($framework->getLangage() === $this) {
                $framework->setLangage(null);
            }
        }

        return $this;
    }
}
