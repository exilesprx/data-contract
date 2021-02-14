<?php

namespace App\events\values;

class Password
{
    public function __toString()
    {
        return '/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,}$/';
    }
}