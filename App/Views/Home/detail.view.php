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

        <main class="col-xl-10 col-lg-9 col-12 m-xl-0 m-lg-0 m-5 order-lg-2 order-1">

            <div class="mainImage flex-fill">

                <div class="align-items-center flex-fill mt-2">
                    <img class="col-12" alt="Hlavny obrazok" src="<?= $submission->getImage()->getPath() ?>">
                </div>
                <div class="row mt-3">

                    <div class="col">
                        <button class="btn btn-outline-success"><i class="bi-hand-thumbs-up-fill fs-3 green"></i></button>
                        <button class="btn btn-outline-danger mx-2"><i class="bi-hand-thumbs-down fs-3 red"></i></button>
                        <button class="btn btn-outline-warning"><i class="bi-star-fill fs-3"></i></button>
                    </div>
                    <div class="row mt-3">
                        <div class="col p-3 bg-body-secondary">
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
            </div>

        </main>


    </div>
</div>
