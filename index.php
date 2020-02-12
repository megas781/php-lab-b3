<?php

session_start();

require_once 'app-start.php';
require_once 'upload_file_utils.php';
require_once 'user_utils.php';

$authUser = null;

if (isset($_GET['logout']) && isset($_SESSION['authUserName']) && $_GET['logout'] == $_SESSION['authUserName']) {
    unset($_SESSION['authUserName']);
    header('Location: /php-lab-b3/index.php');
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


//Загрузка файла. Относится к модулю tree, но да пофиг. Проверка, не хочет ли загрузиться какой-нибудь файл
//всё упирается в проверку наличия пути к папке загрузки
//echo '<pre>';
//var_dump($_POST);
//var_dump($_FILES);
//echo '</pre>';
if (isset($_POST['dir-name'])) {
    $chosenUploadDirectory = './root/' . trim($_POST['dir-name'], ' /');

    //ПРОВЕРКА ВАЛИДНОСТИ ПУТИ
    //если в пути присутствует "..", то не рассматриваем такой путь, или идет указание
    if (is_numeric(strpos($chosenUploadDirectory, '..'))) {
//        можно вывести ошибку, что не принимаются пути с двойными точками
        echo '$chosenUploadDirectory may be dangerous: ' . $chosenUploadDirectory;
    } else {
        if (isset($_FILES['myfilename'])) {


            //проверка на массивность. Если tmp_name является строкой, то никакие файлы не загружены, и нужно просто удалить указанную папку
            if (is_array($_FILES['myfilename']['tmp_name'])) {

                if (sizeof($_FILES['myfilename']['tmp_name']) > 0 && $_FILES['myfilename']['tmp_name'][0]) {

                    for ($i = 0; $i < sizeof($_FILES['myfilename']['tmp_name']); $i++) {

                        $tmp_name = $_FILES['myfilename']['tmp_name'][$i];
                        $name = $_FILES['myfilename']['name'][$i];

                        $uploadPath = getNamePathForNewFileInDirectory($chosenUploadDirectory, $name);
                        if (moveFileSafely($tmp_name, $uploadPath)) {
                            //Добавляем информацию о том, что данный файл принадлежит данному пользователю
                            addFileToUser($authUser['name'], $uploadPath);
                        }

                    }
                } else {
                    //удаляем каталог со всеми файлами
                    if ($chosenUploadDirectory !== './root/') {
                        if (isset($authUser) && isset($authUser['name'])) {
                            removeDirectory($chosenUploadDirectory, $authUser['name']);
                        }
                    }
                }
//                echo 'some useful action performed';

            } else {
//                echo 'удялем бля?: ' . $chosenUploadDirectory;
                //удаляем каталог со всеми файлами
                if ($chosenUploadDirectory !== './root/') {
                    removeDirectory($chosenUploadDirectory);
                }
            }

            header('Location: ./index.php');

        } else {
            echo 'error 228';
        }
    }

} else {
//    echo 'post[dir-name] is not set';
//    print_r($_POST);
}


?>
<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <? if (isset($authUser)): ?>
        <h4>Добро пожаловать, <?= $authUser['name'] ?>!</h4>
        <? include 'tree.php' ?>
    <? else: ?>
        <h3>Вход в систему</h3>
        <form action="" method="post">
            <div><label for="login"></label></div>
            <div><input type="text" id="login" name="login"></div>
            <div><label for="password"></label></div>
            <div><input type="password" id="password" name="password"></div>
            <div><input type="submit" value="Войти"></div>
        </form>
    <? endif; ?>
</div>
<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

