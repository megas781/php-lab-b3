<?php

require_once 'app-start.php';


?>

<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>
<div class="column _flex-centering">
    <h3>Вход в систему</h3>
    <form action="" method="post">
        <div><label for="login"></label></div>
        <div><input type="text" id="login" name="login"></div>
        <div><label for="password"></label></div>
        <div><input type="password" id="password" name="password"></div>
        <div><input type="submit" value="Войти"></div>
    </form>
</div>
<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

