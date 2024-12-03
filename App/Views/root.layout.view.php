<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <meta charset="UTF-8">
    <meta lang="sk">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/mainStyle.css">
    <script src="public/js/script.js"></script>
</head>
<body  class="bg-body" data-bs-theme="dark">
<header>
    <nav class="navbar navbar-expand-lg bg-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?=$link->url("home.index")?>">
                <img src="public/images/Logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($auth->isLogged()) { ?>
                    <li class="nav-item">
                        <a class="btn btn btn-outline-info" href="<?= $link->url("submission.add") ?>"><i class="bi bi-arrow-bar-up"></i> Nahrať</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Nedávne</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Najlepšie za
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item disabled" href="#">Deň</a></li>
                            <li><a class="dropdown-item disabled" href="#">Týždeň</a></li>
                            <li><a class="dropdown-item disabled" href="#">Mesiac</a></li>
                            <li><a class="dropdown-item disabled" href="#">Rok</a></li>
                        </ul>
                    </li>
                </ul>

                <span class="d-flex">
                    <?php if ($auth->isLogged()) { ?>
                        <a href="<?= $link->url("auth.logout") ?>" class="btn btn-outline-light me-3">Log out</a>
                    <?php } else { ?>
                        <a href="<?= \App\Config\Configuration::LOGIN_URL ?>" class="btn btn-outline-primary me-3">Log in</a>
                        <a href="<?= \App\Config\Configuration::LOGIN_URL ?>" class="btn btn-primary">Register</a>
                    <?php } ?>
          </span>
            </div>
        </div>
    </nav>
</header>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>

<hr class="hr">
<footer class="py-3 py-md-5 mt-5 bg-body-tertiary">
    <div class="container py-3 px-4 text-body-secondary">
        <div class="row">
            <div class="col-lg-4">
                <a class="d-inline-flex align-items-center mb-2 text-decoration-none text-body-emphasis">
                    <img alt="Logo" src="public/images/Logo.png" height="32">
                    <span class="fs-5 ms-2">MeMeMark</span>
                </a>
                <p>MeMeMark je stránka umožňujúca nahrať, organizovať a následe vyhľadať meme na základe pridelených tagov.</p>
            </div>
            <div class="col-5 col-lg-4">
                <p>
                    Lorem ipsum odor amet, consectetuer adipiscing elit. Turpis natoque facilisi vulputate potenti habitant dictum neque amet metus. Orci non et risus pulvinar molestie nibh. Velit facilisis lacinia accumsan aenean posuere class amet sagittis. Ultrices platea libero inceptos; venenatis facilisis vehicula netus. Rutrum nullam ad accumsan nostra ultrices; non praesent. Tempor justo iaculis gravida facilisis porttitor scelerisque euismod per.
                </p>
            </div>
            <div class="col- col-lg-4">
                <a href=" <?= $link->url("framework.index") ?>" class="d-inline-flex align-items-center mb-2 text-decoration-none text-body-emphasis">
                    <img alt="Logo" src="public/images/vaiicko_logo.png" height="32">
                    <span class="fs-5 ms-2">Vaiicko</span>
                </a>
                <p>je framework, ktorym je projekt tvoreny</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
