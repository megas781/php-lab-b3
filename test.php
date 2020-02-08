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

//mkdir('root/my/new/dir', 0777, true);


//Удалить директорию ($dir должен начинаться с 'root/...')
function removeDirectory(string $dir): bool
{

    if (!is_dir($dir)) {
        return false;
    }

    if ($objs = glob(trim($dir, ' /') . '/*')) {
        print_r($objs);
        foreach ($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
    return true;
}

//removeDirectory('root/dir_to_delete');


//function moveFileToUploadDirectory($filePath, $uploadDirectory)
//{
//    //если файла не существует, то удаляем директорию
//    if (!is_file($filePath)) {
//
//    } else {
//
//        //если каталога не существует, то создаем его
//        if (!is_dir($uploadDirectory)) {
//            mkdir($uploadDirectory, 0777, true);
//        }
//        move_uploaded_file($filePath, $uploadDirectory);
//    }
//}


//moveFileToUploadDirectory('root/my_file.html', 'root/my/new/dir');

// (должно начинаться с 'root/...')
function getNameForNewFileInDirectory($dirPath, $tmpFilePath)
{
    $dirPath = trim($dirPath, ' /');
    $tmpFilePath = trim($tmpFilePath, ' ');

     //если каталога не существует...
    if (!file_exists($dirPath)) {
        //...то создаем каталог
        umask(0); // сбрасываем значение umask
        mkdir($dirPath, 0777, true); // создаем ее
    }

    //Определяем расширение файла
//    $ext = end(explode('.', $tmpFileName));

    $tmpFileName = end(explode('/', $tmpFilePath));

    //Если имя делится на несколько частей по знаку '.'
    if (sizeof(explode('.', $tmpFileName)) > 1) {
        //То мы можем достать расширение
        $ext = end(explode('.', $tmpFileName));
    } else {
        //Если у файла нет расширения, то оно равно пустой строке
        $ext = '';
    }

    // начиная с 1 цикл пока существует файл
    $n = 1;
    //Находим число для имени файла
    $dirItemsList = scandir($dirPath);
    array_shift($dirItemsList);
    array_shift($dirItemsList);
    print_r($dirItemsList);
    foreach ($dirItemsList as $dirItem) {
        if (is_file($dirPath . '/' . $dirItem)) {
            $itemNameComponents = explode('.', $dirItem);

            $comparableName = $itemNameComponents[0];

            if ($comparableName == $n) {
                //Если файл с таким именем уже есть, то прибавляем 1
                $n++;
            }
        }
    }

//    echo '$dirPath: ' . $dirPath . ';';
    return ($dirPath . '/' . $n . ($ext?'.':'') . $ext); // возвращаем свободное имя
}
var_dump(getNameForNewFileInDirectory('root/sub_directory1', 'some/temp/dir/upload.ed/file.html'));




?>


</body>
</html>
