<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
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
}