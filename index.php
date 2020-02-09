<?php

require_once 'app-start.php';

session_start();

$authUser = null;

if (isset($_GET['logout']) && isset($_SESSION['authUserName']) && $_GET['logout'] == $_SESSION['authUserName']) {
    unset($_SESSION['authUserName']);
    header('Location: /php-lab-b3/index.php');
    exit();
}

//Относится к модулю tree, но да пофиг. Проверка, не хочет ли загрузиться какой-нибудь файл
if (isset($_FILES['myfilename'])) {
    if (isset($_FILES['myfilename']['tmp_name'])) {
        //Проверяем наличие загруженного файла на серверной стороне
        if ($_FILES['myfilename']['tmp_name']) {

            //Если каталог, который указан в форме??
            $chosenUploadDirectory = './root/' . trim($_POST['dir-name'], ' /');

            if (is_dir($chosenUploadDirectory)) {
                scandir($chosenUploadDirectory);
                $k = 0;
                                move_uploaded_file($_FILES['myfilename']['tmp_name'], $chosenUploadDirectory . '/' . $k);
                header('Location: ./index.php');
            } else {
                //Если каталог не существует, мы его создадим
                mkdir($chosenUploadDirectory);

                header('Location: ./index.php');
            }
            exit();
        } else {
            //удаляем каталог со всеми файлами

        }
    }
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


?>
<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <? if ($authUser): ?>
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

