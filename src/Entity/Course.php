<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $hours;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Intervener")
     */
    private $intervener;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CourseLabel")
     */
    private $courseLabel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contract", inversedBy="courses")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $contract;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getIntervener(): ?Intervener
    {
        return $this->intervener;
    }

    public function setIntervener(?Intervener $intervener): self
    {
        $this->intervener = $intervener;

        return $this;
    }

    public function getCourseLabel(): ?CourseLabel
    {
        return $this->courseLabel;
    }

    public function setCourseLabel(?CourseLabel $courseLabel): self
    {
        $this->courseLabel = $courseLabel;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
