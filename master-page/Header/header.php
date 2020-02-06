<?php require_once SITE_ROOT . 'App.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Проверка знаний</title>

    <link rel="stylesheet" href="<?= HTTP_ROOT . 'styles/compose.css' ?>">
</head>
<body>

<!--copied from php-template-->

<header class="header js-header">
    <div class="brand">
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] ?>" class="header__brand-link">

            <img src=<?php echo HTTP_ROOT . 'assets/dark-theme_logo@middle.png' ?> alt=""
                 class="header__logo-image">

        </a>
        <!--            <h2 class="header__title"> Лабораторные работы по PHP ️</h2>-->
        <h2 class="header__title"> <?php echo 'PHP Лабораторная' ?></h2>
    </div>


    <!--    Здесь у нас выводятся кастомные элементы для отдельных страниц-->
    <!--    --><?php //echo App::$headerContent; ?>


</header>
<script>
    let headerPaddingDiv = document.createElement("div");
    headerPaddingDiv.style.height = getComputedStyle(document.querySelector(".js-header")).getPropertyValue('height');
    document.querySelector(".js-header").insertAdjacentElement("afterend", headerPaddingDiv);
</script>


<!--copied from php-template-->

<?php

?>
<main>
    <div class="_flex-centering">
        <div>
