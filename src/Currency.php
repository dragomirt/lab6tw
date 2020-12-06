<?php
namespace src;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency")
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $symbol;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $full_name;

    /**
     * @var CurrencyValue
     * @ORM\OneToMany(targetEntity="CurrencyValue", mappedBy="currency")
     */
    private $values;


//    Methods
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return CurrencyValue
     */
    public function getValues()
    {
        return $this->values;
    }

}