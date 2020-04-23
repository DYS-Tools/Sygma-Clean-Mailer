<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ListMail", inversedBy="emails",cascade={"persist"})
     */
    private $list;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getList(): ?ListMail
    {
        return $this->list;
    }

    public function setList(?ListMail $list): self
    {
        $this->list = $list;

        return $this;
    }
}
