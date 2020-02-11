<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<pre>
    <?
    require_once 'upload_file_utils.php';

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

    var_dump(checkFileAccess('megas781', './root/index.asdf'));

    ?>

</body>
</html>
