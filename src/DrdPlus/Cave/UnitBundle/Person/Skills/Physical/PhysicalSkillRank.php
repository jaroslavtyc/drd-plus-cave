<?php
namespace DrdPlus\Cave\UnitBundle\Person\Skills\Physical;

use DrdPlus\Cave\UnitBundle\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Cave\UnitBundle\Person\Skills\AbstractSkillRank;
use Granam\Integer\IntegerObject;
use Doctrine\Common\Annotations as ORM;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PhysicalSkillRank extends AbstractSkillRank
{
    public function __construct(ProfessionLevel $professionLevel, PhysicalSkillPoint $skillPoint, IntegerObject $requiredRankValue)
    {
        parent::__construct($professionLevel, $skillPoint, $requiredRankValue);
    }
}
