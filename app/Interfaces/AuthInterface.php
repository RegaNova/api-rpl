<?php

namespace App\Interfaces;

use App\Interfaces\BaseInterface;

interface AuthInterface extends BaseInterface
{
    public function findByEmail(string $email);
}