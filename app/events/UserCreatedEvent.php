<?php

namespace App\Events;

use Illuminate\Support\Arr;

class UserCreatedEvent extends Event
{
    public static function fromArray(array $data) : self
    {
        return new self($data);
    }

    public function getName() : string
    {
        return Arr::get($this->data, 'name');
    }

    public function getEmail() : string
    {
        return Arr::get($this->data, 'email');
    }

    public function getPassword() : string
    {
        return Arr::get($this->data, 'password');
    }

    public function getCountry() : string
    {
        return Arr::get($this->data, 'country');
    }

    public function getCompany() : ?string
    {
        return Arr::get($this->data, 'company', null);
    }
}