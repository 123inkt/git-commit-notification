<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Entity;

use DR\GitCommitNotification\Repository\RepositoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepositoryRepository::class)]
class Repository
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\OneToMany(mappedBy: 'repository', targetEntity: RepositoryProperty::class, orphanRemoval: true)]
    private ArrayCollection $repositoryProperties;

    public function __construct()
    {
        $this->repositoryProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, RepositoryProperty>
     */
    public function getRepositoryProperties(): Collection
    {
        return $this->repositoryProperties;
    }

    public function addRepositoryProperty(RepositoryProperty $repositoryProperty): self
    {
        if (!$this->repositoryProperties->contains($repositoryProperty)) {
            $this->repositoryProperties[] = $repositoryProperty;
            $repositoryProperty->setRepository($this);
        }

        return $this;
    }

    public function removeRepositoryProperty(RepositoryProperty $repositoryProperty): self
    {
        if ($this->repositoryProperties->removeElement($repositoryProperty)) {
            // set the owning side to null (unless already changed)
            if ($repositoryProperty->getRepository() === $this) {
                $repositoryProperty->setRepository(null);
            }
        }

        return $this;
    }
}
