<?
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


//    Достать пользователя как массив
function getUserData($user_name)
{
    $array = file('users.csv');

    $user = null;

    foreach ($array as $fileLine) {
        $lineComponents = explode(';', trim($fileLine));
        if ($lineComponents[0] == $user_name) {
            $user = $lineComponents;
        }
    }
    return $user;
}

//    Достать пользователя как строку
function getUserLine($user_name)
{
    $array = file('users.csv');



    foreach ($array as $fileLine) {
        $lineComponents = explode(';', trim($fileLine));
        if ($lineComponents[0] == $user_name) {
            return trim($fileLine);
        }
    }
    return null;
}

function checkFileAccess($user_name, $filename): bool
{
    $user = getUserData($user_name);

    if (is_array($user)) {
        for ($i = 2; $i < sizeof($user); $i++) {
            if ($user[$i] == $filename) {
                return true;
            }
        }
    }
    return false;
}

function addFileToUser($user_name, $filePath)
{
    $userLine = getUserLine($user_name);
    $fileText = file_get_contents('users.csv');

//        var_dump(strpos($fileText, $userLine . "\n"));

    if ( !in_array($filePath, explode(';', $userLine)) ) {
        $fileText = str_replace($userLine . "\n", $userLine . ';' . $filePath . "\n", $fileText);
    } else {
        echo 'already in the array';
    }



    $f = fopen('users.csv', 'w');
    flock($f, LOCK_EX);
    fwrite($f, $fileText);
    flock($f, LOCK_UN);
    fclose($f);
}
