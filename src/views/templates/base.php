<!doctype html>
<html lang="pt-BR">

<!-- HEAD -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleWeb ?? '' ?></title>



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= css_directory("/bs5.css") ?>">

    <!-- font awesome -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Loader CSS -->
    <link rel="stylesheet" href="<?= css_directory("/loader.css"); ?>">

    <!-- Notification CSS -->
    <link rel="stylesheet" href="<?= css_directory("/notification.css") ?>">

    <!-- Global CSS -->
    <link rel="stylesheet" href="<?= css_directory("/global.css") ?>">

    <!-- The code stretch below inserts the specific styles of each of the pages that inherit it as a layout -->
    <?php if (isset($styles)) { ?>
        <?php foreach ($styles as $index => $style) { ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php } ?>
    <?php } ?>
</head>
<!-- HEAD -->



<body class="<?= 'amsted' ?>">

    <!-- Content -->
    <div class="container mt-4">
        <ul class="notificationsToasts"></ul>
        <div class="card mb-4">
            <div class="card-header">
                <div class="screen-name-and-logo">

                    <?php if (!empty($url_back)) { ?>
                        <a href="<?= $url_back ?>" class="text-muted fs-6">
                            <p class="m-0 d-flex align-items-center"> <i class="ph ph-arrow-left me-2"></i> voltar</p>
                        </a>
                    <?php } ?>

                    <span class="d-flex align-items-center"><?= $title_in_card ?? null ?></span>
                    <img src="<?= images_directory('/' . 'vellum' . '.png'); ?>" alt="Logo Empresa">
                </div>
            </div>
            <div class="card-body">


                <?= $this->section("content"); ?>

            </div>
        </div>
    </div>



    <div class="loader-wrapper">
        <div class="loader"></div>
        <p>Aguarde um instante, estamos processando os dados...</p>
    </div>


    <!-- Bootstrap JS --->
    <script src="<?= js_directory("/bs5.js") ?>"></script>
    <!-- JavaScript that initializes variables and aid functions --->
    <script src="<?= js_directory("/init.js"); ?>"></script>
    <!-- Dyoxfy JS -->
    <script src="<?= js_directory("/notification.js"); ?>"></script>


    <?php viewingNotifications(); ?>
    <?php forgetSessions(['old', 'dyoxfy', 'isWrong']) ?>

    <!-- The code stretch below inserts the scripts of each of the pages that inherit this template as a layour -->
    <?php if (isset($js)) { ?>
        <?php foreach ($js as $index => $js_) { ?>
            <script src="<?= $js_ ?>"></script>
        <?php } ?>
    <?php } ?>
</body>



</html>