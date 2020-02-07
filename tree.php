<?php

require_once 'app-start.php';


?>

<?php //require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <h3>Файлы системы</h3>
    <div class="tree">

        <div class=" folder">
            <div class="tree__item-view folder__name">folder_1</div>
            <div class="folder__items">
                <a href="" class="tree__item-view file">file1.html</a>
                <a href="" class="tree__item-view file">file2.html</a>
                <a href="" class="tree__item-view file">file3.html</a>
                <div class="folder">
                    <div class="tree__item-view folder__name">folder_1</div>
                    <div class="folder__items">
                        <a href="" class="tree__item-view file">file1.html</a>
                        <a href="" class="tree__item-view file">file2.html</a>
                        <a href="" class="tree__item-view file">file3.html</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="" class="tree__item-view file">file1.html</a>
        <a href="" class="tree__item-view file">file2.html</a>
        <a href="" class="tree__item-view file">file3.html</a>
    </div>
</div>

<script>
    document.querySelectorAll('.folder__name').forEach(function (value, key, parent) {
        value.addEventListener('click', function (e) {
            value.parentElement.classList.toggle('expanded');
        });
    });
</script>
<?php //require SITE_ROOT . 'master-page/Footer/footer.php' ?>

