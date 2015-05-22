<?php

namespace DrdPlus\Cave\UnitBundle;

use DrdPlus\Cave\UnitBundle\Entity\Attributes\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Exceptionalities\Kinds\ExceptionalityKind;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Name;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\ProfessionLevels\LevelValue;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Agility;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Charisma;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Intelligence;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Knack;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Strength;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Properties\Will;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Races\Gender;
use DrdPlus\Cave\UnitBundle\Entity\Attributes\Races\Race;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DrdPlusCaveUnitBundle extends Bundle
{
    public function boot()
    {
        $this->registerEnums();
    }

    private function registerEnums()
    {
        Name::registerSelf();
        // only the generic race has to be registered, sub-races are registered automatically
        Race::registerSelf();
        // only the generic gender has to be registered, sub-race genders are registered automatically
        Gender::registerSelf();
        // only the generic choice has to be registered, specific choices are registered automatically
        ExceptionalityChoice::registerSelf();
        // only the generic kind has to be registered, specific kinds are registered automatically
        ExceptionalityKind::registerSelf();

        Strength::registerSelf();
        Agility::registerSelf();
        Knack::registerSelf();
        Will::registerSelf();
        Intelligence::registerSelf();
        Charisma::registerSelf();

        LevelValue::registerSelf();
    }
}
