<?php

namespace Nitra\TopsBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * OrderEntry
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OrderEntry
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
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="orderEntry")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $order;




    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     * 
     */
    private $quantity;

    /**
     * товар
     * @ORM\ManyToOne(targetEntity="Production")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\NotBlank
     */
    protected $production;

        /**
     * @var string $orientation 
     * 
     * @ORM\Column(type="string", length=11)
     * 
     * @Assert\NotBlank
     * @Assert\Choice(
     *     choices = { "Правый", "Левый", "" },
     *     message = "Неверный параметр")
     */
    protected $orientation;
    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     */
    private $price;
    
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;
    
     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;
    
      /**
     * @ORM\ManyToMany(targetEntity="Colors")
     * @ORM\JoinTable(name="orderEntry_colors")
     */

    protected $color;

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
     * Set orientation
     *
     * @param string $orientation
     * @return OrderEntry
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string 
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderEntry
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return OrderEntry
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return OrderEntry
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return OrderEntry
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return OrderEntry
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set orderId
     *
     * @param \Nitra\TopsBundle\Entity\Orders $orderId
     * @return OrderEntry
     */
    public function setOrderId(\Nitra\TopsBundle\Entity\Orders $orderId = null)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return \Nitra\TopsBundle\Entity\Orders 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set production
     *
     * @param \Nitra\TopsBundle\Entity\Production $production
     * @return OrderEntry
     */
    public function setProduction(\Nitra\TopsBundle\Entity\Production $production = null)
    {
        $this->production = $production;

        return $this;
    }

    /**
     * Get production
     *
     * @return \Nitra\TopsBundle\Entity\Production 
     */
    public function getProduction()
    {
        return $this->production;
    }
  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->color = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set order
     *
     * @param \Nitra\TopsBundle\Entity\Orders $order
     * @return OrderEntry
     */
    public function setOrder(\Nitra\TopsBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Nitra\TopsBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add color
     *
     * @param \Nitra\TopsBundle\Entity\Colors $color
     * @return OrderEntry
     */
    public function addColor(\Nitra\TopsBundle\Entity\Colors $color)
    {
        $this->color[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param \Nitra\TopsBundle\Entity\Colors $color
     */
    public function removeColor(\Nitra\TopsBundle\Entity\Colors $color)
    {
        $this->color->removeElement($color);
    }

    /**
     * Set assemblyCost
     *
     * @param string $assemblyCost
     * @return OrderEntry
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
