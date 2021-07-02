<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal\Evaluation;

use Webmozart\Assert\Assert;

class ScoreValue
{
    private const LIMIT_FROM = 0;
    private const LIMIT_TO = 100;

    public function __construct(private int $score)
    {
        Assert::greaterThanEq($score, self::LIMIT_FROM);
        Assert::lessThanEq($score, self::LIMIT_TO);
    }

    public static function createDefault(): self
    {
        return new self(self::LIMIT_FROM);
    }

    public function getValue(): int
    {
        return $this->score;
    }
}
