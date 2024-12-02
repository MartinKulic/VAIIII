<?php

namespace App\Auth;

use App\Auth\DummyAuthenticator;

class TestAuthenticator extends DummyAuthenticator
{
    public function login($login, $password): bool
    {
        return $login == $password ;
    }

}