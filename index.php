<?php require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php' ?>
<?php $pageTitle = 'Gathering - Главная' ?>
<?php require_once TEMPLATES.'/header.php' ?>

<section class="welcome">
    <h1 class="welcome__heading">Gathering</h1>
    <p class="welcome__description">Простой чат для всех желающих</p>
    <a href="<?=PAGES.'/register.php'?>" class="welcome__button welcome__button--register">Регистрация</a>
    <a href="<?=PAGES.'/login.php'?>" class="welcome__button welcome__button--login">Войти</a>
</section>

<?php require_once TEMPLATES.'/footer.php' ?>
