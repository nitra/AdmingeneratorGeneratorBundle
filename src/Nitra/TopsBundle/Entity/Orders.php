<?php

namespace Nitra\TopsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Orders
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
     * @ORM\OneToMany(targetEntity="OrderEntry", mappedBy="order")
     */
    private $orderEntry;

    /**
     * покупатель
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank(message="Не верно указан покупатель")
     */
    protected $buyer;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\Range(min = "0")
     */
    protected $total;



    /**
     * @ORM\Column(type="decimal", scale=2)
     *

     * @Assert\Range(min = "0")
     */
    protected $deliveryCost;

    /**
     * @var text $juridicalAddress
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * Дата изготовления
     *
     * @ORM\Column(type="date")
     * 
     * @Assert\NotBlank(message="Не верно указана дата изготовления")
     * @Assert\Date
     */
    private $madeAt;

    /**
     * Дата прихода на счет
     *
     * @ORM\Column(type="date")
     * 
     * @Assert\NotBlank(message="Не верно указана дата доставки")
     * @Assert\Date
     */
    private $deliveryDate;

    /**
     * @var text $comment
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @var string $status Статус
     * 
     * @ORM\Column(type="string", length=32)
     * 
     */
    protected $status;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     *
     */
    private $repairedCost;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     */
    private $repairedComment;

    /**
     * @ORM\OneToMany(targetEntity="\Nitra\TopsBundle\Entity\Income", mappedBy="orders")
     */
    private $incomes;
    

    public function __toString()
    {
        return (string) $this->getId();
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
     * Set buyer
     *
     * @param \Nitra\TopsBundle\Entity\Buyer $buyer
     * @return Orders
     */
    public function setBuyer(\Nitra\TopsBundle\Entity\Buyer $buyer)
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * Get buyer
     *
     * @return \Nitra\TopsBundle\Entity\Buyer 
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Orders
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set deliveryCost
     *
     * @param string $deliveryCost
     * @return Orders
     */
    public function setDeliveryCost($deliveryCost)
    {
        $this->deliveryCost = $deliveryCost;

        return $this;
    }

    /**
     * Get deliveryCost
     *
     * @return string 
     */
    public function getDeliveryCost()
    {
        return $this->deliveryCost;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Orders
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

    /**
     * Set madeAt
     *
     * @param \DateTime $madeAt
     * @return Orders
     */
    public function setMadeAt($madeAt)
    {
        $this->madeAt = $madeAt;

        return $this;
    }

    /**
     * Get madeAt
     *
     * @return \DateTime 
     */
    public function getMadeAt()
    {
        return $this->madeAt;
    }

    /**
     * Set deliveryDate
     *
     * @param \DateTime $deliveryDate
     * @return Orders
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDate
     *
     * @return \DateTime 
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Orders
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
     * @return Orders
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
     * Constructor
     */
    public function __construct()
    {
        $this->orderEntry = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add orderEntry
     *
     * @param \Nitra\TopsBundle\Entity\OrderEntry $orderEntry
     * @return Orders
     */
    public function addOrderEntry(\Nitra\TopsBundle\Entity\OrderEntry $orderEntry)
    {
        $this->orderEntry[] = $orderEntry;

        return $this;
    }

    /**
     * Remove orderEntry
     *
     * @param \Nitra\TopsBundle\Entity\OrderEntry $orderEntry
     */
    public function removeOrderEntry(\Nitra\TopsBundle\Entity\OrderEntry $orderEntry)
    {
        $this->orderEntry->removeElement($orderEntry);
    }

    /**
     * Get orderEntry
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderEntry()
    {
        return $this->orderEntry;
    }

    /**
     * Set repairedCost
     *
     * @param string $repairedCost
     * @return Orders
     */
    public function setRepairedCost($repairedCost)
    {
        $this->repairedCost = $repairedCost;

        return $this;
    }

    /**
     * Get repairedCost
     *
     * @return string 
     */
    public function getRepairedCost()
    {
        return $this->repairedCost;
    }

    /**
     * Set repairedComment
     *
     * @param string $repairedComment
     * @return Orders
     */
    public function setRepairedComment($repairedComment)
    {
        $this->repairedComment = $repairedComment;

        return $this;
    }

    /**
     * Get repairedComment
     *
     * @return string 
     */
    public function getRepairedComment()
    {
        if ($this->repairedComment || $this->getRepairedCost()) {
            return $this->repairedComment . ' (' . $this->getRepairedCost() . ' грн.)';
        }
        return;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Orders
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     *  Метод расчета оплаченной суммы по заказу
     */
    public function getPayed()
    {
        $left = 0;
        foreach ($this->incomes AS $income) {
            $left += $income->getAmount();
        }

        return $left;
    }

    /**
     * осталось оплатить
     */
    public function getPayedLeft()
    {
        return $this->getTotal() - $this->getPayed();
    }


    /**
     * Add incomes
     *
     * @param \Nitra\TopsBundle\Entity\Income $incomes
     * @return Orders
     */
    public function addIncome(\Nitra\TopsBundle\Entity\Income $incomes)
    {
        $this->incomes[] = $incomes;

        return $this;
    }

    /**
     * Remove incomes
     *
     * @param \Nitra\TopsBundle\Entity\Income $incomes
     */
    public function removeIncome(\Nitra\TopsBundle\Entity\Income $incomes)
    {
        $this->incomes->removeElement($incomes);
    }

    /**
     * Get incomes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncomes()
    {
        return $this->incomes;
    }
}
