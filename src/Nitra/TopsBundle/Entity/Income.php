<?php

namespace Nitra\TopsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Income
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Income {

    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\SoftDeletable\SoftDeletable;

    use \Admingenerator\GeneratorBundle\Traits\ValidForDelete;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Дата прихода на счет
     *
     * @ORM\Column(type="date")
     * 
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\NotBlank
     * @Assert\Range(min = "0.01")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;
    
    /**
     * счет
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank
     */
    protected $account;
    
      /**
     * заказ
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\NotBlank
     */
    protected $orders;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Income
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Income
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
     * Set comment
     *
     * @param string $comment
     * @return Income
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
     * Set account
     *
     * @param \Nitra\TopsBundle\Entity\Account $account
     * @return Income
     */
    public function setAccount(\Nitra\TopsBundle\Entity\Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Nitra\TopsBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set orders
     *
     * @param \Nitra\TopsBundle\Entity\Orders $orders
     * @return Income
     */
    public function setOrders(\Nitra\TopsBundle\Entity\Orders $orders = null)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return \Nitra\TopsBundle\Entity\Orders 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
