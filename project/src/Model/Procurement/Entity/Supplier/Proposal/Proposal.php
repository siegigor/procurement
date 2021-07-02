<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal;

use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Supplier\Proposal\Evaluation\Score;
use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Proposal
{
    private Id $id;
    private Supplier $supplier;
    private Request $request;
    private string $description;
    private \DateTimeImmutable $createdAt;
    /**
     * @var Collection<int, Score>
     */
    private Collection $scores;
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
