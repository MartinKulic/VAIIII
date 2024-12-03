<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\Image;

/**
 * @inheritDoc
 * Controllers tarajuci sa o pridavie, pravovanie a dostranovanie prispavkov
 */
class SubmissionController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }
    public function add(): Response
    {
        return $this->html();
    }
    public function save(): Response
    {
        $id = $this->request()->getValue("sub_id");
        $oldName = "";


        if ($id > 0) {
            $image = Image::getOne($id);
            $oldName = $image->getPath();
        } else {
            $image = new Image();
            //$image->setAuthor($autor);
        }
        $image->setName($this->request()->getValue("name"));
        $image->setDesc($this->request()->getValue("desc"));
        $image->setAutorId($this->app->getAuth()->getLoggedUserId());

        if ($oldName != "") {
            FileStorage::deleteFile($oldName);
        }
        $newName = FileStorage::saveFile($this->request()->getFiles()["image"]);
        $image->setPath($newName);
        $image->save();

        return $this->redirect($this->url("home.index"));
    }
}