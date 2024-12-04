<?php
/** @var Array $data */
/** @var \App\Models\Post $post */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */

use App\Helpers\Submission;
use App\Models\Image;

$submission = $data["submission"];
?>
<div class = container-fluid>
    <div class="row">
        <!-- Side pannel -->
        <?php require "sidePanel.view.php"?>

        <main class="col-xl-10 col-lg-9 col-12 m-xl-0 m-lg-0 m-0 order-lg-2 order-1">

            <div class="mainImage flex-fill">

                <div class="align-items-center flex-fill mt-2">
                    <img class="col-12" alt="Hlavny obrazok" src="<?= $submission->getImage()->getPath() ?>">
                </div>
                <div class="flex-row mt-3 d-flex justify-content-between">
                    <div class="col">
                        <button class="btn btn-outline-success"><i class="bi-hand-thumbs-up-fill fs-3 green"></i></button>
                        <span class="mx-2">123</span>
                        <button class="btn btn-outline-danger mx-2"><i class="bi-hand-thumbs-down fs-3 red"></i></button>
                        <button class="btn btn-outline-warning"><i class="bi-star-fill fs-3"></i></button>
                    </div>
                    <!-- Edit button only if you are author -->
                    <?php if ($auth->isLogged() && $submission->getAutorID()==$auth->getLoggedUserId()) : ?>
                    <div class="d-flex align-items-stretch">
                        <a href="<?=$link->url("submission.edit", ["imgID"=>$submission->getImage()->getId()])?>" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row mt-3">
                    <div class="col pt-0 pb-3 px-3 bg-body-secondary">
                        <div class="row d-inline">
                            <h5><?= $submission->getImage()->getName() ?></h5>
                            <p class="fs-6">By <?=  $submission->getAutorName() ?></p>
                        </div>
                        <p>
                            <?=  $submission->getImage()->getDesc() ?>
                        </p>
                    </div>
                </div>


            </div>

        </main>


    </div>
</div>
