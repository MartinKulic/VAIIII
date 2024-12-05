<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Helpers\Submission;
use App\Models\Image;
use App\Core\Responses\JsonResponse;
use App\Models\Rating;
use http\Message;

/**
 * @inheritDoc
 * Controllers tarajuci sa o pridavie, pravovanie a dostranovanie prispavkov
 */
class SubmissionController extends AControllerBase
{
    private ?Submission $currentSubmission = null;
    public function authorize(string $action)
    {
        $imgID = (int) $this->request()->getValue("imgID");
        $this->currentSubmission = new Submission($imgID, $this->app->getAuth()->getLoggedUserId());

        if ($this->app->getAuth()->isLogged()){
            switch ($action) {
                case "delete":
                case "edit":
                    return $this->app->getAuth()->getLoggedUserId()==$this->currentSubmission->getAutorId();
                default:
                    return true;
            }

        }
        else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not Implemented");
    }
    public function add(): Response
    {
        return $this->html([
            "purpose"=>"add"
        ]);
    }
    public function save(): Response
    {
        $id = $this->request()->getValue("sub_id");
        $notSaved = true;


        if ($id > 0) {
            $image = Image::getOne($id);
            $notSaved = false;
        } else {
            $image = new Image();
        }
        $image->setName($this->request()->getValue("name"));
        $image->setDesc($this->request()->getValue("desc"));
        $image->setAutorId($this->app->getAuth()->getLoggedUserId());

        if($notSaved) {
            $newName = FileStorage::saveFile($this->request()->getFiles()["image"]);
            $image->setPath($newName);
        }
        $image->save();

        return $this->redirect($this->url("home.index", [
            "messages"=>["Image operation successfully"],
        ]));
    }

    public function edit(): Response{

        if (is_null($this->currentSubmission)) {
            throw new HTTPException(405,"Submission not found");
        }
        return $this->html([
            "submission"=>$this->currentSubmission,
            "purpose"=>"edit"
        ]);
    }

    public function delete(): Response{

        if (is_null($this->currentSubmission)) {
            throw new HTTPException(405,"Submission not found");
        }

        $this->currentSubmission->delete();

        return $this->redirect($this->url("home.index", [
            "messages"=>["Submission deleted successfully"]
        ]));
    }

    public function rate(): Response{

        if(is_null($this->currentSubmission)){
            throw new HTTPException(405,"Submission not found");
        }

        $requestData = $this->request()->getRawBodyJSON();

        if (is_object($requestData) && property_exists($requestData, 'voted') && !empty($requestData->voted))
        {
            $ratingInfo = $this->currentSubmission->getRatingInfo();
            $rating = $ratingInfo->getCurUserRate();

            $voteVal = (int) $requestData->voted;
            if($voteVal == 0){
                throw new HTTPException(405,"Invalid vote value");
            }

            // Ratin este neexistuje
            if (is_null($rating)) {
                $rating = new Rating();
                $rating->setImageId($this->currentSubmission->getImageId());
                $rating->setUserId($this->app->getAuth()->getLoggedUserId());
                $rating->setValue($voteVal);

                $ratingInfo->setScore($ratingInfo->getScore() + $voteVal);

                if($voteVal > 0){
                    $ratingInfo->setUp($ratingInfo->getUp()+1);
                }
                else if($voteVal < 0){
                    $ratingInfo->setDown($ratingInfo->getDown()+1);
                }
                $rating->save();
                $ratingInfo->setCurUserRateId($rating->getId());
            }

            // Rating uz existoval
            //Bol UP votnuty
            else if($ratingInfo->getCurUserVote() > 0){
                // zas upvote = zmaz
                if ($voteVal > 0) {
                    $rating->delete();
                    $ratingInfo->chngeUp(-1);
                    $ratingInfo->deleteRateMem();
                    $voteVal = 0;
                }
                // downvote
                else if($voteVal < 0){
                    $ratingInfo->chngeUp(-1);
                    $ratingInfo->chngeDown(1);
                    $ratingInfo->chngeScore($voteVal);

                    $rating->setValue($voteVal);
                    $rating->save();

                }

            }
            //Bol DOWN votnuty
            else if ($ratingInfo->getCurUserVote() < 0){
                // zas downvote = zmaz
                if ($voteVal < 0) {
                    $rating->delete();
                    $ratingInfo->chngeDown(-1);
                    $ratingInfo->deleteRateMem();
                    $voteVal = 0;
                }
                // upvote
                else if($voteVal > 0){
                    $ratingInfo->chngeUp(1);
                    $ratingInfo->chngeDown(-1);
                    $ratingInfo->chngeScore($voteVal);

                    $rating->setValue($voteVal);
                    $rating->save();
                }
            }
            $ratingInfo->setCurUserVote($voteVal);

            // Not implemented yet. for now just sent back what you recieve

            return $this->json($ratingInfo);
        }
        else{
            throw new HTTPException(405,"Invalid request body");
        }
    }
}