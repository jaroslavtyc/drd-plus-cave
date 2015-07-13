<?php
namespace DrdPlus\Cave\TablesBundle\Tables\Experiences;

use DrdPlus\Cave\TablesBundle\Tables\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;

class LevelMeasurement extends AbstractMeasurement
{
    const LEVEL = 'level';
    const LEVEL_TO_EXPERIENCES_BONUS_SHIFT = ExperiencesMeasurement::EXPERIENCES_TO_LEVEL_BONUS_SHIFT;

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct($value, $unit = self::LEVEL, ExperiencesTable $experiencesTable)
    {
        $this->experiencesTable = $experiencesTable;
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return [self::LEVEL];
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkUnit($unit);
        if ($this->getValue() !== ToInteger::toInteger($value)) {
            throw new \LogicException("Experiences already has a value {$this->getValue()} and can not be replaced by $value");
        }
    }

    /**
     * @return int
     */
    public function toLevel()
    {
        return ToInteger::toInteger($this->getValue());
    }

    /**
     * @return int
     */
    public function toExperiences()
    {
        return $this->convertLevelToExperiences($this->getValue());
    }

    /**
     * Experiences, need from previous to current level
     *
     * @param int $levelValue
     *
     * @return int
     */
    private function convertLevelToExperiences($levelValue)
    {
        // shifted level value is bonus of required experiences
        return $this->experiencesTable->toExperiences($levelValue + self::LEVEL_TO_EXPERIENCES_BONUS_SHIFT);
    }

    /**
     * Summary of experiences, need to achieve current level
     *
     * @return int
     */
    public function toTotalExperiences()
    {
        $level = $this->getValue();
        $experiencesSum = 0;
        for ($levelToCast = $level; $levelToCast > 0; $levelToCast--) {
            $experiencesSum += $this->convertLevelToExperiences($levelToCast);
        }

        return $experiencesSum;
    }

}