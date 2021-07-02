<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal;

use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use Webmozart\Assert\Assert;

class CriteriaValue
{
    public function __construct(private Criteria $criteria, private string $value)
    {
        Assert::notEmpty($value);
    }

    public function getCriteria(): Criteria
    {
        return $this->criteria;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
