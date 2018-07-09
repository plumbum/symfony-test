<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @Table(
 *   uniqueConstraints={
 *     @UniqueConstraint(name="fullname_unique",columns={"first_name", "middle_name", "last_name"})
 *   },
 *   indexes={
 *     @Index(name="fullname_idx", columns={"first_name", "middle_name", "last_name"})
 *   }
 * )
 * @UniqueEntity({"first_name", "middle_name", "last_name"})
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;



    /**
     * @var \Doctrine\Common\Collections\Collection|Book[]
     *
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="authors")
     */
    protected $books;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $middle_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $last_name;


    /**
     * Author constructor.
     * Инициализируем коллекцию для many-to-many
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Собирает строку из фамилии имени отчества.
     * @return string
     */
    public function getFullName()
    {
        $names = [];
        if (!empty($this->last_name)) { $names[] = $this->last_name; }
        if (!empty($this->first_name)) { $names[] = $this->first_name; }
        if (!empty($this->middle_name)) { $names[] = $this->middle_name; }
        return implode(' ', $names);
    }

    /**
     * Собирает сроку из фамилии и.о.
     * @return string
     */
    public function getShortName()
    {
        $names = [];
        if (!empty($this->last_name)) { $names[] = $this->last_name; }
        if (!empty($this->first_name)) { $names[] = mb_substr($this->first_name, 0, 1) . '.'; }
        if (!empty($this->middle_name)) { $names[] = mb_substr($this->middle_name, 0, 1) . '.'; }
        return implode(' ', $names);
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(?string $middle_name): self
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Book[]|\Doctrine\Common\Collections\Collection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book[]|\Doctrine\Common\Collections\Collection $books
     */
    public function setBooks($books): void
    {
        $this->books = $books;
    }
}
