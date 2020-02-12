<?php
require_once 'user_utils.php';
//Удалить директорию ($dir должен начинаться с 'root/...')
function removeDirectory(string $dir, string $authedUser): bool
{
    if (!is_dir($dir)) {
        return false;
    }
    if ($objs = glob(trim($dir, ' /') . '/*')) {

        //если

        $hasPermissionToDelete = true;
        foreach ($objs as $obj) {
            if (is_dir($obj)) {
                removeDirectory($obj, $authedUser);
            } else {
                $hasPermissionToDelete = $hasPermissionToDelete && ($authedUser == getOwnerOfFile($obj));
            }
        }

        if ($hasPermissionToDelete) {
            foreach ($objs as $obj) {
                unlink($obj);
            }
            rmdir($dir);
            return true;
        } else {
            return false;
        }

    }
    return false;
}

// (должно начинаться с 'root/...')
function getNamePathForNewFileInDirectory($dirPath, $uploadFileName): string
{
    $dirPath = trim($dirPath, ' /');


    //если каталога не существует...
    if (!file_exists($dirPath)) {
        //...то создаем каталог
        umask(0); // сбрасываем значение umask
        mkdir($dirPath, 0777, true); // создаем ее
//        echo 'я создал!!';
    } else {
//        echo '$dirPath не удовлетворяет !file_exists: ' . $dirPath;
    }

    //Определяем расширение файла
    $uploadNameComponents = explode('.', $uploadFileName);
    //Если имя делится на несколько частей по знаку '.'
    if (sizeof($uploadNameComponents) > 1) {
        //То мы можем достать расширение
        $ext = end($uploadNameComponents);
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

    return ($dirPath . '/' . $n . ($ext ? '.' : '') . $ext); // возвращаем свободное имя
}

//передвижение файла
function moveFileSafely($filePath, $uploadPath)
{

    //если файла не существует, то удаляем директорию ($uploadDirectory обязана существовать, т.к. она создается в getNamePathForNewFileInDirectory);)
    if (is_dir(dirname($uploadPath))) {
        if (is_file($filePath)) {
            move_uploaded_file($filePath, $uploadPath);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getExtension($filePath): string
{
    //Определяем расширение файла

    $pathComponents = explode('/', $filePath);
    $fileName = end($pathComponents);

    $uploadNameComponents = explode('.', $fileName);
    //Если имя делится на несколько частей по знаку '.'
    if (sizeof($uploadNameComponents) > 1) {
        //То мы можем достать расширение
        $ext = end($uploadNameComponents);
    } else {
        //Если у файла нет расширения, то оно равно пустой строке
        $ext = '';
    }
    return ext;
}
