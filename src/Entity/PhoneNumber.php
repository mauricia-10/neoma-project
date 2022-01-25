<?php

namespace App\Entity;

use App\Repository\PhoneNumberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhoneNumberRepository::class)
 */
class PhoneNumber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getContact(): ?contact
    {
        return $this->contact;
    }

    public function setContact(?contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
