<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Properties;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Parts\BaseProperty;

/**
 * @method static Agility getIt(int $value)
 * @see Property::getIt
 */
class Agility extends BaseProperty
{
    const AGILITY = 'agility';

    /**
     * @return string
     */
    public function getCode()
    {
        return self::AGILITY;
    }


}
