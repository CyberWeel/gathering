<?php
require CORE.'/conn.php';
require CORE.'/themes.php';

if (isset($_SESSION['nickname'])) {
    $sql = 'SELECT theme FROM users WHERE nickname = :nickname';
    $prepared_sql = $conn->prepare($sql);
    $prepared_sql->execute([':nickname' => $_SESSION['nickname']]);
    $user_theme = $prepared_sql->fetch();
    $user_theme = $user_theme['theme'];
    $conn = null;

    foreach ($themes as $theme) {
        if ($theme['color'] === $user_theme) { ?>
            <style>
                .bar { background: <?=$theme['use']?>; }
            </style>
        <?php
            break;
        }
    }
}
?>
