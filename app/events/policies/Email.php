<?php

namespace App\events\policies;

use PHPUnit\Framework\Assert;

class Email extends DataPolicy
{
    public static function getType(): string
    {
        return "email";
    }

    protected function meetsType($data): void
    {
        Assert::assertNotFalse(filter_var($data, FILTER_VALIDATE_EMAIL));
    }
}