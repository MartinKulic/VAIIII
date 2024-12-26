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
use finfo;
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
        if($imgID > 0) {
            $this->currentSubmission = new Submission($imgID, $this->app->getAuth()->getLoggedUserId());
        }
//        else{
//            $this->currentSubmission = null;
//        }

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
        return $this->html();
    }
    public function save(): Response
    {
        $notSaved = true;

        if (is_null($this->currentSubmission)) {
            $image = new Image();
            $image->setId(0);
            $image->setPath($this->request()->getFiles()["image"]['tmp_name']);
            $this->currentSubmission = new Submission(NULL,NULL);
            $this->currentSubmission->setImage($image);
        } else {
            $image = $this->currentSubmission->getImage();
            $notSaved = false;
        }
        $image->setName($this->request()->getValue("name"));
        $image->setDesc($this->request()->getValue("desc"));
        $image->setAutorId($this->app->getAuth()->getLoggedUserId());

        $validation = $this->validate($image, $this->request()->getFiles()["image"]);
        if(!is_null($validation)) {
            return $this->html([
                    "submission"=>$this->currentSubmission,
                    "error"=>$validation
                ], $notSaved ? "add" : "edit");
        }

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
            // TODO: Refaktor if Hell

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

    private function validate($image, $ingFile) {
        if($image->getName() == ""){
            return "Title is required";
        }
        if (strlen($image->getName()) > 100) {
            return "Max lenght of Title is 100 characters";
        }
        if (strlen($image->getDesc()) > 1000) {
            return "Max length of Description is 1000 characters";
        }
        if ($image->getId() == 0) {

            if (!isset($ingFile['tmp_name']) || $ingFile['tmp_name'] === "" || !is_uploaded_file($ingFile['tmp_name'])) {
                return "File upload failed. Please try again.";
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $type = $finfo->file($ingFile['tmp_name']);
            $allowedTypes = array(
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/bmp',
                'image/tiff',
                'image/vnd.microsoft.icon',
            );

            if ($ingFile["name"] != "" && !in_array($type, $allowedTypes)) {
                return "Not supported image type. Supported types are jpeg, png, gif, bmp, tiff, icon.";
            }

            $size = $ingFile['size'];
            if ($size > 3 * 1024 * 1024) {
                return "Image size is too large. Max allowed size is 3 MB";
            }
        }

        return null;
    }
}