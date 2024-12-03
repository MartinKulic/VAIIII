<?php

namespace App\Helpers;

use App\Models\Image;
use App\Models\User;

class Submission
{
    protected $image;
    protected $autorName;
    protected $autorId;
    protected $image_tags;

    function __construct($image_id){
        $this->image = Image::getOne($image_id);
        if (is_null($this->image) ){
            return null;
        }
        $autor = User::getOne($this->image->getAutorId());
        $this->autorName = $autor?->getName() ?? "unknown";
        $this->autorId = $autor?->getId() ?? 0;

        return $this;
    }

    public function getAutorId(): int
    {
        return $this->autorId;
    }

    public function setAutorId(int $autorId): void
    {
        $this->autorId = $autorId;
    }

    public function getAutorName(): string
    {
        return $this->autorName;
    }

    public function setAutorName(string $autorName): void
    {
        $this->autorName = $autorName;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): void
    {
        $this->image = $image;
    }





}