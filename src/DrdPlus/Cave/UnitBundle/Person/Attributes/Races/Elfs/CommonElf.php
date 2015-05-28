<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Races\Elfs;

class CommonElf extends Elf
{
    const SUBRACE_CODE = 'common_elf';

    /**
     * @return string
     */
    public static function getSubRaceCode()
    {
        return self::SUBRACE_CODE;
    }
}