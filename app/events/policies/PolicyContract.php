<?php

namespace App\events\policies;

interface PolicyContract
{
    public function assertPolicyIsValid($data) : void;
    public function getPropertyName() : string;
    public function getDefault();

    public static function getType() : string;
}