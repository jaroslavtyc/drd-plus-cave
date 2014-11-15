<?php

namespace DrdPlus\Cave\UnitBundle\Entity\Attributes\Professions;

use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Property;

/**
 * Priest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Priest extends Profession
{
    const PROFESSION_NAME = 'Kněz';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

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
     * Get name of the profession
     *
     * @return string
     */
    public function getProfessionName()
    {
        return self::PROFESSION_NAME;
    }

    /**
     * @return string[]
     */
    public function getMainProperties()
    {
        return [
            Property::STRENGTH_SHORT_NAME => Property::STRENGTH_NAME,
            Property::AGILITY_SHORT_NAME => Property::AGILITY_NAME,
        ];
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Priest
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }
}
