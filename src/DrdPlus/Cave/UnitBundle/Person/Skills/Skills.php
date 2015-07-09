<?php
namespace DrdPlus\Cave\UnitBundle\Person\Skills;

use DrdPlus\Cave\UnitBundle\Person\Person;
use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevels;
use DrdPlus\Cave\UnitBundle\Person\Skills\Combined\CombinedSkills;
use DrdPlus\Cave\UnitBundle\Person\Skills\Physical\PhysicalSkills;
use DrdPlus\Cave\UnitBundle\Person\Skills\Psychical\PsychicalSkills;
use Granam\Strict\Object\StrictObject;

/**
 * Skills
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Skills extends StrictObject
{
    const PHYSICAL = PhysicalSkills::PHYSICAL;
    const PSYCHICAL = PsychicalSkills::PSYCHICAL;
    const COMBINED = CombinedSkills::COMBINED;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Person
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Cave\UnitBundle\Person\Person")
     */
    private $person;

    /**
     * @var PhysicalSkills
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Cave\UnitBundle\Person\Skills\Physical\PhysicalSkills")
     */
    private $physicalSkills;

    /**
     * @var PsychicalSkills
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Cave\UnitBundle\Person\Skills\Psychical\PsychicalSkills")
     */
    private $psychicalSkills;

    /**
     * @var CombinedSkills
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Cave\UnitBundle\Person\Skills\Combined\CombinedSkills")
     */
    private $combinedSkills;

    public function __construct(ProfessionLevel $professionLevel)
    {
        $this->physicalSkills = new PhysicalSkills($professionLevel);
        $this->psychicalSkills = new PsychicalSkills($professionLevel);
        $this->combinedSkills = new CombinedSkills($professionLevel);
    }

    public function setPerson(Person $person)
    {
        $this->checkPersonToSet($person);
        $this->person = $person; // even same person is re-set (to replace "old" instance by new one)
    }

    private function checkPersonToSet(Person $person)
    {
        if (is_null($this->getId()) && is_null($person->getProfessionLevels()->getId())
            && $this !== $person->getProfessionLevels()
        ) {
            throw new \LogicException;
        }

        if ($person->getProfessionLevels()->getId() !== $this->getId()) {
            throw new Exceptions\PersonIsAlreadySet();
        }

        if ($this->getPerson() && $this->getPerson()->getId() !== $person->getId()) {
            throw new \LogicException();
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get person
     *
     * @return Person|null
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @return PhysicalSkills
     */
    public function getPhysicalSkills()
    {
        return $this->physicalSkills;
    }

    /**
     * @return PsychicalSkills
     */
    public function getPsychicalSkills()
    {
        return $this->psychicalSkills;
    }

    /**
     * @return CombinedSkills
     */
    public function getCombinedSkills()
    {
        return $this->combinedSkills;
    }

    public function getFreeNextLevelsPhysicalSkillPoints()
    {
        $nextLevelsPhysicalPropertiesSum = $this->getNextLevelsPhysicalPropertiesSum($this->getPerson()->getProfessionLevels());

        return $this->getFreeNextLevelsSkillPoints($nextLevelsPhysicalPropertiesSum, $this->getPhysicalSkills());
    }

    /**
     * @param ProfessionLevels $professionLevels
     *
     * @return int
     */
    private function getNextLevelsPhysicalPropertiesSum(ProfessionLevels $professionLevels)
    {
        return $professionLevels->getNextLevelsAgilityModifier() + $professionLevels->getNextLevelsStrengthModifier();
    }

    /**
     * @param int $nextLevelsPropertiesSum as potential of skill points
     * @param AbstractSkillsGroup $skillsGroup
     *
     * @return int
     */
    private function getFreeNextLevelsSkillPoints(
        $nextLevelsPropertiesSum,
        AbstractSkillsGroup $skillsGroup
    )
    {
        return $nextLevelsPropertiesSum - $skillsGroup->getNextLevelsSkillRankSummary();
    }

    /**
     * @return int
     */
    public function getFreeNextLevelsPsychicalSkillPoints()
    {
        $nextLevelsPsychicalPropertiesSum = $this->getNextLevelsPsychicalPropertiesSum($this->getPerson()->getProfessionLevels());

        return $this->getFreeNextLevelsSkillPoints($nextLevelsPsychicalPropertiesSum, $this->getPsychicalSkills());
    }

    /**
     * @param ProfessionLevels $professionLevels
     *
     * @return int
     */
    private function getNextLevelsPsychicalPropertiesSum(ProfessionLevels $professionLevels)
    {
        return $professionLevels->getNextLevelsIntelligenceModifier() + $professionLevels->getNextLevelsWillModifier();
    }

    /**
     * @return int
     */
    public function getFreeNextLevelsCombinedSkillPoints()
    {
        $nextLevelsCombinedPropertiesSum = $this->getNextLevelsCombinedPropertiesSum($this->getPerson()->getProfessionLevels());

        return $this->getFreeNextLevelsSkillPoints($nextLevelsCombinedPropertiesSum, $this->getCombinedSkills());
    }

    private function getNextLevelsCombinedPropertiesSum(ProfessionLevels $professionLevels)
    {
        return $professionLevels->getNextLevelsKnackModifier() + $professionLevels->getNextLevelsCharismaModifier();
    }

}
