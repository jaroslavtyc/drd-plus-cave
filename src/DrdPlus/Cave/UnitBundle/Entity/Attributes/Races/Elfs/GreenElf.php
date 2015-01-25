<?php
namespace DrdPlus\Cave\UnitBundle\Entity\Attributes\Races\Elfs;

/**
 * GreenElf
 */
class GreenElf extends Elf
{
    const SUBRACE_CODE = 'green-elf';

    const BASE_KNACK = 0;
    const BASE_WILL = -1;

    /**
     * @return string
     */
    public function getSubRaceCode()
    {
        return self::SUBRACE_CODE;
    }
}