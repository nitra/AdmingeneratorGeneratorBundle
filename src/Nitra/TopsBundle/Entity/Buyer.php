<?php

namespace Nitra\TopsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Buyer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Buyer
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

    /** Номер телефона
     * @ORM\Column(type="string", length=15, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min="10", max="15")
     * @Assert\Regex(pattern="/[\(\)\+\-0-9]{10,15}$/", message="Телефон указан не верно")
     */
    private $phone;

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
     * @var string $email На цю пощту буде надсилатися баланс
     * 
     * @ORM\Column(type="string", length=64, nullable=true, unique=true)
     * 
     * @Assert\Length(max = "64")
     * @Assert\Email
     */
    protected $email;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=64)
     * 
     * @Assert\NotBlank
     * @Assert\Length(max = "64")
     */
    protected $address;

    public function __toString()
    {
         return $this->getName();
    }

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
     * Set phone
     *
     * @param string $phone
     * @return Buyer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Buyer
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
     * Set email
     *
     * @param string $email
     * @return Buyer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Buyer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

}
