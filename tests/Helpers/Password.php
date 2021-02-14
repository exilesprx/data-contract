<?php

namespace Tests\Helpers;

use App\events\policies\DataPolicy;
use PHPUnit\Framework\Assert;
use Tests\Helpers\Values\Password as PasswordValue;

class Password extends DataPolicy
{
    public static function getType(): string
    {
        return "password";
    }

    protected function meetsType($data): void
    {
        Assert::assertTrue((bool)preg_match(new PasswordValue(), $data));
    }
}