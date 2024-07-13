<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $model;

    #[ORM\Column(type: 'string', length: 255)]
    private $make;

    #[ORM\Column(type: 'boolean')]
    private $available;

    // Getters and Setters

    /**
     * Get the value of available
     */ 
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set the value of available
     *
     * @return  self
     */ 
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get the value of make
     */ 
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set the value of make
     *
     * @return  self
     */ 
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
