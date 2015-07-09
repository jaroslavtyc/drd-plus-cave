<?php
namespace DrdPlus\Cave\UnitBundle\Person;

use DrdPlus\Cave\TablesBundle\Tables\Fatigue\FatigueTable;
use DrdPlus\Cave\TablesBundle\Tables\Tables;
use DrdPlus\Cave\TablesBundle\Tables\Weight\WeightTable;
use DrdPlus\Cave\TablesBundle\Tables\Wounds\WoundsTable;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Exceptionality;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\ExceptionalityProperties;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Name;
use DrdPlus\Cave\UnitBundle\Person\Background\Background;
use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Agility;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Charisma;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Intelligence;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Knack;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Strength;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Properties\Will;
use DrdPlus\Cave\UnitBundle\Person\Professions\Profession;
use DrdPlus\Cave\UnitBundle\Person\Races\Gender;
use DrdPlus\Cave\UnitBundle\Person\Races\Race;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

class PersonTest extends TestWithMockery
{

    /** @test */
    public function can_create_instance()
    {
        $instance = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertNotNull($instance);
    }

    /** @test */
    public function base_id_is_null()
    {
        $person = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertNull($person->getId());
    }

    /** @test */
    public function returns_same_race_as_got()
    {
        $person = new Person(
            $race = $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertSame($race, $person->getRace());
    }

    /** @test */
    public function returns_same_gender_as_got()
    {
        $person = new Person(
            $this->getRaceMock(),
            $gender = $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertSame($gender, $person->getGender());
    }

    /** @test */
    public function returns_same_exceptionality_as_got()
    {
        $person = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $exceptionality = $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertSame($exceptionality, $person->getExceptionality());
    }

    /** @test */
    public function returns_same_profession_levels_as_got()
    {
        $person = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $professionLevels = $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertSame($professionLevels, $person->getProfessionLevels());
    }

    /** @test */
    public function returns_same_name_as_got()
    {
        $person = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $name = $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        $this->assertSame($name, $person->getName());
    }

    /** @test */
    public function can_change_name()
    {
        $person = new Person(
            $this->getRaceMock(),
            $this->getGenderMock(),
            $this->getNameMock(),
            $this->getExceptionalityMock(),
            $this->getProfessionLevelsMock(),
            $this->getBackgroundMock(),
			$this->getTablesMock()
        );
        Name::registerSelf();
        $person->setName($name = Name::getEnum($nameString = 'foo'));
        $this->assertSame($name, $person->getName());
        $this->assertSame($nameString, (string)$person->getName());
        $person->setName($newName = Name::getEnum($newNameString = 'bar'));
        $this->assertSame($newName, $person->getName());
        $this->assertSame($newNameString, (string)$person->getName());
    }

    /**
     * @return Race
     */
    private function getRaceMock()
    {
        $race = \Mockery::mock(Race::class);
        $race->shouldReceive('getStrengthModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getAgilityModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getKnackModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getWillModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getIntelligenceModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getCharismaModifier')
            ->atLeast()
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getToughnessModifier')
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getSizeModifier')
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getSensesModifier')
            ->once()
            ->andReturn(0);
        $race->shouldReceive('getWeightInKg')
            ->once()
            ->andReturn(0);

        return $race;
    }

    /**
     * @return Gender
     */
    private function getGenderMock()
    {
        return \Mockery::mock(Gender::class);
    }

    /**
     * @return Exceptionality
     */
    private function getExceptionalityMock()
    {
        $exceptionality = \Mockery::mock(Exceptionality::class);
        $exceptionality->shouldReceive('getExceptionalityProperties')
            ->atLeast()
            ->once()
            ->andReturn($exceptionalityProperties = \Mockery::mock(ExceptionalityProperties::class));
        $exceptionalityProperties->shouldReceive('getStrength')
            ->atLeast()
            ->once()
            ->andReturn($strength = \Mockery::mock(Strength::class));
        $strength->shouldReceive('getValue')
            ->andReturn(0);
        $exceptionalityProperties->shouldReceive('getAgility')
            ->atLeast()
            ->once()
            ->andReturn($agility = \Mockery::mock(Agility::class));
        $agility->shouldReceive('getValue')
            ->andReturn(0);
        $exceptionalityProperties->shouldReceive('getKnack')
            ->atLeast()
            ->once()
            ->andReturn($knack = \Mockery::mock(Knack::class));
        $knack->shouldReceive('getValue')
            ->andReturn(0);
        $exceptionalityProperties->shouldReceive('getWill')
            ->once()
            ->andReturn($will = \Mockery::mock(Will::class));
        $will->shouldReceive('getValue')
            ->andReturn(0);
        $exceptionalityProperties->shouldReceive('getIntelligence')
            ->once()
            ->andReturn($intelligence = \Mockery::mock(Intelligence::class));
        $intelligence->shouldReceive('getValue')
            ->andReturn(0);
        $exceptionalityProperties->shouldReceive('getCharisma')
            ->once()
            ->andReturn($charisma = \Mockery::mock(Charisma::class));
        $charisma->shouldReceive('getValue')
            ->andReturn(0);

        return $exceptionality;
    }

    /**
     * @return ProfessionLevels
     */
    private function getProfessionLevelsMock()
    {
        $professionLevels = \Mockery::mock(ProfessionLevels::class);

        $professionLevels->shouldReceive('getFirstLevel')->once()->andReturn($firstLevel = \Mockery::mock(ProfessionLevel::class));
        $firstLevel->shouldReceive('getProfession')->once()->andReturn(\Mockery::mock(Profession::class));

        $professionLevels->shouldReceive('getStrengthModifierForFirstProfession')->atLeast()->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsStrengthModifier')->atLeast()->once()->andReturn(0);

        $professionLevels->shouldReceive('getAgilityModifierForFirstProfession')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsAgilityModifier')->once()->andReturn(0);

        $professionLevels->shouldReceive('getKnackModifierForFirstProfession')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsKnackModifier')->once()->andReturn(0);

        $professionLevels->shouldReceive('getWillModifierForFirstProfession')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsWillModifier')->once()->andReturn(0);

        $professionLevels->shouldReceive('getIntelligenceModifierForFirstProfession')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsIntelligenceModifier')->once()->andReturn(0);

        $professionLevels->shouldReceive('getCharismaModifierForFirstProfession')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsCharismaModifier')->once()->andReturn(0);

        $professionLevels->shouldReceive('getWeightKgModifierForFirstLevel')->once()->andReturn(0);
        $professionLevels->shouldReceive('getNextLevelsWeightModifier')->once()->andReturn(0);

        return $professionLevels;
    }

    /**
     * @return \Mockery\MockInterface|Background
     */
    private function getBackgroundMock()
    {
        $background = \Mockery::mock(Background::class);

        return $background;
    }

    /**
     * @return Tables
     */
    private function getTablesMock()
    {
        $tables = \Mockery::mock(Tables::class);

        $tables->shouldReceive('getWeightTable')
            ->once()
            ->andReturn($weightTable = \Mockery::mock(WeightTable::class));
        $tables->shouldReceive('getWoundsTable')
            ->atLeast()->once()
            ->andReturn($fatigueTable = \Mockery::mock(WoundsTable::class));
        $fatigueTable->shouldReceive('toWounds')
            ->with(\Mockery::type('int'))
            ->atLeast()->once()
            ->andReturn(10);
        $tables->shouldReceive('getFatigueTable')
            ->atLeast()->once()
            ->andReturn($fatigueTable = \Mockery::mock(FatigueTable::class));
        $fatigueTable->shouldReceive('toFatigue')
            ->with(\Mockery::type('int'))
            ->atLeast()->once()
            ->andReturn(10);

        return $tables;
    }

    /**
     * @return Name
     */
    private function getNameMock()
    {
        return \Mockery::mock(Name::class);
    }
}
