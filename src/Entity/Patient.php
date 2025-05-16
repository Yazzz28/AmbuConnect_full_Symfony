<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?bool $hasOxygen = false;

    #[ORM\Column]
    private ?bool $isRegular = false;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    /**
     * @var Collection<int, Transport>
     */
    #[ORM\ManyToMany(targetEntity: Transport::class, inversedBy: 'patients')]
    private Collection $transport;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'patients')]
    private Collection $company;

    public function __construct()
    {
        $this->transport = new ArrayCollection();
        $this->company = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHasOxygen(): ?bool
    {
        return $this->hasOxygen;
    }

    public function setHasOxygen(bool $hasOxygen): static
    {
        $this->hasOxygen = $hasOxygen;

        return $this;
    }

    public function getIsRegular(): ?bool
    {
        return $this->isRegular;
    }

    public function setIsRegular(bool $isRegular): static
    {
        $this->isRegular = $isRegular;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

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

    /**
     * @return Collection<int, Transport>
     */
    public function getTransport(): Collection
    {
        return $this->transport;
    }

    public function addTransport(Transport $transport): static
    {
        if (!$this->transport->contains($transport)) {
            $this->transport->add($transport);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): static
    {
        $this->transport->removeElement($transport);

        return $this;
    }

    #[Groups(['patient:table'])]
    #[SerializedName('addressString')]
    public function getAddressString(): ?string
    {
        if ($this->address) {
            return sprintf(
                '%s %s %s %s',
                $this->address->getAddress(),
                $this->address->getAdditionnal(),
                $this->address->getCity(),
                $this->address->getZipCode()
            );
        }

        return null;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    // Ajoutez cette méthode à l'entité Patient

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        $this->company->removeElement($company);

        return $this;
    }

}
