<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected int $id;
    protected string $name;
    protected string $pass_hash;
    protected ?string $email = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPassHash(): string
    {
        return $this->pass_hash;
    }

    public function setPassHash(string $pass_hash): void
    {
        $this->pass_hash = $pass_hash;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


}