<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal\Evaluation;

use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use App\Model\Procurement\Entity\Supplier\Proposal\Proposal;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "procurement_proposal_scores")]
class Score
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(name: "proposal_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Proposal $proposal;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "criteria_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Criteria $criteria;

    #[ORM\Column(type: 'procurement_proposal_score')]
    private ScoreValue $score;

    #[ORM\Column]
    private string $value;

    public function __construct(Proposal $proposal, Criteria $criteria, string $value)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->proposal = $proposal;
        $this->criteria = $criteria;
        $this->score = ScoreValue::createDefault();
        $this->value = $value;
    }

    public function score(int $value): void
    {
        $this->score = new ScoreValue($value);
    }

    public function isForCriteria(Criteria $criteria): bool
    {
        return $this->criteria->getId() === $criteria->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProposal(): Proposal
    {
        return $this->proposal;
    }

    public function getCriteria(): Criteria
    {
        return $this->criteria;
    }

    public function getScore(): ScoreValue
    {
        return $this->score;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
