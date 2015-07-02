<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Properties;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Parts\BaseProperty;

/**
 * @method static Charisma getIt(int $value)
 * @see Property::getIt
 */
class Charisma extends BaseProperty
{
    const CHARISMA = 'charisma';

    /**
     * @return string
     */
    public function getCode()
    {
        return self::CHARISMA;
    }


}
