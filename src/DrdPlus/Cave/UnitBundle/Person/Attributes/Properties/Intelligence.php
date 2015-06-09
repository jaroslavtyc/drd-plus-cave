<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Properties;

/**
 * @method static Intelligence getIt(int $value)
 * @see Property::getIt
 */
class Intelligence extends BaseProperty
{
    const INTELLIGENCE = 'intelligence';

    /**
     * @return string
     */
    public function getCode()
    {
        return self::INTELLIGENCE;
    }


}
