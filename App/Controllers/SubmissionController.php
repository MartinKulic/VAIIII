<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Helpers\Submission;
use App\Models\Image;
use App\Core\Responses\JsonResponse;
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
        // TODO: Implement index() method.
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
        $id = (int) $this->request()->getValue("imgID");
        $submission = new Submission($id);

        if (is_null($submission)) {
            throw new HTTPException(405,"Submission not found");
        }
        return $this->html([
            "submission"=>$submission,
            "purpose"=>"edit"
        ]);
    }

    public function delete(): Response{
        $id = (int) $this->request()->getValue("imgID");
        $submission = new Submission($id);

        if (is_null($submission)) {
            throw new HTTPException(405,"Submission not found");
        }

        $submission->delete();

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

            // Not implemented yet. for now just sent back what you recieve

            return $this->json($ratingInfo);
        }
        else{
            throw new HTTPException(405,"Invalid request body");
        }
    }
}