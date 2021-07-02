<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal;

use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Supplier\Proposal\Evaluation\Score;
use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "procurement_proposals")]
class Proposal
{
    #[ORM\Id]
    #[ORM\Column(type: 'procurement_proposal_id')]
    private Id $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "supplier_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Supplier $supplier;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "request_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Request $request;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;
    /**
     * @var Collection<int, Score>
     */
    #[ORM\OneToMany(mappedBy: "proposal", targetEntity: Score::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $scores;

    #[ORM\Column(type: 'procurement_proposal_status')]
    private Status $status;

    /**
     * @param CriteriaValue[] $criteriasValues
     */
    public function __construct(
        Id $id,
        Supplier $supplier,
        Request $request,
        string $description,
        \DateTimeImmutable $createdAt,
        array $criteriasValues
    ) {
        $this->id = $id;
        $this->supplier = $supplier;
        $this->request = $request;
        $this->description = $description;
        $this->status = Status::wait();
        $this->createdAt = $createdAt;
        $this->scores = new ArrayCollection();
        $this->addScores($criteriasValues);
    }

    /**
     * @param CriteriaValue[] $criteriasValues
     */
    private function addScores(array $criteriasValues): void
    {
        foreach ($criteriasValues as $criteriaValue) {
            $this->scores->add(
                new Score($this, $criteriaValue->getCriteria(), $criteriaValue->getValue())
            );
        }
    }

    public function score(int $value, Criteria $criteria): void
    {
        $score = $this->getCriteriaScore($criteria);
        $score->score($value);
    }

    public function getCriteriaScore(Criteria $criteria): Score
    {
        foreach ($this->scores as $score) {
            if (!$score->isForCriteria($criteria)) {
                continue;
            }
            return $score;
        }
        throw new \DomainException('Criteria is not found in the Proposal');
    }

    public function accept(): void
    {
        if ($this->isAccepted()) {
            throw new \DomainException('Proposal is already accepted');
        }
        $this->status = Status::accept();
    }

    public function reject(): void
    {
        if ($this->isRejected()) {
            throw new \DomainException('Proposal is already rejected');
        }
        $this->status = Status::reject();
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isAccepted(): bool
    {
        return $this->status->isAccepted();
    }

    public function isRejected(): bool
    {
        return $this->status->isRejected();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Score[]
     */
    public function getScores(): array
    {
        return $this->scores->toArray();
    }
}
