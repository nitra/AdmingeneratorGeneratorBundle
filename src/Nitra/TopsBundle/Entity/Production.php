<?php

namespace Nitra\TopsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Production
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Production
{

    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\SoftDeletable\SoftDeletable;

use \Admingenerator\GeneratorBundle\Traits\ValidForDelete;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=64)
     * 
     * @Assert\NotBlank
     * @Assert\Length(max = "64")
     */
    protected $name;

    /**
     * @var string 
     *
     * @ORM\Column(type="string", nullable=true,  length=64)
     * 
     * @Assert\File
     * @Assert\Length(max = "64")
     */
    protected $file;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\NotBlank
     * @Assert\Range(min = "0.01")
     */
    
    private $cost;
    /**
     * Стоимость доставки
     * @var  $assembly_cost
     * 
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\NotBlank
     * @Assert\Range(min = "0.00")
     */
    private $assemblyCost;

    /**
     * @var string $art
     *
     * @ORM\Column(type="string", length=9)
     * 
     * @Assert\NotBlank
     * @Assert\Length(max = "9")
     */
    protected $art;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Production
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return Production
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set art
     *
     * @param string $art
     * @return Production
     */
    public function setArt($art)
    {
        $this->art = $art;

        return $this;
    }

    /**
     * Get art
     *
     * @return string 
     */
    public function getArt()
    {
        return $this->art;
    }

   


    /**
     * Set file
     *
     * @param string $file
     * @return Production
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set assemblyСost
     *
     * @param string $assemblyСost
     * @return Production
     */
    public function setAssemblyСost($assemblyСost)
    {
        $this->assemblyСost = $assemblyСost;

        return $this;
    }

    /**
     * Get assemblyСost
     *
     * @return string 
     */
    public function getAssemblyСost()
    {
        return $this->assemblyСost;
    }

    /**
     * Set assemblyCost
     *
     * @param string $assemblyCost
     * @return Production
     */
    public function setAssemblyCost($assemblyCost)
    {
        $this->assemblyCost = $assemblyCost;

        return $this;
    }

    /**
     * Get assemblyCost
     *
     * @return string 
     */
    public function getAssemblyCost()
    {
        return $this->assemblyCost;
    }
}
