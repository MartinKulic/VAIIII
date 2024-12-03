<?php

namespace App\Auth;

use App\Auth\DummyAuthenticator;
use App\Models\User;

class TestAuthenticator extends DummyAuthenticator
{
    public function login($login, $password): bool
    {
        $user = User::getAll("`name` LIKE ?", [$login]);
        if (count($user) == 0) {
            return false;
        }
        if ($login == $password) {
            $_SESSION['user'] = [
                "name" => $user[0]->getName(),
                "id" => $user[0]->getId()
            ];
            return true;
        } else {
            return false;
        }
    }

    public function getLoggedUserName(): string
    {
        return isset($_SESSION['user']) ? $_SESSION['user']["name"] : throw new \Exception("User not logged in");
    }


    public function getLoggedUserId(): mixed
    {
        return isset($_SESSION['user']) ? $_SESSION['user']["id"] : throw new \Exception("User not logged in");
    }


}