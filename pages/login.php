<?php require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php' ?>
<?php $pageTitle = 'Gathering - Войти' ?>
<?php
if (!empty($_POST)) {
    $errors = [];
    $user_login = sanitizeField($_POST['user_login']);
    $user_password = sanitizeField($_POST['user_password']);

    require CORE.'/conn.php';
    $sql = 'SELECT * FROM users';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute();
    $users = $prepared_sql->fetchAll();
    $conn = null;

    foreach ($users as $user) {
        if (
            ($user['login'] === $user_login) &&
            ($user['password'] === hash('md5', $user_password))
        ) {
            $_SESSION['isLoggedIn'] = 'yes';
            $_SESSION['nickname'] = $user['nickname'];
            header('Location: '.PAGES.'/chat.php');
            exit;
        }
    }
}
?>
<?php require_once TEMPLATES.'/header.php' ?>

<section class="login">
    <h1 class="login__heading">Login</h1>
    <p class="login__description">
        Входите на сайт и скажите всем, что вы о них думаете!
    </p>

    <form class="login__form" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <label for="user_login">Логин <span class="careful">(A-Z, a-z, 0-9, не более 16 символов)</span>:</label>
        <input type="text" name="user_login" id="user_login" placeholder="CalmMonkey777" value="<?=(!empty($user_login)) ? $user_login : ''?>">
        <label for="user_password">Пароль <span class="careful">(A-Z, a-z, 0-9, $, _, не менее 6 и не более 16 символов)</span>:</label>
        <input type="password" name="user_password" id="user_password" value="<?=(!empty($user_password)) ? $user_password : ''?>">
        <input type="submit" name="user_submit" value="Войти" class="login__button">
    </form>

    <a href="/" class="login__button login__button--back">Назад</a>
</section>

<?php require_once TEMPLATES.'/footer.php' ?>
