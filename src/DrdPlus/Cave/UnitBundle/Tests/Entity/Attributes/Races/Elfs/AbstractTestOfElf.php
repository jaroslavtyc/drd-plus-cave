<?php
namespace DrdPlus\Cave\UnitBundle\Tests\Entity\Attributes\Races\Elfs;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Races\Race;
use DrdPlus\Cave\UnitBundle\Tests\Entity\Attributes\Races\AbstractTestOfRace;

abstract class AbstractTestOfElf extends AbstractTestOfRace
{

    /**
     * @test
     */
    public function can_register_self()
    {
        $raceClass = $this->getSubraceClass();
        $raceClass::registerSelf();
        $this->assertTrue(Type::hasType($raceClass::getTypeName()));
    }

    /**
     * @return Race
     *
     * @test
     * @depends can_register_self
     */
    public function can_create_self()
    {
        return parent::can_create_self();
    }

}
