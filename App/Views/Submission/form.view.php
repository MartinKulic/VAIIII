<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

use App\Helpers\Submission;
use App\Models\Image;

$submission = @$data["submission"];
?>
<?php if (@$data["error"]) : ?>
    <div class="row justify-content-center">
        <div class="alert alert-danger" role="alert">
            <?= $data["error"] ?>
        </div>
    </div>
<?php endif;?>

<div class="row justify-content-center">
    <div class=" col-12 col-md-6 order-md-1 order-2">
        <form method="post" action="<?= $link->url('submission.save') ?>" enctype="multipart/form-data">
            <input type="hidden" name="imgID" value="<?= @$data['submission']?->getImageId() ?>">

            <?php if($data["purpose"] == "add"): ?>
                <label for="imageInput">Image:</label>
                <div class="form-group">
                    <input name="image" type="file" class="form-control-file" id="imageInput" accept=".jpg,.gif,.png" required>
                </div>
            <?php endif;?>

            <div class="form-grupe mt-3">
                <label for="titleInput">Title:</label>
                <input name="name" class="form-control form-control-lg" id="titleInput" aria-describedby="emailHelp" placeholder="Title"  autocomplete="off" required
                       value="<?= $submission?->getImage()->getName()  ?>">
                <small id="emailHelp" class="form-text text-muted">What is the title of image</small>
            </div>

            <div class="input-grupe mt-3">
                <label for="descInput">Description:</label>
                <textarea name="desc" class="form-control" id="descInput" placeholder="Description of image"><?= $submission?->getImage()->getDesc() ?></textarea>
                <small id="emailHelp" class="form-text text-muted">Description of image</small>
            </div>

            <div class="input-grupe mt-3">
                <label for="tagInput">Tagy</label>
                <textarea name="tag" class="form-control" id="tagInput"><?php
                    if (!is_null($submission)) :
                        foreach ($submission?->getImageTags() as $tag) :?><?=$tag?><?php endforeach; endif;?></textarea>
                <small id="emailHelp" class="form-text text-muted">Tags for image</small>
            </div>


            <div class="row mt-4 flex-row-reverse">
                <div class="col-4 text-end">
                    <div class="row">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <?php if($data["purpose"] == "edit"): ?>
                    <div class="col-4 text-end mx-4">
                        <div class="row">
                            <button id="delBut" type="button" class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div id="confirmButton" class="d-none">
                <div class="row mt-2 flex-row-reverse">
                    <div class="col-4"></div>
                    <div class="col-4 ext-end mx-4">
                        <div class="row">
                            <a class="btn btn-danger" href="<?= $link->url("submission.delete", ["imgID"=>$submission?->getImage()->getId()]) ?>">Really?</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    
    <div class="col-12 col-md-6 order-md-2 order-1 align-items-center align-self-center text-center">
        <img id="imagePreview" class="mw-100 mh-100" src="<?= $submission?->getImage()->getPath() ?>" alt="Image Preview">
    </div>

</div>

<?php if ($data["purpose"] == "edit"): ?>
<script>
    let confirmButton = document.getElementById("confirmButton")
    let delButton = document.getElementById("delBut")

    delButton.addEventListener("click", () => {
        confirmButton.classList=[]
    })
</script>
<?php elseif( $data["purpose"] == "add") : ?>

<script src="/public/js/showImgPreview.js"></script>

<?php endif;?>
