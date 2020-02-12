<?php

require_once 'app-start.php';
require_once 'user_utils.php';

session_start();

$authUser = null;

if (isset($_GET['logout']) && isset($_SESSION['authUserName']) && $_GET['logout'] == $_SESSION['authUserName']) {
    unset($_SESSION['authUserName']);
    header('Location: /php-lab-b3/');
    exit();
}

//Решаем судьбу переменной authUser
if (isset($_SESSION['authUserName'])) {
    $authUser = ['name' => $_SESSION['authUserName']];
} elseif (isset($_POST['login']) && isset($_POST['password'])) {
    $authUser = authenticate($_POST['login'], $_POST['password']);

    //Строка ниже создана, чтобы после входа при обновлении страницы браузер не спрашивал о повторении отправки формы
    header('Location: ./');
    exit();
} else {
    $authUser = null;
}

?>

<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>

<div class="column _flex-centering">

    <?php
    if (!$_GET['path']) {
        ?><h4>Путь к файлу не передан</h4><?
        goto footerEnd;
    };

    if (!file_exists($_GET['path'])) {
        ?><h4>Файл <?=$_GET['path']?> не найден</h4><?
        goto footerEnd;
    }
    if (!getOwnerOfFile($_GET['path'])) {
        $unowned = true;
        ?><h4>Файл не имеет владельца. Открытый доступ</h4><?
    } else {
        $unowned = false;
    }
    ?>

    <?if ($authUser): ?>
        <h4>Добро пожаловать, <?= $authUser['name'] ?>!</h4>
        <a href="./index.php" style="display: block; padding: 8px;">К списку файлов</a>

    <? if (checkFileAccess($authUser['name'], $_GET['path']) || $unowned): ?>
        <!--        выбираем viewer текстовый или изображение -->
        <?
        $filename = explode('/', $_GET['path'])[array_key_last(explode('/', $_GET['path']))];
        $ext = explode('.', $filename)[array_key_last(explode('.', $filename))];
        echo '<p>Файл: ' . $filename . '</p>';
        if ($ext === 'jpg' ||
            $ext === 'jpeg' ||
            $ext === 'png' ||
            $ext === 'svg' ||
            $ext === 'gif'): ?>
            <img class="image-viewer" src="<?= $_GET['path'] ?>" alt="<?= $_GET['path'] ?>">
            <style>
                .image-viewer {
                    min-width: 320px;
                    min-height: 140px;

                    max-width: 1024px;
                    max-height: 350px;

                    display: block;
                    object-fit: contain;
                }
            </style>
        <? else: ?>
            <div class="file-view">
<pre>
<?
$f = fopen($_GET['path'], 'rt');
while (($line = fgets($f)) !== false) {
    echo htmlspecialchars($line);
}
?>
</pre>
            </div>
        <? endif; //end of check if file is an image ?>
    <? else: //else if user doesn't have access to the file ?>
    <h4>Пользователь <?=$authUser['name']?> не имеет доступ к файлу <?= $_GET['path'] ?></h4>
    <? endif; //end of if where user doesn't have access to the file ?>
    <? else: //not authed user?>
    <h4>Войдите в свою учетную запись, чтобы воспользоваться ресурсом</h4>
        <a href="./index.php">Войти</a>
    <? endif; //end if not authed user ?>



</div>
<?php footerEnd: ?>
<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

