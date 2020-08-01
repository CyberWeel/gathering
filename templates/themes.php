<ul class="bar__themes">
    <?php foreach ($themes as $theme): ?>
    <li class="bar__theme">
        <a href="<?=PAGES.'/chat.php?color='.$theme['color']?>"></a>
    </li>
    <?php endforeach ?>
</ul>
