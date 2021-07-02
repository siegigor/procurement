<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Request;

use App\Model\Procurement\Entity\Customer\Customer\Customer;
use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "procurement_requests")]
class Request
{
    #[ORM\Id]
    #[ORM\Column(type: 'procurement_request_id')]
    private Id $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Customer $customer;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'procurement_request_status')]
    private Status $status;
    /**
     * @var Collection<int, Criteria>
     */
    #[ORM\OneToMany(mappedBy: "request", targetEntity: Criteria::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $criterias;

    public function __construct(Id $id, Customer $customer, string $description, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->status = Status::draft();
        $this->criterias = new ArrayCollection();
        $this->addCriteria(Criteria::DEFAULT_NAME, Criteria::DEFAULT_PERCENT);
    }

    public function addCriteria(string $name, float $weight): Criteria
    {
        foreach ($this->criterias as $current) {
            if ($current->isSameByName($name)) {
                throw new \DomainException($name . ' criteria is already added.');
            }
        }
        $this->criterias->add($criteria = new Criteria($this, $name, $weight));
        return $criteria;
    }

    public function publish(): void
    {
        if ($this->isPublished()) {
            throw new \DomainException('Request For Proposal is already published');
        }
        $this->status = Status::publish();
    }

    public function isPublished(): bool
    {
        return $this->status->isPublished();
    }

    public function isDraft(): bool
    {
        return $this->status->isDraft();
    }

    public function getCriteriaById(string $criteriaId): Criteria
    {
        foreach ($this->getCriterias() as $criteria) {
            if ($criteria->getId() !== $criteriaId) {
                continue;
            }
            return $criteria;
        }
        throw new \DomainException('Criteria is not found');
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
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
     * @return Criteria[]
     */
    public function getCriterias(): array
    {
        return $this->criterias->toArray();
    }
}
