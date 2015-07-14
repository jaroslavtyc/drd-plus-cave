<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Properties;

use DrdPlus\Cave\TablesBundle\Tables\Tables;
use DrdPlus\Cave\ToolsBundle\Numbers\SumAndRound;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\ExceptionalityProperties;
use DrdPlus\Cave\UnitBundle\Person\Attributes\GameCharacteristics\Combat\Attack;
use DrdPlus\Cave\UnitBundle\Person\Attributes\GameCharacteristics\Combat\Defense;
use DrdPlus\Cave\UnitBundle\Person\Attributes\GameCharacteristics\Combat\Fight;
use DrdPlus\Cave\UnitBundle\Person\Attributes\GameCharacteristics\Combat\Shooting;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Body\Size;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Body\WeightInKg;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Beauty;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Dangerousness;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Dignity;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Endurance;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\FatigueLimit;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Senses;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Speed;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\Toughness;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Derived\WoundsLimit;
use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Cave\UnitBundle\Person\Races\Gender;
use DrdPlus\Cave\UnitBundle\Person\Races\Race;
use Granam\Strict\Object\StrictObject;

class PersonProperties extends StrictObject
{

    /** @var FirstLevelProperties */
    private $firstLevelProperties;

    /** @var NextLevelsProperties */
    private $nextLevelsProperties;

    /** @var Strength */
    private $strength;

    /** @var Agility */
    private $agility;

    /** @var Knack */
    private $knack;

    /** @var Will */
    private $will;

    /** @var Intelligence */
    private $intelligence;

    /** @var Charisma */
    private $charisma;

    /** @var WeightInKg */
    private $weightInKg;

    /** @var Toughness */
    private $toughness;

    /** @var Endurance */
    private $endurance;

    /** @var Speed */
    private $speed;

    /** @var Size */
    private $size;

    /** @var Senses */
    private $senses;

    /** @var Beauty */
    private $beauty;

    /** @var Dangerousness */
    private $dangerousness;

    /** @var Dignity */
    private $dignity;

    /** @var Fight */
    private $fight;

    /** @var Attack */
    private $attack;

    /** @var Defense */
    private $defense;

    /** @var Shooting */
    private $shooting;

    /** @var WoundsLimit */
    private $woundsLimit;

    /** @var FatigueLimit */
    private $fatigueLimit;

    public function __construct(
        Race $race,
        Gender $gender,
        ExceptionalityProperties $exceptionalityProperties,
        ProfessionLevels $professionLevels,
        Tables $tables
    )
    {
        $this->firstLevelProperties = new FirstLevelProperties(
            $race,
            $gender,
            $exceptionalityProperties,
            $professionLevels,
            $tables
        );
        $this->nextLevelsProperties = new NextLevelsProperties($professionLevels);

        $this->strength = Strength::getIt(
            $this->firstLevelProperties->getFirstLevelStrength()->getValue()
            + $this->nextLevelsProperties->getStrength()->getValue()
        );
        $this->agility = Agility::getIt(
            $this->firstLevelProperties->getFirstLevelAgility()->getValue()
            + $this->nextLevelsProperties->getAgility()->getValue()
        );
        $this->knack = Knack::getIt(
            $this->firstLevelProperties->getFirstLevelKnack()->getValue()
            + $this->nextLevelsProperties->getKnack()->getValue()
        );
        $this->will = Will::getIt(
            $this->firstLevelProperties->getFirstLevelWill()->getValue()
            + $this->nextLevelsProperties->getWill()->getValue()
        );
        $this->intelligence = Intelligence::getIt(
            $this->firstLevelProperties->getFirstLevelIntelligence()->getValue()
            + $this->nextLevelsProperties->getIntelligence()->getValue()
        );
        $this->charisma = Charisma::getIt(
            $this->firstLevelProperties->getFirstLevelCharisma()->getValue()
            + $this->nextLevelsProperties->getCharisma()->getValue()
        );
        $this->weightInKg = WeightInKg::getIt(
            $this->firstLevelProperties->getFirstLevelWeightInKg()->getValue()
            + $this->nextLevelsProperties->getWeightInKg()->getValue()
        );

        // delivered properties
        $this->toughness = new Toughness($this->getStrength()->getValue() + $race->getToughnessModifier());
        $this->endurance = new Endurance(SumAndRound::round($this->getStrength()->getValue() + $this->getWill()->getValue()));
        $this->size = $this->firstLevelProperties->getFirstLevelSize(); // there is no more size increment than the first level one
        $this->speed = new Speed($this->calculateSpeed($this->getStrength(), $this->getAgility(), $this->getSize()));
        $this->senses = new Senses($this->getKnack()->getValue() + $race->getSensesModifier($gender));
        // aspects of visage
        $this->beauty = new Beauty($this->getAgility(), $this->getKnack(), $this->getCharisma());
        $this->dangerousness = new Dangerousness($this->getStrength(), $this->getWill(), $this->getCharisma());
        $this->dignity = new Dignity($this->getIntelligence(), $this->getWill(), $this->getCharisma());

        $this->fight = new Fight($professionLevels->getFirstLevel()->getProfession(), $this);
        $this->attack = new Attack($this->getAgility());
        $this->defense = new Defense($this->getAgility());
        $this->shooting = new Shooting($this->getKnack());

        $this->woundsLimit = new WoundsLimit($tables->getWoundsTable()->toWounds($this->getToughness()->getValue() + 10));
        $this->fatigueLimit = new FatigueLimit($tables->getFatigueTable()->toFatigue($this->getEndurance()->getValue() + 10));
    }

    private function calculateSpeed(Strength $strength, Agility $agility, Size $size)
    {
        return SumAndRound::average($strength->getValue(), $agility->getValue()) + $this->getSpeedBonusBySize($size);
    }

    private function getSpeedBonusBySize(Size $size)
    {
        if ($size->getValue() > 0) {
            return ceil($size->getValue() / 3) - 2; // 1 - 3 = -1; 4 - 6 = 0; 7 - 9 = +1 ...
        }

        return floor(($size->getValue() - 1) / 3) - 1; // -2 - 0 = -2 ...
    }

    /**
     * @return Strength
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @return Agility
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * @return Knack
     */
    public function getKnack()
    {
        return $this->knack;
    }

    /**
     * @return Will
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * @return Intelligence
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @return Charisma
     */
    public function getCharisma()
    {
        return $this->charisma;
    }

    /**
     * @return WeightInKg
     */
    public function getWeightInKg()
    {
        return $this->weightInKg;
    }

    /**
     * @return Toughness
     */
    public function getToughness()
    {
        return $this->toughness;
    }

    /**
     * @return Endurance
     */
    public function getEndurance()
    {
        return $this->endurance;
    }

    /**
     * @return Speed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return Senses
     */
    public function getSenses()
    {
        return $this->senses;
    }

    /**
     * @return Beauty
     */
    public function getBeauty()
    {
        return $this->beauty;
    }

    /**
     * @return Dangerousness
     */
    public function getDangerousness()
    {
        return $this->dangerousness;
    }

    /**
     * @return Dignity
     */
    public function getDignity()
    {
        return $this->dignity;
    }

    /**
     * @return Attack
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @return Defense
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @return Fight
     */
    public function getFight()
    {
        return $this->fight;
    }

    /**
     * @return Shooting
     */
    public function getShooting()
    {
        return $this->shooting;
    }

    /**
     * @return WoundsLimit
     */
    public function getWoundsLimit()
    {
        return $this->woundsLimit;
    }

    /**
     * @return FatigueLimit
     */
    public function getFatigueLimit()
    {
        return $this->fatigueLimit;
    }

    /**
     * @return FirstLevelProperties
     */
    public function getFirstLevelProperties()
    {
        return $this->firstLevelProperties;
    }

    /**
     * @return NextLevelsProperties
     */
    public function getNextLevelsProperties()
    {
        return $this->nextLevelsProperties;
    }

}
