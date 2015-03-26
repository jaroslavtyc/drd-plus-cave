<?php
namespace DrdPlus\Cave\UnitBundle\Entity\Attributes\Exceptionalities;

use Doctrineum\Strict\String\SelfTypedStrictStringEnum;

class Exceptionality extends SelfTypedStrictStringEnum
{
    const EXCEPTIONALITY = 'exceptionality';

    /**
     * @return Exceptionality
     */
    public static function getIt()
    {
        return static::getEnum(static::getKind());
    }

    /**
     * @return string
     */
    public static function getKind()
    {
        if (static::class === __CLASS__) {
            throw new \LogicException(
                'The base exceptionality class ' . __CLASS__ . ' has no kind. It is just a base for others.'
            );
        }

        return static::getTypeName();
    }

    /**
     * All races can be annotated just as "race" type.
     * The specific race will be build here, distinguished by the race and subrace code.
     * Warning - each specific race has to be registered as a Doctrine type,
     * @see StrictStringEnum::registerSelf()
     *
     * @param string $kind
     *
     * @return Exceptionality
     */
    protected static function createByValue($kind)
    {
        $exceptionality = parent::createByValue($kind);
        /** @var $exceptionality Exceptionality */
        if ($exceptionality::getKind() !== $kind) {
            throw new \LogicException(
                'Given exceptionality type ' . var_export($kind, true) .
                ' results into exceptionality ' . get_class($exceptionality) . ' with type ' . var_export($exceptionality::getKind(), true) . '.'
            );
        }

        return $exceptionality;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected static function getEnumClass($type)
    {
        $specificExceptionalityClass = parent::getEnumClass($type);
        if ($specificExceptionalityClass === __CLASS__) {
            throw new \LogicException(
                "Given exceptionality type {$type} is not paired with specific exceptionality class"
            );
        }

        return $specificExceptionalityClass;
    }

}
