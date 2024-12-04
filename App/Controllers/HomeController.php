<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\Submission;
use App\Models\Image;

class HomeController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $messages = $this->request()->getValue("messages");
        return $this->html([
            "images" => Image::getAll(),
            "messages" => $messages
        ]);
    }

    public function detail(): Response{
        $subID = (int) $this->request()->getValue("subId");
        $submission = new Submission($subID,$this->app->getAuth()->getLoggedUserId());

        if(is_null($submission)){
            throw new HTTPException(405, "Submission not found");
        }
        return $this->html([
            "submission" => $submission
        ]);
    }
}