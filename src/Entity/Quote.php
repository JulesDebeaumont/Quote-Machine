<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\QuoteRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuoteRepository::class)
 * @ApiFilter(SearchFilter::class, properties=
 *     {
 *     "content" : "partial",
 *     "meta" : "partial",
 *     })
 * @ApiResource(
 *     attributes={"order"={"meta": "ASC"}},
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"quote:readAll"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"quote:post"}},
 *              "denormalization_context"={"groups"={"quote:post"}},
 *              "security"="is_granted('ROLE_USER')"
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"quote:read"}}
 *          },
 *          "patch"={
 *              "normalization_context"={"groups"={"quote:patch"}},
 *              "denormalization_context"={"groups"={"quote:patch"}},
 *              "security"="is_granted('ROLE_USER')"
 *          },
 *          "delete"={
 *              "normalization_context"={"groups"={"quote:delete"}},
 *              "denormalization_context"={"groups"={"quote:delete"}},
 *              "security"="is_granted('ROLE_USER')"
 *          },
 *     }
 * )
 */
class Quote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"quote:read", "quote:readAll", "quote:delete", "quote:patch", "quote:post"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"quote:read", "quote:readAll", "quote:delete", "quote:patch", "quote:post"})
     */
    private $meta;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="quotes")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     * @Groups({"quote:read", "quote:readAll", "quote:delete", "quote:patch", "quote:post"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quotes")
     * @Gedmo\Blameable(on="create")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="quoteLikes")
     */
    private $likes;

    public function __construct()
    {
        $this->creationDate = new DateTime();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getMeta(): ?string
    {
        return $this->meta;
    }

    public function setMeta(string $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }
}
