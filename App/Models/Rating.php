<?php

namespace App\Models;

use App\Core\Model;

class Rating extends Model
{
    protected int $id;
    protected int $user_id;
    protected int $image_id;
    protected int $value;


    public static function getRatingValueFor($imgId){
        $image_ratings = Rating::getAll("`image_id` = ?",[$imgId]);
        $rating = 0;

        foreach ($image_ratings as $image_rating){
            $rating += $image_rating->getValue();
        }
        return $rating;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getImageId(): int
    {
        return $this->image_id;
    }

    public function setImageId(int $image_id): void
    {
        $this->image_id = $image_id;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }


}