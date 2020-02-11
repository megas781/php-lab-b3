<?
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
// (должно начинаться с 'root/...')
function getNamePathForNewFileInDirectory($dirPath, $uploadFileName)
{
    $dirPath = trim($dirPath, ' /');


    //если каталога не существует...
    if (!file_exists($dirPath)) {
        //...то создаем каталог
        umask(0); // сбрасываем значение umask
        mkdir($dirPath, 0777, true); // создаем ее
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

    return ($dirPath . '/' . $n . ($ext?'.':'') . $ext); // возвращаем свободное имя
}
//передвижение файла
function moveFileToDirectorySafely($filePath, $uploadDirectory, $uploadFileName)
{
    //если файла не существует, то удаляем директорию

    if (is_dir($uploadDirectory)) {
        if (is_file($filePath)) {

            $newPath = getNamePathForNewFileInDirectory($uploadDirectory, $uploadFileName);

            move_uploaded_file($filePath, $newPath);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
