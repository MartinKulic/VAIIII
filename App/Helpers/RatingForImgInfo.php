<?php

namespace App\Helpers;

use App\Models\Rating;
use stdClass;

// poc hodnoteni pozitivne nedativne, hodnotenie prihlaseneho uzivatela
class RatingForImgInfo extends StdClass
{
    protected $up=0;
    protected $down =0;
    protected $score=0;
    protected $curUserVote=0;

    public function __construct($imgId, $userID)
    {
        $ratings = Rating::getAll("`image_id` = ?",[$imgId]);

        foreach ($ratings as $rating) {
            $ratingVal = $rating->getValue();
            if ($rating->getUserId() == $userID) {
                $this->curUserVote = $ratingVal;
            }
            if ($ratingVal>0){
                $this->up++;
            }
            elseif ($ratingVal<0) {
                $this->down++;
            }

            $this->score+=$ratingVal;
        }

    }

    public function getUp(): int
    {
        return $this->up;
    }

    public function setUp(int $up): void
    {
        $this->up = $up;
    }

    public function getDown(): int
    {
        return $this->down;
    }

    public function setDown(int $down): void
    {
        $this->down = $down;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getCurUserVote(): int
    {
        return $this->curUserVote;
    }


}