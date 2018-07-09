<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
 * @UniqueEntity({"title", "year"})
 * @UniqueEntity({"ISBN"})
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
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books")
     * @ORM\JoinTable(
     *  name="book_author",
     *  joinColumns={
     *      @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $authors;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=0)
     * @Assert\Isbn(bothIsbnMessage="Введите корректный ISBN номер")
     */
    private $ISBN;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, minMessage="В книге должна быть хотя бы {{ limit }} страниц")
     */
    private $pages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
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

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Author[]|\Doctrine\Common\Collections\Collection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param Author[]|\Doctrine\Common\Collections\Collection $authors
     */
    public function setAuthors($authors): void
    {
        $this->authors = $authors;
    }

}
