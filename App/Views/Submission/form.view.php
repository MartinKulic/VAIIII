<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
?>
<!-- Bootstrap Autocomplete Plugin -->
<script src="/path/to/dist/js/bootstrap-autocomplete.js"></script>
<form method="post" action="<?= $link->url('post.save') ?>" enctype="multipart/form-data">

    <label for="imageInput">Image:</label>
    <div class="form-group">
        <input name="image" type="file" class="form-control-file" id="imageInput" required>
    </div>

    <div class="form-grupe mt-3">
        <label for="titleInput">Title:</label>
        <input name="name" class="form-control form-control-lg" id="titleInput" aria-describedby="emailHelp" placeholder="Title" required>
        <small id="emailHelp" class="form-text text-muted">What is the title of image</small>
    </div>

    <div class="input-grupe mt-3">
        <label for="descInput">Description:</label>
        <textarea name="desc" class="form-control" id="descInput" placeholder="Description of image"></textarea>
        <small id="emailHelp" class="form-text text-muted">Description of image</small>
    </div>

    <div class="input-grupe mt-3">
        <label for="tagInput">Tagy</label>
        <textarea name="tag" class="form-control" id="tagInput">emply</textarea>
        <small id="emailHelp" class="form-text text-muted">Tags for image</small>
    </div>


    <div class="row mt-4 flex-row-reverse">
        <div class="col-4 text-end">
            <div class="row">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
