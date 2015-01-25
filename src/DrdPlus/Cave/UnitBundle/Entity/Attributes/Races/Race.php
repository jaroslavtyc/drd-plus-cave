<?php
namespace DrdPlus\Cave\UnitBundle\Entity\Attributes\Races;

use Doctrineum\Enum;

/**
 * Race
 */
abstract class Race extends Enum
{

    /** overloaded parent value to get own namespace */
    const INNER_NAMESPACE = __CLASS__;

    const BASE_STRENGTH = 0;
    const BASE_AGILITY = 0;
    const BASE_KNACK = 0;
    const BASE_WILL = 0;
    const BASE_INTELLIGENCE = 0;
    const BASE_CHARISMA = 0;
    const BASE_RESISTANCE = 0;
    const BASE_SENSES = 0;

    /**
     * Call this method on specific race, not on this abstract class (it is prohibited by exception raising anyway)
     * @see create
     * @param string $raceAndSubraceCode
     * @param string $innerNamespace
     * @return Race
     */
    public static function get($raceAndSubraceCode, $innerNamespace = self::INNER_NAMESPACE)
    {
        return parent::get($raceAndSubraceCode, $innerNamespace);
    }

    /**
     * Get strength modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getStrengthModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseStrength() + $gender->getStrengthModifier();
    }

    protected function checkGenderRace(Gender $gender)
    {
        if ($gender->getRaceCode() !== $this->getRaceCode()) {
            throw new \LogicException('Gender is not for race ' . $this->getRaceCode() . ', but for race ' . $gender->getRaceCode());
        }
        if ($gender->getSubraceCode() !== $this->getSubraceCode()) {
            throw new \LogicException('Gender is not for subrace ' . $this->getSubraceCode() . ', but for subrace ' . $gender->getSubraceCode());
        }
    }

    /**
     * @return int
     */
    protected function getBaseStrength()
    {
        return static::BASE_STRENGTH;
    }

    /**
     * Get agility modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getAgilityModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseAgility() + $gender->getAgilityModifier();
    }

    /**
     * @return int
     */
    protected function getBaseAgility()
    {
        return static::BASE_AGILITY;
    }

    /**
     * Get knack modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getKnackModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseKnack() + $gender->getKnackModifier();
    }

    /**
     * @return int
     */
    protected function getBaseKnack()
    {
        return static::BASE_KNACK;
    }

    /**
     * Get will modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getWillModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseWill() + $gender->getWillModifier();
    }

    /**
     * @return int
     */
    protected function getBaseWill()
    {
        return static::BASE_WILL;
    }

    /**
     * Get intelligence modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getIntelligenceModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseIntelligence() + $gender->getIntelligenceModifier();
    }

    /**
     * @return int
     */
    protected function getBaseIntelligence()
    {
        return static::BASE_INTELLIGENCE;
    }

    /**
     * Get charisma modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getCharismaModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseCharisma() + $gender->getCharismaModifier();
    }

    /**
     * @return int
     */
    protected function getBaseCharisma()
    {
        return static::BASE_CHARISMA;
    }

    /**
     * Get stamina modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getResistanceModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseResistance() + $gender->getResistanceModifier();
    }

    /**
     * @return int
     */
    protected function getBaseResistance()
    {
        return static::BASE_RESISTANCE;
    }

    /**
     * Get senses modifier
     * @param Gender $gender
     *
     * @return int
     */
    public function getSensesModifier(Gender $gender)
    {
        $this->checkGenderRace($gender);
        return $this->getBaseSenses() + $gender->getSensesModifier();
    }

    /**
     * @return int
     */
    protected function getBaseSenses()
    {
        return static::BASE_SENSES;
    }

    /**
     * Can see heat like snakes do?
     *
     * @return bool
     */
    public function hasInfravision()
    {
        return false;
    }

    /**
     * Has bonus to regeneration by nature itself?
     *
     * @return bool
     */
    public function hasNaturalRegeneration()
    {
        return false;
    }

    /**
     * It is so special race so dungeon master agreement is needed to play it?
     * (Races with "star")
     *
     * @return bool
     */
    public function requiresDungeonMasterAgreement()
    {
        return false;
    }

    /**
     * @param string $raceAndSubraceCode
     * @return Race
     */
    protected static function create($raceAndSubraceCode)
    {
        $race = parent::create($raceAndSubraceCode);
        /** @var $race Race */
        if ($race->getRaceCode() !== $raceAndSubraceCode) {
            // create() method, or get() respectively, has to be called on a specific race, not on this abstract one
            throw new Exceptions\UnknownRaceCode('Unknown race code ' . var_export($raceAndSubraceCode, true) . '. Has been this method called from specific race class?');
        }

        return $race;
    }

    /**
     * @return string
     */
    abstract public function getRaceCode();

    /**
     * @return string
     */
    abstract public function getSubraceCode();
}
