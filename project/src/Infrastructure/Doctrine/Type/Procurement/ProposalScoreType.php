<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Procurement;

use App\Model\Procurement\Entity\Supplier\Proposal\Evaluation\ScoreValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class ProposalScoreType extends IntegerType
{
    public const NAME = 'procurement_proposal_score';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $value instanceof ScoreValue ? $value->getValue() : (int)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ScoreValue
    {
        return $value ? new ScoreValue((int)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
