<?php

namespace App\events\policies;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

abstract class DataPolicy implements PolicyContract
{
    protected $property;

    protected $rules;

    public function __construct(string $property, array $rules)
    {
        $this->property = $property;
        $this->rules = $rules;
    }

    public function assertPolicyIsValid($data): void
    {
        $isRequired = $this->isRequired();
        $default = $this->getDefault();

        /**
         * If a data item is not required and there is no default
         * then just let the event define the default.
         */
        if ( ! $isRequired && ! $default) {
            return;
        }

        if ($isRequired) {
            $this->meetsRequired($data);
        }

        $this->meetsLength($data);
        $this->meetsType($data);
    }

    public function getPropertyName(): string
    {
        return $this->property;
    }

    public function getDefault()
    {
        return Arr::get($this->rules, 'default');
    }

    protected function meetsRequired($data) : void
    {
        Assert::assertNotNull($data, sprintf("%s cannot be found", Str::ucfirst($this->property)));
    }

    protected function meetsLength($data) : void
    {
        $expectedLength = Arr::get($this->rules, 'length', 5);

        Assert::assertGreaterThanOrEqual($expectedLength, Str::length((string)$data), sprintf("%s must be of length %d", $this->property, $expectedLength));
    }

    protected abstract function meetsType($data) : void;

    private function isRequired() : bool
    {
        return Arr::get($this->rules, 'required', false);
    }
}