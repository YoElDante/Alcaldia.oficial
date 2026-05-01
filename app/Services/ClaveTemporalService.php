<?php

namespace App\Services;

class ClaveTemporalService
{
    public function validate(string $password): bool
    {
        return $password !== '';
    }
}
