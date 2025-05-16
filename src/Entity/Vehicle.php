<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $registration = null;

    #[ORM\Column(length: 10)]
    private ?string $typeOf = null;

    #[ORM\Column(length: 8)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $technicalInspectionEndDate = null;

    #[ORM\ManyToOne(inversedBy: 'vehicle')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'vehicle')]
    private Collection $users;

    /**
     * @var Collection<int, Transport>
     */
    #[ORM\OneToMany(targetEntity: Transport::class, mappedBy: 'vehicle')]
    private Collection $transports;

    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\ManyToMany(targetEntity: Materiel::class, mappedBy: 'vehicle')]
    private Collection $materiels;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->transports = new ArrayCollection();
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): static
    {
        $this->registration = $registration;

        return $this;
    }

    public function getTypeOf(): ?string
    {
        return $this->typeOf;
    }

    public function setTypeOf(string $typeOf): static
    {
        $this->typeOf = $typeOf;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getTechnicalInspectionEndDate(): ?\DateTimeInterface
    {
        return $this->technicalInspectionEndDate;
    }

    public function setTechnicalInspectionEndDate(?\DateTimeInterface $technicalInspectionEndDate): static
    {
        $this->technicalInspectionEndDate = $technicalInspectionEndDate;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addVehicle($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeVehicle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function addTransport(Transport $transport): static
    {
        if (!$this->transports->contains($transport)) {
            $this->transports->add($transport);
            $transport->setVehicle($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): static
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getVehicle() === $this) {
                $transport->setVehicle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->addVehicle($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        if ($this->materiels->removeElement($materiel)) {
            $materiel->removeVehicle($this);
        }

        return $this;
    }
}
