<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Properties;

/**
 * @method static Strength getIt(int $value)
 * @see Property::getIt
 */
class Strength extends BaseProperty
{
    const STRENGTH = 'strength';

    /**
     * @return string
     */
    public function getCode()
    {
        return self::STRENGTH;
    }

}
