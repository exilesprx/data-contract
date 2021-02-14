<?php

namespace Tests\Helpers;

use App\events\policies\DataPolicy;
use PHPUnit\Framework\Assert;

class StringType extends DataPolicy
{
    public static function getType() : string
    {
        return "string";
    }

    protected function meetsType($data): void
    {
        Assert::assertTrue(is_string($data), sprintf("%s must be of type %s", $this->property, self::getType()));
    }
}