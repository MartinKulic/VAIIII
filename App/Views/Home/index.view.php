<?php
/** @var Array $data */
/** @var \App\Models\Post $post */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */

use App\Models\Image;

$images = $data["images"];
?>

<div class = container-fluid>
    <div class="row">
    <span class="pagesNavigator">
        <a href="#"><<</a>
        <a href="#"><</a>
        <a href="#" class="tagDisabled">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a>...</a>
        <a href="#">1654</a>
        <a href="#">></a>
        <a href="#">>></a>
      </span>
        <!-- Side pannel -->
        <?php require "sidePanel.view.php"?>

        <!-- Galeria obrazkov -->
        <main class="col-xl-10 col-lg-9 col-12 order-lg-2 order-1">
            <hr class="hr">
            <div class="mainGallery m-lg-3 m-sm-0">
                <?php foreach ($images as $image) { ?>
                    <div class="container">
                        <div class="d-fled flex-column">
                            <a href="<?= $link->url("home.detail", ["subId" => $image->getId()]) ?>"><img src="<?=$image->getPath()?>"></a>
                            <div class="scoreRow">
                                <span class="green">124 <i class="bi bi-caret-up"></i></span >
                                <span class="red"><i class="bi bi-caret-down"></i> 69</span >
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </main>


        <span class="pagesNavigator container-fluid order-2">
        <a href="#"><<</a>
        <a href="#"><</a>
        <a href="#" class="tagDisabled">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a>...</a>
        <a href="#">1654</a>
        <a href="#">></a>
        <a href="#">>></a>
      </span>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


