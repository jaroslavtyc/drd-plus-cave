<?php
namespace DrdPlus\Cave\TablesBundle\Tables;
use Drd\DiceRoll\Templates\Rolls\Roll1d6;

/**
 * PPH page 164, top
 * @method AmountMeasurement toMeasurement($bonus, $unit)
 */
class AmountTable extends AbstractTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(new Roll1d6()));
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/amount.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [AmountMeasurement::AMOUNT];
    }

    protected function getExpectedDataRowsCount()
    {
        return 120;
    }

    /**
     * @param int $bonus
     *
     * @return float
     */
    public function toAmount($bonus)
    {
        return $this->toMeasurement($bonus, AmountMeasurement::AMOUNT)->getValue();
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function amountToBonus($amount)
    {
        return $this->toBonus(new AmountMeasurement($amount, AmountMeasurement::AMOUNT));
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return AmountMeasurement
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new AmountMeasurement($value, $unit);
    }

}
