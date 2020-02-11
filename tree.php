<?php

require_once 'app-start.php';

function printDirItemsList($dirName, $dirPath)
{

    $dir = opendir($dirPath);
    echo '
        <div class="folder">
            <div class="tree__item-view folder__name">' . $dirName . '</div>
            <div class="folder__items">';


    while (($dirItemName = readdir($dir)) !== false):
        if ($dirItemName == '.' || $dirItemName == '..' || $dirItemName == '.htaccess') {
            continue;
        }
        if (is_dir($dirPath . '/' . $dirItemName)):
            printDirItemsList($dirItemName, $dirPath . '/' . $dirItemName);
        elseif (is_file($dirPath . '/' . $dirItemName)): ?>
            <a href="<?= './viewer.php?'. 'path=' . $dirPath . '/' . $dirItemName ?>"
               class="tree__item-view file" target="_blank"><?= $dirItemName ?></a>
        <? endif;
    endwhile;
    echo '    </div>
            </div>';
    closedir($dir);
} ?>




<?php //require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <h3>Файлы системы</h3>
    <div class="tree">
        <?

        $root = opendir('root');

        while (($dirItemName = readdir($root)) !== false) {


            if ($dirItemName == '.' || $dirItemName == '..' || $dirItemName == '.htaccess') {
                continue;
            }
            if (is_dir('./root/' . $dirItemName)):
                printDirItemsList($dirItemName, './root/' . $dirItemName);
            elseif (is_file('./root/' . $dirItemName)): ?>
                <a href="<?= './viewer.php?path=' . './root/' . $dirItemName ?>"
                   class="tree__item-view file" target="_blank"><?= $dirItemName ?></a>
            <? endif;
        }
        ?>
    </div>
</div>
<script>
    document.querySelectorAll('.folder__name').forEach(function (value, key, parent) {
        value.addEventListener('click', function (e) {
            value.parentElement.classList.toggle('expanded');
        });
    });
</script>

<form method="post" enctype="multipart/form-data" action="">
    <h3>Загрузить файл</h3>
    <div><label for="dir-name">Каталог на сервере</label></div>
    <div><input type="text" name="dir-name" id="dir-name" value="/" pattern="^/.*"></div>

    <div><label for="myfilename">Локальный файл</label></div>
    <div><input type="file" name="myfilename"></div>

    <div><input type="submit" value="Отправить файл на сервер"></div>
</form>
<?php

//require SITE_ROOT . 'master-page/Footer/footer.php' ?>

