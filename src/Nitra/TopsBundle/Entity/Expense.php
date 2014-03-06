<?php

namespace Nitra\TopsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * Expense
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Expense
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
     * счет
     * @ORM\ManyToOne(targetEntity="CategoryExpense")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank
     */
    protected $categoryExpense;


    /**

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
     * Set date
     *
     * @param \DateTime $date
     * @return Expense
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
     * @return Expense
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
     * @return Expense
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
     * @return Expense
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
     * Set categoryExpense
     *
     * @param \Nitra\TopsBundle\Entity\CategoryExpense $categoryExpense
     * @return Expense
     */
    public function setCategoryExpense(\Nitra\TopsBundle\Entity\CategoryExpense $categoryExpense)
    {
        $this->categoryExpense = $categoryExpense;

        return $this;
    }

    /**
     * Get categoryExpense
     *
     * @return \Nitra\TopsBundle\Entity\CategoryExpense
     */
    public function getCategoryExpense()
    {
        return $this->categoryExpense;
    }
}
