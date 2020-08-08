<?php
require CORE.'/conn.php';
$sql = 'SELECT * FROM chat ORDER BY time ASC';
$prepared_sql = $conn->prepare($sql);
$prepared_sql->execute();
$messages = $prepared_sql->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

if (!empty($messages)) {
    foreach ($messages as $message) {
        require CORE.'/conn.php';
        $sql = 'SELECT * FROM users WHERE id = :id';
        $prepared_sql = $conn->prepare($sql);
        $prepared_sql->execute([':id' => $message['author']]);
        $photo = $prepared_sql->fetch(PDO::FETCH_ASSOC);
        $photo = $photo['image'];

        if (empty($photo)) {
            $photo = '/media/no-avatar.png';
        }
        ?>

    <div class="chat__message">
        <img class="chat__message-photo" src="<?=$photo?>">
        <div class="chat__message-text"><?=$message['text']?></div>
        <time class="chat__message-time"><?=$message['time']?></time>
    </div>

    <?php }
}
$conn = null;
?>
