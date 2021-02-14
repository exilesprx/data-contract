<?php

namespace App\events\contracts;

interface EventDataContract
{
    public static function getDataContractDefinitions() : array;
    public static function getEventName() : string;
}