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
        if ($dirItemName == '.' || $dirItemName == '..') {
            continue;
        }
        if (is_dir($dirPath . '/' . $dirItemName)):
            printDirItemsList($dirItemName, $dirPath . '/' . $dirItemName);
        elseif (is_file($dirPath . '/' . $dirItemName)): ?>
            <a href="" class="tree__item-view file"><?= $dirItemName ?></a>
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


            if ($dirItemName == '.' || $dirItemName == '..') {
                continue;
            }
            if (is_dir('./root/' . $dirItemName)):
                printDirItemsList($dirItemName, './root/' . $dirItemName);
            elseif (is_file('./root/' . $dirItemName)): ?>
                <a href="" class="tree__item-view file"><?= $dirItemName ?></a>
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
<?php


//require SITE_ROOT . 'master-page/Footer/footer.php' ?>

