<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Races;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrineum\Strict\String\SelfTypedStrictStringEnum;

/**
 * @method static Gender getType(string $name),
 * @see SelfTypedStrictStringEnum::getType or for original
 * @see \Doctrine\DBAL\Types\Type::getType
 *
 * @method Gender convertToPHPValue(string $value, AbstractPlatform $platform)
 * @see SelfTypedStrictStringEnum::convertToPHPValue or for original
 * @see EnumType::convertToPHPValue
 *
 * @method static Gender getEnum(mixed $value)
 * @see SelfTypedStrictStringEnum::getEnum or for original
 * @see EnumTrait::getEnum
 */
class Gender extends SelfTypedStrictStringEnum
{
    const GENDER = 'gender';

    const MALE_CODE = 'male';
    const FEMALE_CODE = 'female';

    /**
     * @return Gender
     */
    public static function getIt()
    {
        return static::getEnum(static::getRaceSubraceAndGenderCode());
    }

    /**
     * Gets the strongly recommended name of this type.
     * Its used at @see \Doctrine\DBAL\Platforms\AbstractPlatform::getDoctrineTypeComment
     *
     * @return string
     */
    public static function getTypeName()
    {
        if (static::class === __CLASS__) {
            return parent::getTypeName();
        }

        return static::getRaceSubraceAndGenderCode();
    }

    /**
     * @param string $enumValue
     * @return string
     */
    protected static function getEnumClass($enumValue)
    {
        $specificRaceGenderClass = parent::getEnumClass($enumValue);
        if ($specificRaceGenderClass === __CLASS__) {
            throw new Exceptions\GenericRaceCanNotBeCreated('Call this factory method from specific race gender.');
        }

        return $specificRaceGenderClass;
    }

    /**
     * All genders can be annotated just as "gender" type.
     * The specific gender will be build here, distinguished by the race, subrace and gender code.
     *
     * @param string $raceAndSubraceGenderCode
     * @throws Exceptions\UnexpectedGenderCode
     * @return Gender
     */
    protected static function createByValue($raceAndSubraceGenderCode)
    {
        $gender = parent::createByValue($raceAndSubraceGenderCode);
        /** @var $gender Gender */
        if ($gender::getRaceSubraceAndGenderCode() !== $raceAndSubraceGenderCode) {
            throw new Exceptions\UnexpectedGenderCode(
                'Unknown race, subrace and gender code ' . var_export($raceAndSubraceGenderCode, true) . '. ' .
                'Got gender with race, subrace and gender code ' . var_export($gender::getRaceSubraceAndGenderCode(), true) . '. ' .
                'Has been this method called from specific gender class?'
            );
        }

        return $gender;
    }

    /**
     * @return string
     */
    protected static function getRaceSubraceAndGenderCode()
    {
        return self::buildRaceAndSubraceGenderCode(static::getRaceCode(), static::getSubraceCode(), static::getGenderCode());
    }

    /**
     * @return string
     */
    public static function getRaceCode() {
        throw new Exceptions\MissingRaceCodeImplementation(
            'The gender class ' . static::class . ' has not implemented ' . __METHOD__ . ' method.'
        );
    }

    /**
     * @return string
     */
    public static function getSubraceCode() {
        throw new Exceptions\MissingSubraceCodeImplementation(
            'The gender class ' . static::class . ' has not implemented ' . __METHOD__ . ' method.'
        );
    }

    /**
     * @return string
     */
    protected static function getGenderCode()
    {
        if (static::isMale() && static::isFemale()) {
            throw new Exceptions\AmbiguousGender(
                'Gender ' . static::class . ' can not be male and female at once'
            );
        }

        if (static::isMale()) {
            return self::MALE_CODE;
        }

        if (static::isFemale()) {
            return self::FEMALE_CODE;
        }

        throw new Exceptions\UnknownGender('Expected male or female of gender class ' . static::class);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param string $genderCode
     * @return string
     */
    public static function buildRaceAndSubraceGenderCode($raceCode, $subraceCode, $genderCode)
    {
        return "$raceCode-$subraceCode-$genderCode";
    }

    public static function registerSelfSubRaceGender()
    {
        return static::addSubTypeEnum(
            static::class,
            '~^' . static::getRaceSubraceAndGenderCode() . '$~'
        );
    }

    /**
     * @return bool
     */
    public static function isMale() {
        throw new Exceptions\MaleDetectionNotImplemented();
    }

    /**
     * @return bool
     */
    public static function isFemale() {
        throw new Exceptions\FemaleDetectionNotImplemented();
    }

    /**
     * Get strength modifier
     *
     * @return int
     */
    public function getStrengthModifier()
    {
        return 0;
    }

    /**
     * Get agility modifier
     *
     * @return int
     */
    public function getAgilityModifier()
    {
        return 0;
    }

    /**
     * Get knack modifier
     *
     * @return int
     */
    public function getKnackModifier()
    {
        return 0;
    }

    /**
     * Get will modifier
     *
     * @return int
     */
    public function getWillModifier()
    {
        return 0;
    }

    /**
     * Get intelligence modifier
     *
     * @return int
     */
    public function getIntelligenceModifier()
    {
        return 0;
    }

    /**
     * Get charisma modifier
     *
     * @return int
     */
    public function getCharismaModifier()
    {
        return 0;
    }

    /**
     * Get resistance modifier
     *
     * @return int
     */
    public function getResistanceModifier()
    {
        return 0;
    }

    /**
     * Get senses modifier
     *
     * @return int
     */
    public function getSensesModifier()
    {
        return 0;
    }

}