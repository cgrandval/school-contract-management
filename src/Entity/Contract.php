<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 */
class Contract
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=31)
     */
    private $number;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */
    private $hourlyRate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Society")
     */
    private $society;

    /**
     * @ORM\Column(type="boolean")
     */
    private $signed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $onServer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inIntranet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Course", mappedBy="contract", cascade={"persist"})
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getHourlyRate(): ?string
    {
        return $this->hourlyRate;
    }

    public function setHourlyRate($hourlyRate): self
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    public function getHours(): float
    {
        return \array_sum(\array_map(function (Course $course) {
            return floatval($course->getHours());
        }, $this->courses->toArray()));
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getSigned(): ?bool
    {
        return $this->signed;
    }

    public function setSigned(bool $signed): self
    {
        $this->signed = $signed;

        return $this;
    }

    public function getOnServer(): ?bool
    {
        return $this->onServer;
    }

    public function setOnServer(bool $onServer): self
    {
        $this->onServer = $onServer;

        return $this;
    }

    public function getInIntranet(): ?bool
    {
        return $this->inIntranet;
    }

    public function setInIntranet(bool $inIntranet): self
    {
        $this->inIntranet = $inIntranet;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setContract($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getContract() === $this) {
                $course->setContract(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
