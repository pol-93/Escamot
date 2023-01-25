<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="templatetype", type="string", length=255, nullable=false)
     */
    private $templatetype;

    /**
     * @var string
     *
     * @ORM\Column(name="imghoritzontal1", type="string", length=255, nullable=true)
     */
    private $imghoritzontal1;

    /**
     * @var string
     *
     * @ORM\Column(name="imghoritzontal2", type="string", length=255, nullable=true)
     */
    private $imghoritzontal2;

    /**
     * @var string
     *
     * @ORM\Column(name="imgvertical1", type="string", length=255, nullable=true)
     */
    private $imgvertical1;

     /**
     * @var string
     *
     * @ORM\Column(name="content1", type="text", length=65535, nullable=true)
     */
    private $content1;

    /**
     * @var string
     *
     * @ORM\Column(name="content2", type="text", length=65535, nullable=true)
     */
    private $content2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $DataPublicació;

    /**
     * @var booleam
     *
     * @ORM\Column(name="activada", type="boolean", nullable=false)
     * @Assert\Regex("/[0-1]+/")
     */
    private $activada;

    /**
     * @var booleam
     *
     * @ORM\Column(name="finalitzada", type="boolean", nullable=false)
     * @Assert\Regex("/[0-1]+/")
     */
    private $finalitzada;

     /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="Blog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTemplatetype(): ?string
    {
        return $this->templatetype;
    }

    public function setTemplatetype(string $templatetype): self
    {
        $this->templatetype = $templatetype;

        return $this;
    }

    public function getImghoritzontal1(): ?string
    {
        return $this->imghoritzontal1;
    }

    public function setImghoritzontal1(string $imghoritzontal1): self
    {
        $this->imghoritzontal1 = $imghoritzontal1;

        return $this;
    }

    public function getImghoritzontal2(): ?string
    {
        return $this->imghoritzontal2;
    }

    public function setImghoritzontal2(string $imghoritzontal2): self
    {
        $this->imghoritzontal2 = $imghoritzontal2;

        return $this;
    }

    public function getImgvertical1(): ?string
    {
        return $this->imgvertical1;
    }

    public function setImgvertical1(string $imgvertical1): self
    {
        $this->imgvertical1 = $imgvertical1;

        return $this;
    }

    public function getContent1(): ?string
    {
        return $this->content1;
    }

    public function setContent1(string $content1): self
    {
        $this->content1 = $content1;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content2;
    }

    public function setContent2(string $content2): self
    {
        $this->content2 = $content2;

        return $this;
    }

    public function getDataPublicació(): ?\DateTimeInterface
    {
        return $this->DataPublicació;
    }

    public function setDataPublicació(\DateTimeInterface $DataPublicació): self
    {
        $this->DataPublicació = $DataPublicació;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isActivada(): ?bool
    {
        return $this->activada;
    }

    public function setActivada(bool $activada): self
    {
        $this->activada = $activada;

        return $this;
    }

    public function isFinalitzada(): ?bool
    {
        return $this->finalitzada;
    }

    public function setFinalitzada(bool $finalitzada): self
    {
        $this->finalitzada = $finalitzada;

        return $this;
    }
}
