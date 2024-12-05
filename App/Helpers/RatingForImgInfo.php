<?php

namespace App\Helpers;

use App\Models\Rating;
use JsonSerializable;
use stdClass;

// poc hodnoteni pozitivne nedativne, hodnotenie prihlaseneho uzivatela
class RatingForImgInfo implements JsonSerializable
{
    protected $up=0;
    protected $down =0;
    protected $score=0;
    protected $curUserVote=0;
    protected $curUserRateId = null; // Rate ktory je aktivny

    public function __construct($imgId, $userID)
    {
        $ratings = Rating::getAll("`image_id` = ?",[$imgId]);

        foreach ($ratings as $rating) {
            $ratingVal = $rating->getValue();
            if ($rating->getUserId() == $userID) {
                $this->curUserVote = $ratingVal;
                $this->curUserRateId = $rating->getId();
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

    public function chngeUp($delta){
        $this->up += $delta;
    }
    public function chngeDown($delta){
        $this->down += $delta;
    }
    public function chngeScore($delta, $prevUserVote=null){
        $prevUserVote = (!is_null($prevUserVote)) ?: $this->curUserVote;
        $this->score += -$prevUserVote +$delta;
    }

    public function setCurUserVote(int $curUserVote): void
    {
        $this->curUserVote = $curUserVote;
    }

    public function setCurUserRateId(?int $curUserRateId): void
    {
        $this->curUserRateId = $curUserRateId;
    }

    public function deleteRateMem()
    {
        $this->score += -$this->curUserVote;
        $this->curUserVote = 0;
        $this->curUserRateId = null;
    }
    public function getCurUserRate(){
        return Rating::getOne($this->curUserRateId);
    }
    public function getCurUserRateId(): ?int
    {
        return $this->curUserRateId;
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


    public function jsonSerialize() : mixed
    {
        return [
            'up' => $this->up,
            'down' => $this->down,
            'score' => $this->score,
            'curUserVote' => $this->curUserVote,
        ];
    }
}