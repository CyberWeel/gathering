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

if (!empty($_POST['user_old_password']) && !empty($_POST['user_new_password'])) {
    $user_old_password = sanitizeField($_POST['user_old_password']);
    $user_new_password = sanitizeField($_POST['user_new_password']);

    require CORE.'/conn.php';
    $sql = 'SELECT password FROM users WHERE nickname = :nickname';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute([':nickname' => $_SESSION['nickname']]);
    $current_password = $prepared_sql->fetch();
    $current_password = $current_password['password'];
    $conn = null;

    if (hash('md5', $user_old_password) === $current_password) {
        require CORE.'/conn.php';
        $sql = 'UPDATE users SET password = :password WHERE nickname = :nickname';
        $prepared_sql = $conn->prepare($sql);
        $prepared_sql->execute([':password' => hash('md5', $user_new_password), ':nickname' => $_SESSION['nickname']]);
        $conn = null;
        header('Location: '.$_SERVER['PHP_SELF']);
        exit;
    }
}

if (!empty($_POST['user_message'])) {
    $user_message = sanitizeField($_POST['user_message']);

    require CORE.'/conn.php';
    $sql = 'SELECT id FROM users WHERE nickname = :nickname';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute([':nickname' => $_SESSION['nickname']]);
    $id = $prepared_sql->fetch();
    $id = intval($id['id']);
    $prepared_sql->closeCursor();

    $sql = 'INSERT INTO chat(`text`, `author`) VALUES(:text, :author)';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute([':text' => $user_message, ':author' => $id]);

    $conn = null;
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<?php require_once TEMPLATES.'/header.php' ?>

<section class="bar_and_chat">
    <aside class="bar">
        <div class="bar__avatar">
            <img src="<?=$avatar_path?>">
        </div>
        <span class="bar__nickname"><?=$_SESSION['nickname']?></span>
        <h2 class="bar__themes-heading">Тема чата</h3>
        <?php require TEMPLATES.'/themes.php' ?>
        <h2 class="bar__themes-heading">Смена пароля</h3>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="bar__form">
            <input type="password" class="bar__password" name="user_old_password" placeholder="Старый пароль">
            <input type="password" class="bar__password" name="user_new_password" placeholder="Новый пароль">
            <input type="submit" value="Сменить">
        </form>
        <a href="/?quit=yes" class="bar__exit">Выйти</a>
    </aside>

    <main class="chat">
        <section class="chat__window">
            <?php require_once TEMPLATES.'/chat.php' ?>
        </section>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="chat__form">
            <textarea name="user_message" class="user_message"></textarea>
            <input type="submit" value="Отправить" class="user_send">
        </form>
    </main>
</section>

<?php require_once TEMPLATES.'/footer.php' ?>
