<?php
/** @var Array $data */
/** @var \App\Models\Post $post */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */

use App\Helpers\Submission;
use App\Models\Image;

$submission = $data["submission"];
$rating = $submission->getRatingInfo();
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
                        <span id="voteUpCount" class="green"><?= $rating->getUp() ?></span>
                        <button id="voteUp" class=" btn btn-<?php if (!($rating->getCurUserVote() > 0) ){ ?><?="outline-"?><?php } ?>success "><i class="bi bi-hand-thumbs-up fs-3"></i></i></button>
                        <span id="scoreVal" class="mx-2 h4 align-middle"><?= $rating->getScore() ?></span>
                        <button id ="voteDown" class="btn btn-<?php if (!($rating->getCurUserVote() < 0) ){ echo "outline-"; } ?>danger "><i class="bi-hand-thumbs-down fs-3"></i></button>
                        <span id="voteDownCount" class="red"><?= $rating->getDown() ?></span>
                        <button class="btn btn-outline-warning mx-lg-5 mx-1"><i class="bi-star-fill fs-3"></i></button>
                    </div>
                    <!-- Edit button only if you are author -->
                    <?php if ($auth->isLogged() && $submission->getAutorID()==$auth->getLoggedUserId()) : ?>
                    <div class="d-flex align-items-stretch">
                        <a href="<?=$link->url("submission.edit", ["imgID"=>$submission->getImage()->getId()])?>" class="btn btn-primary d-flex align-items-center">
                            <span class="h5"> <i class="bi bi-pencil"></i> Edit </span></a>
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
<script src="/public/js/numberColour.js"></script>
<script src="/public/js/rating.js"></script>
<script>
    let scoreVal = document.getElementById("scoreVal")
    colour(scoreVal)
    let rat = new Rating()
</script>
