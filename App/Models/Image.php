<?php

namespace App\Models;

use App\Core\Model;

class Image extends Model
{
    protected int $id;
    protected string $path;
    protected string $name;
    protected string $desc = "";
    protected int $autor_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    public function getAutorId(): int
    {
        return $this->autor_id;
    }

    public function setAutorId(int $autor_id): void
    {
        $this->autor_id = $autor_id;
    }


}