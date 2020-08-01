<?php require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php' ?>
<?php $pageTitle = 'Gathering - Чат' ?>
<?php
require_once CORE.'/themes.php';

require CORE.'/conn.php';
$sql = 'SELECT * FROM users WHERE nickname = :nickname';
$prepared_sql = $conn->prepare($sql);
$prepared_sql->execute([':nickname' => $_SESSION['nickname']]);
$row = $prepared_sql->fetch();
$avatar_path = $row['image'];
$conn = null;

$colors = [];

foreach ($themes as $theme) {
    array_push($colors, $theme['color']);
}

if (!empty($_GET['color']) && in_array($_GET['color'], $colors)) {
    require CORE.'/conn.php';
    $sql = 'UPDATE users SET theme = :theme WHERE nickname = :nickname';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute([':theme' => $_GET['color'], ':nickname' => $_SESSION['nickname']]);
    $conn = null;

    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<?php require_once TEMPLATES.'/header.php' ?>

<aside class="bar">
    <div class="bar__avatar">
        <img src="<?=$avatar_path?>">
    </div>
    <span class="bar__nickname"><?=$_SESSION['nickname']?></span>
    <hr class="bar__line">
    <h2 class="bar__settings">Настройки</h2>
    <h3 class="bar__themes-heading">Тема чата</h3>
    <?php require_once TEMPLATES.'/themes.php' ?>
    <h3 class="bar__themes-heading">Смена пароля</h3>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="bar__form">
        <input type="password" class="bar__password" name="user_old_password" placeholder="Старый пароль">
        <input type="password" class="bar__password" name="user_new_password" placeholder="Новый пароль">
    </form>
    <a href="/" class="bar__exit">Выйти</a>
</aside>

<main class="chat">
    <section class="chat__window"></section>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="chat__form">
        <textarea name="user_message" class="user_message"></textarea>
        <input type="submit" value="" class="user_send">
    </form>
</main>

<?php require_once TEMPLATES.'/footer.php' ?>
