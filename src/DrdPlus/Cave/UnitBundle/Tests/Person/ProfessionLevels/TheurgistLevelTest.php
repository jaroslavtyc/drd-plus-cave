<?php
namespace DrdPlus\Cave\UnitBundle\Person\ProfessionLevels;

use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Charisma;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Intelligence;
use DrdPlus\Cave\UnitBundle\Tests\Person\ProfessionLevels\AbstractTestOfProfessionLevel;

class TheurgistLevelTest extends AbstractTestOfProfessionLevel
{

    protected function getCharismaFirstLevelModifier()
    {
        return 1;
    }

    protected function getIntelligenceFirstLevelModifier()
    {
        return 1;
    }

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    protected function isPrimaryProperty($propertyName)
    {
        return in_array($propertyName, [Intelligence::INTELLIGENCE, Charisma::CHARISMA]);
    }


}