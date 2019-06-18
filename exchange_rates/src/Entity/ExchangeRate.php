<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="exchange_rates")
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRatesRepository")
 */
class ExchangeRate
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     *
     */
    private $base;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $target;
    /**
     * @ORM\Column(type="integer", length=11)
     * @Assert\NotBlank()
     */
    private $amount;
    /**
     * @ORM\Column(type="date")
     */
    private $date;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param mixed $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }
    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    /**
     * @return mixed
     */
    public function getDate()
    {
        return \DateTime::createFromFormat('Y-m-d', $this->date);
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}