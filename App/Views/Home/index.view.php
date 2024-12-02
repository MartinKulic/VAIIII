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
        <aside class="col-xl-2 col-lg-3 order-lg-1 order-3 p-2 sideBar">
            <div class="input-group mb-2 align-self-center">
          <span class="input-group-text">
            <i class = "bi-search"></i>
          </span>
                <textarea class="form-control" aria-label="With textarea">Pes Mačka Sample Unfunny</textarea>
            </div>
            <!-- Aktivne vo filtry -->
            <div class="row">
                <h3 class="col align-items-start">Aktývny Filter</h3>
                <button class="col-4 me-3 btn-danger align-items-end">Zruš filter</button>
            </div>

            <ul class="mt-2 p-2 zoznamTags container-fluid justify-content-center">
                <li class="tagRow mt-1 p-1 wighterBackground">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus tagDisabled"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Pes</a>
                </li>
                <li class="tagRow mt-1 p-1 wighterBackground">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus tagDisabled"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Mačka</a>
                </li>
                <li class="tagRow mt-1 p-1 wighterBackground">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus tagDisabled"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Sample</a>
                </li>
                <li class="tagRow mt-1 p-1 wighterBackground">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus tagDisabled"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Unfunny</a>
                </li>
            </ul>
            <!-- Tiez sa vyskytujuce Tagy -->
            <hr class="hr">
            <h3>Tiež sa vyskytujúce</h3>
            <ul class="mt-2 p-2 zoznamTags wighterBackground justify-content-center">
                <li class="tagRow mb-1">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus green"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Žmurkanie</a>
                </li>
                <li class="tagRow mb-1">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus green"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Ospalosť</a>
                </li>
                <li class="tagRow mb-1">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus green"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Smutlý</a>
                </li>
                <li class="tagRow mb-1">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus green"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Štastný</a>
                </li>
                <li class="tagRow mb-1">
                    <a href="#" class="me-2 tagInfo"><i class="bi-info-square"></i></a>
                    <a href="#"><i class="bi-clipboard-plus green"></i></a>
                    <a href="#"><i class="bi-clipboard-minus red"></i></a>
                    <a href="#" class="ms-2">Podozieravy</a>
                </li>

            </ul>
        </aside>

        <!-- Galeria obrazkov -->
        <main class="col-xl-10 col-lg-9 col-12 order-lg-2 order-1">
            <hr class="hr">
            <div class="mainGallery m-lg-3 m-sm-0">
                <?php foreach ($images as $image) { ?>
                    <div class="container">
                        <div class="d-fled flex-column">
                            <a href=""><img src="<?=$image->getPath()?>"></a>
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


