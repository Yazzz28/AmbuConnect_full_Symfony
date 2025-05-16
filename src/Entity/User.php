<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private const EMAIL_MAX_LENGTH = 80;
    private const PASSWORD_MAX_LENGTH = 140;
    private const NAME_MAX_LENGTH = 100;
    private const PHONE_MAX_LENGTH = 10;
    private const DEGREE_MAX_LENGTH = 25;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: self::EMAIL_MAX_LENGTH, unique: true, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(length: self::PASSWORD_MAX_LENGTH, nullable: false)]
    private ?string $password = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: self::NAME_MAX_LENGTH, nullable: false)]
    private ?string $firstname = null;

    #[ORM\Column(length: self::NAME_MAX_LENGTH, nullable: false)]
    private ?string $lastname = null;

    #[ORM\Column(length: self::PHONE_MAX_LENGTH, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: self::DEGREE_MAX_LENGTH, nullable: false)]
    private ?string $profession = null;

    #[ORM\Column(length: self::DEGREE_MAX_LENGTH, nullable: true)]
    private ?string $degree = null;

    #[ORM\Column(name: 'degree_expiration_date', type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $degreeExpirationDate = null;

    #[ORM\ManyToOne(targetEntity: Company::class)]
    #[ORM\JoinColumn(name: 'company_id', referencedColumnName: 'id', nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $passwordChangeRequired = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function setDegree(?string $degree): static
    {
        $this->degree = $degree;

        return $this;
    }

    public function getDegreeExpirationDate(): ?\DateTimeInterface
    {
        return $this->degreeExpirationDate;
    }

    public function setDegreeExpirationDate(?\DateTimeInterface $degreeExpirationDate): static
    {
        $this->degreeExpirationDate = $degreeExpirationDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function isPasswordChangeRequired(): bool
    {
        return $this->passwordChangeRequired;
    }

    public function setPasswordChangeRequired(bool $passwordChangeRequired): static
    {
        $this->passwordChangeRequired = $passwordChangeRequired;

        return $this;
    }
}