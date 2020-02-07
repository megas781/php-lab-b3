<?php

require_once 'app-start.php';

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
    <? if ($authUser): ?>
        <h4>Добро пожаловать, <?= $authUser['name'] ?>!</h4>
        <a href="./index.php" style="display: block; padding: 8px;">К списку файлов</a>
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
    <? else:
        header('Location: /index.php');
    endif; ?>
</div>
<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

