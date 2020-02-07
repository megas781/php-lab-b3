<?php

require_once 'app-start.php';

session_start();

$authUser = null;

if (isset($_GET['logout']) && $_GET['logout'] == $_SESSION['authUserName']) {
    $_SESSION['authUserName'] = null;
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

                //Возвращаем объект пользователя. Пока одно поле, да.
                return [
                        'name' => $test_user[0]
                ];
            }
        }
    }
    return null;
}


//Решаем судьбу переменной authUser
if (isset($_SESSION['authUserName'])) {
    $authUser = ['name' => $_SESSION['authUserName']];
} elseif (isset($_POST['login']) && isset($_POST['password'])) {
    $authUser = authenticate($_POST['login'], $_POST['password']);
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

