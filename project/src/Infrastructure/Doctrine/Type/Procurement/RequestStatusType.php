<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Procurement;

use App\Model\Procurement\Entity\Customer\Request\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class RequestStatusType extends StringType
{
    public const NAME = 'procurement_request_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof Status ? $value->getValue() : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        return !empty($value) ? new Status((string)$value) : null;
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
