<?php

namespace App\services;

use Tests\Helpers\Email;
use Tests\Helpers\Password;
use Tests\Helpers\StringType;
use App\events\policies\PolicyContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Container
{
    protected $bag;

    public function __construct()
    {
        $this->bag = Collection::make(
            [
                StringType::getType() => StringType::class,
                Email::getType() => Email::class,
                Password::getType() => Password::class
            ]
        );
    }

    public function make(string $property, array $rules) : PolicyContract
    {
        $type = Arr::get($rules, 'type');

        $class = $this->bag->get($type);

        return new $class($property, $rules);
    }
}