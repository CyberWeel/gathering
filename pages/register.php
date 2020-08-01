<?php require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php' ?>
<?php $pageTitle = 'Gathering - Регистрация' ?>
<?php
if (!empty($_POST)) {
    $errors = [];
    $pattern = '/^[A-Za-z0-9]*$/';
    $extended_pattern = '/^[A-Za-z0-9\_\$]*$/';

    $user_login = sanitizeField($_POST['user_login']);
    $user_password = sanitizeField($_POST['user_password']);
    $user_password_copy = sanitizeField($_POST['user_password_copy']);
    $user_nickname = sanitizeField($_POST['user_nickname']);
    $user_avatar = $_FILES['user_avatar'];

    $user_avatar_name = sanitizeField($user_avatar['name']);
    $user_avatar_type = $user_avatar['type'];
    $user_avatar_tmpname = $user_avatar['tmp_name'];
    $user_avatar_error = $user_avatar['error'];
    $user_avatar_size = $user_avatar['size'];

    if (
        (empty($user_login)) ||
        (strlen($user_login) > 16) ||
        (preg_match($pattern, $user_login) !== 1)
    ) {
        array_push($errors, 'Логин');
    }

    if (
        (strlen($user_password) < 6) ||
        (strlen($user_password) > 16) ||
        (preg_match($extended_pattern, $user_password) !== 1) ||
        ($user_password !== $user_password_copy)
    ) {
        array_push($errors, 'Пароль');
    } else {
        $hashed_user_password = hash('md5', $user_password);
    }

    if (
        (empty($user_nickname)) ||
        (strlen($user_nickname) > 16) ||
        (preg_match($pattern, $user_nickname) !== 1)
    ) {
        array_push($errors, 'Никнейм');
    }

    if (
        (
            $user_avatar_error !== 4
        ) && (
            (empty($user_avatar_name)) ||
            (!in_array($user_avatar_type, ['image/png', 'image/jpeg', 'image/gif'])) ||
            ($user_avatar_size > 1048576) ||
            ($user_avatar_error !== 0)
        )
    ) {
        array_push($errors, 'Изображение профиля');
    }

    if (empty($errors)) {
        try {
            require CORE.'/conn.php';

            $sql = '
                SELECT *
                FROM users
                WHERE login = :login OR nickname = :nickname
            ';

            $prepared_sql = $conn->prepare($sql);
            $prepared_sql->execute([':login' => $user_login, ':nickname' => $user_nickname]);

            if (empty($prepared_sql->fetchAll())) {
                $prepared_sql->closeCursor();
                if ($user_avatar_error === 0) {
                    $file_ext_dot = strrpos($user_avatar_name, '.');
                    $file_ext = substr($user_avatar_name, $file_ext_dot);

                    $user_avatar_newname = hash('md5', rand(0, 100).basename($user_avatar_name)).$file_ext;
                    move_uploaded_file($user_avatar_tmpname, USERS.'/'.$user_avatar_newname);

                    $sql = '
                        INSERT INTO users(login, password, nickname, image)
                        VALUES(:login, :password, :nickname, :image)
                    ';

                    $prepared_sql = $conn->prepare($sql);
                    $prepared_sql->execute([
                        ':login' => $user_login,
                        ':password' => $hashed_user_password,
                        ':nickname' => $user_nickname,
                        ':image' => '/media/users/'.$user_avatar_newname
                    ]);
                } else {
                    $sql = '
                        INSERT INTO users(login, password, nickname)
                        VALUES(:login, :password, :nickname)
                    ';

                    $prepared_sql = $conn->prepare($sql);
                    $prepared_sql->execute([
                        ':login' => $user_login,
                        ':password' => $hashed_user_password,
                        ':nickname' => $user_nickname
                    ]);
                }

                $_SESSION['isLoggedIn'] = 'yes';
                $_SESSION['nickname'] = $user_nickname;
                header('Location: '.PAGES.'/chat.php');
                exit;
            } else {
                $userAlreadyExists = true;
            }

            $conn = null;
        } catch (PDOException $e) {
            echo 'Ошибка PDO: '.$e->getMessage().'<br>';
            exit;
        }
    }
}
?>
<?php require_once TEMPLATES.'/header.php' ?>

<section class="register">
    <h1 class="register__heading">Registration</h1>
    <p class="register__description">
        Впервые на сайте? Зарегистрируйтесь и общайтесь с людьми со всех уголков планеты!
    </p>
    <?php if (!empty($errors)): ?>
    <section class="error">
        <h2 class="error__heading">Следующие поля были указаны некорректно:</h2>
        <ul class="error__list">
            <?php foreach ($errors as $error): ?>
            <li class="error__item"><?=$error?></li>
            <?php endforeach ?>
        </ul>
    </section>
    <?php endif ?>

    <?php if (!empty($userAlreadyExists)): ?>
    <section class="error">
        <h2 class="error__heading">Ошибка</h2>
        <p class="error__paragraph">Пользователь с указанным логином или никнеймом уже существует!</p>
    </section>
    <?php endif ?>
    <form class="register__form" action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <label for="user_login">Логин <span class="careful">(A-Z, a-z, 0-9, не более 16 символов)</span>:</label>
        <input type="text" name="user_login" id="user_login" placeholder="CalmMonkey777" value="<?=(!empty($user_login)) ? $user_login : ''?>">
        <label for="user_password">Пароль <span class="careful">(A-Z, a-z, 0-9, $, _, не менее 6 и не более 16 символов)</span>:</label>
        <input type="password" name="user_password" id="user_password" value="<?=(!empty($user_password)) ? $user_password : ''?>">
        <label for="user_password_copy">Подтвердите пароль:</label>
        <input type="password" name="user_password_copy" id="user_password_copy" value="<?=(!empty($user_password_copy)) ? $user_password_copy : ''?>">
        <label for="user_nickname">Никнейм <span class="careful">(A-Z, a-z, 0-9, не более 16 символов)</span>:</label>
        <input type="text" name="user_nickname" id="user_nickname" placeholder="AngryRhino009" value="<?=(!empty($user_nickname)) ? $user_nickname : ''?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <label for="user_avatar">Изображение профиля (png, jpg, jpeg, gif, не более 1 Мб):</label>
        <div class="register__button">
            Выбрать файл
            <input type="file" name="user_avatar" id="user_avatar">
        </div>
        <input type="submit" name="user_submit" value="Зарегистрироваться" class="register__button">
    </form>
    <a href="/" class="register__button register__button--back">Назад</a>
</section>

<?php require_once TEMPLATES.'/footer.php' ?>
