<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @assert\NotBlank
     * @assert\Regex(
     *      pattern = "/^[a-zA-Z ]{3,180}$/",
     *      message = "El nom ha de tenir entre 3 y 180 caracteres")
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180)
     * @assert\NotBlank
     * @assert\Regex(
     *      pattern = "/^[a-zA-ZàÀèéÈÉíÍòóÒÓúÚ ]{3,180}$/", 
     *      message = "L'àlies ha de tenir entre 3 y 180 caracteres no es permeten caracters especials i ha d'estar correctament accentuat en cas necessari"
     * )
     */
    private $nickname;
     /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @assert\NotBlank
     * @assert\Email(
     *      message = "El email '{{ value }}' no es valido",
     * )
     */
    private $email;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @assert\NotBlank
     * @assert\Regex(
     *      pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", 
     *      message = "Mínim 8 caràcters. Mínim una majúscula, una minúscula i un número i un caràcter especial (caràcters especials permesos: @$!%*#?&)"
     * )
     */
    private $password;

     /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(name="googleAuthenticatorSecret", type="string", nullable=true)
     */
    private $googleAuthenticatorSecret;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manifest", mappedBy="user")
     */
    private $Manifest;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="user")
     */
    private $Blog;

    public function __construct()
    {
        $this->Manifest = new ArrayCollection();
        $this->Blog = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->googleAuthenticatorSecret;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->email;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }

    /**
     * @return Collection|Manifest[]
     */
    public function getManifests():Collection{
        return $this->Manifest;

    }

     /**
     * @return Collection|Manifest[]
     */
    public function getBlog():Collection{
        return $this->Blog;

    }

    /**
     * @return Collection<int, Manifest>
     */
    public function getManifest(): Collection
    {
        return $this->Manifest;
    }

    public function addManifest(Manifest $manifest): self
    {
        if (!$this->Manifest->contains($manifest)) {
            $this->Manifest[] = $manifest;
            $manifest->setUser($this);
        }

        return $this;
    }

    public function removeManifest(Manifest $manifest): self
    {
        if ($this->Manifest->removeElement($manifest)) {
            // set the owning side to null (unless already changed)
            if ($manifest->getUser() === $this) {
                $manifest->setUser(null);
            }
        }

        return $this;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->Blog->contains($blog)) {
            $this->Blog[] = $blog;
            $blog->setUser($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->Blog->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getUser() === $this) {
                $blog->setUser(null);
            }
        }

        return $this;
    }

}
