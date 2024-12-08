<?php

namespace App\Helpers;

use App\Models\Image;
use App\Models\User;
use App\Models\Rating;

class Submission
{
    protected $imageId;
    protected $image;
    protected $autorName;
    protected $autorId;
    protected $image_tags = [];
    protected $fullRating; // poc hodnoteni pozitivne nedativne, hodnotenie prihlaseneho uzivatela

    function __construct($image_id, $user_id){
        if(is_null($image_id) && is_null($user_id)){

            return $this;
        }

        $this->image = Image::getOne($image_id);
        if (is_null($this->image) ){
            return null;
        }
        $autor = User::getOne($this->image->getAutorId());
        $this->autorName = $autor?->getName() ?? "unknown";
        $this->autorId = $autor?->getId() ?? 0;

        $this->imageId=$this->image?->getId() ?? 0;

        $this->fullRating = new RatingForImgInfo($this->image->getId(), $user_id);
        return $this;
    }


    public function getRatingInfo(){
        return $this->fullRating;
    }
    public function getRatings(){
        return $this->image->getRatings();
    }

    public function getScore()
    {
        return Rating::getRatingValueFor($this->imageId);
    }
    public function delete(){
        //TODO: delete image_tags

        $ratings = $this->image->getRatings();

        foreach ($ratings as $rating){
            $rating->delete();
        }

        FileStorage::deleteFile($this->image->getPath());
        $this->image->delete();
    }
    public function getImageId(){
        return $this?->image?->getId() ?? 0;
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

    public function getImageTags(): array
    {
        return $this->image_tags;
    }

    public function setImageTags(array $image_tags): void
    {
        $this->image_tags = $image_tags;
    }






}