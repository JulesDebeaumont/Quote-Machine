<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;
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
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"quote:read"}}
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
     * @Groups({"quote:get", "quote:getAll"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"quote:get", "quote:getAll"})
     */
    private $meta;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="quotes")
     * @Groups({"quote:get", "quote:getAll"})
     */
    private $category;

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
}
