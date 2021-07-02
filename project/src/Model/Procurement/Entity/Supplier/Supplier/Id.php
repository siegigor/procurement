<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Supplier;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    public function __construct(private string $id)
    {
        Assert::notEmpty($id);
        Assert::uuid($id);
    }

    public static function generate(): self
    {
        return new Id(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->id;
    }

    public function isEqual(self $other): bool
    {
        return $this->id === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
