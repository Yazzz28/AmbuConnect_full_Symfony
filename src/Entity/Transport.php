<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $arriveAt = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $typeOf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contactPhone = null;

    #[ORM\Column]
    private ?bool $isEmergency = null;

    #[ORM\Column(length: 255)]
    private ?string $emergencyCode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(length: 255)]
    private ?string $startPlace = null;

    #[ORM\Column(length: 255)]
    private ?string $endPlace = null;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\ManyToMany(targetEntity: Patient::class, mappedBy: 'transport')]
    private Collection $patients;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\ManyToMany(targetEntity: Document::class)]
    private Collection $file;

    #[ORM\ManyToOne(inversedBy: 'transports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicle $vehicle = null;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->file = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getArriveAt(): ?\DateTimeImmutable
    {
        return $this->arriveAt;
    }

    public function setArriveAt(?\DateTimeImmutable $arriveAt): static
    {
        $this->arriveAt = $arriveAt;

        return $this;
    }

    public function getTypeOf(): ?string
    {
        return $this->typeOf;
    }

    public function setTypeOf(?string $typeOf): static
    {
        $this->typeOf = $typeOf;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): static
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(?string $contactPhone): static
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    public function isEmergency(): ?bool
    {
        return $this->isEmergency;
    }

    public function setIsEmergency(bool $isEmergency): static
    {
        $this->isEmergency = $isEmergency;

        return $this;
    }

    public function getEmergencyCode(): ?string
    {
        return $this->emergencyCode;
    }

    public function setEmergencyCode(string $emergencyCode): static
    {
        $this->emergencyCode = $emergencyCode;

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

    public function getStartPlace(): ?string
    {
        return $this->startPlace;
    }

    public function setStartPlace(string $startPlace): static
    {
        $this->startPlace = $startPlace;

        return $this;
    }

    public function getEndPlace(): ?string
    {
        return $this->endPlace;
    }

    public function setEndPlace(string $endPlace): static
    {
        $this->endPlace = $endPlace;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->addTransport($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            $patient->removeTransport($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(Document $file): static
    {
        if (!$this->file->contains($file)) {
            $this->file->add($file);
        }

        return $this;
    }

    public function removeFile(Document $file): static
    {
        $this->file->removeElement($file);

        return $this;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
