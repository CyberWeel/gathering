<?php require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php' ?>
<?php
$pageTitle = 'Gathering - Главная';

if (isset($_GET['quit']) && $_GET['quit'] === 'yes') {
    session_destroy();
    header('Location: /');
    exit;
}
?>
<?php require_once TEMPLATES.'/header.php' ?>

<section class="welcome">
    <h1 class="welcome__heading">Gathering</h1>
    <p class="welcome__description">Простой чат для всех желающих</p>
    <?php if (!empty($_SESSION['isLoggedIn'])) { ?>
        <a href="<?=PAGES.'/chat.php'?>" class="welcome__button welcome__button--login">Перейти к чату</a>
    <?php } else { ?>
        <a href="<?=PAGES.'/register.php'?>" class="welcome__button welcome__button--register">Регистрация</a>
        <a href="<?=PAGES.'/login.php'?>" class="welcome__button welcome__button--login">Войти</a>
    <?php } ?>
</section>

<?php require_once TEMPLATES.'/footer.php' ?>
