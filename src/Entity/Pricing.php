<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PricingRepository")
 */
class Pricing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $adult;

    /**
     * @ORM\Column(type="integer")
     */
    private $child;

    /**
     * @ORM\Column(type="integer")
     */
    private $school;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdult(): ?int
    {
        return $this->adult;
    }

    public function setAdult(int $adult): self
    {
        $this->adult = $adult;

        return $this;
    }

    public function getChild(): ?int
    {
        return $this->child;
    }

    public function setChild(int $child): self
    {
        $this->child = $child;

        return $this;
    }

    public function getSchool(): ?int
    {
        return $this->school;
    }

    public function setSchool(int $school): self
    {
        $this->school = $school;

        return $this;
    }
}
