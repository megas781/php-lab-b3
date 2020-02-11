<?php

session_start();

require_once 'app-start.php';
require_once 'upload_file_utils.php';


$authUser = null;

if (isset($_GET['logout']) && isset($_SESSION['authUserName']) && $_GET['logout'] == $_SESSION['authUserName']) {
    unset($_SESSION['authUserName']);
    header('Location: /php-lab-b3/index.php');
    exit();
}

function authenticate(string $login, string $password)
{
    $f = fopen('users.csv', 'rt');
    while (!feof($f)) {

        $str = fgets($f);
        $test_user = explode(';', $str);

//        Проверяем логин
        if (trim($test_user[0]) == $login) {
//            Проверяем пароль
            if (trim($test_user[1]) == $password) {
                //Опача, успешный вход. Сохраняем в сессии
                $_SESSION['authUserName'] = $_POST['login'];
                fclose($f);
                //Возвращаем объект пользователя. Пока одно поле, да.
                return [
                        'name' => $test_user[0]
                ];
            }
        }
    }
    fclose($f);
    return null;
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
if (isset($_POST['dir-name'])) {
    $chosenUploadDirectory = './root/' . trim($_POST['dir-name'], ' /');


    //ПРОВЕРКА ВАЛИДНОСТИ ПУТИ
    //если в пути присутствует "..", то не рассматриваем такой путь, или идет указание
    if (is_numeric(strpos($chosenUploadDirectory, '..'))) {
//        можно вывести ошибку, что не принимаются пути с двойными точками
        echo '$chosenUploadDirectory may be dangerous: ' . $chosenUploadDirectory;
    } else {
        if (isset($_FILES['myfilename'])) {
            if (isset($_FILES['myfilename']['tmp_name'])) {
                //Проверяем наличие загруженного файла на серверной стороне
                if ($_FILES['myfilename']['tmp_name']) {
//                    echo 'asdf';
                    var_dump($chosenUploadDirectory);
                    var_dump(moveFileToDirectorySafely($_FILES['myfilename']['tmp_name'], $chosenUploadDirectory, $_FILES['myfilename']['name']));

                } else {
                    //удаляем каталог со всеми файлами
                    if ($chosenUploadDirectory !== './root/') {
                        removeDirectory($chosenUploadDirectory);
                    }
                }
                echo 'some useful action performed';
//                header('Location: ./index.php');
            } else {
                echo 'error 322';
            }
        } else {
            echo 'error 228';
        }
    }

} else {
    echo 'post[dir-name] is not set';
    print_r($_POST);
}


?>
<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <? if (isset($authUser)):?>
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

