<?php

declare(strict_types=1);

namespace App\Http\Jne;

use App\Http\CurlClient;
use App\Http\Services\DniInterface;

class DniFactory
{
    public function create(): DniInterface
    {
        return new Dni(new CurlClient(), new DniParser());
    }
}

