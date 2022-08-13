<?php

namespace App\Http\Services;

use App\reniec\Person;

interface DniInterface
{
    public function get(string $dni): ?Person;
}