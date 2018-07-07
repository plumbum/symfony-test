<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @Table(
 *   uniqueConstraints={
 *     @UniqueConstraint(name="titleyear_unique", columns={"title", "year"}),
 *     @UniqueConstraint(name="isbn_unique", columns={"ISBN"})
 *   },
 *   indexes={
 *     @Index(name="titleyear_idx", columns={"title", "year"}),
 *     @Index(name="isbn_idx", columns={"ISBN"})
 *   }
 * )
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection|Author[]
     *
     * @ORM\ManyToMany(targetEntity="Author", mappedBy="books")
     */
    protected $authors;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=0)
     */
    private $ISBN;

    /**
     * @ORM\Column(type="integer")
     */
    private $pages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * Book constructor.
     * Инициализируем коллекцию для many-to-many
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $author_id;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getISBN()
    {
        return $this->ISBN;
    }

    public function setISBN($ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }
}
