            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__block">
                    <p>Мурашов Никита</p>
                    <a href="https://github.com/CyberWeel">Профиль на Github</a>
                </div>
                <div class="footer__block">
                    <p>Основано на Crawfish</p>
                    <a href="https://github.com/CyberWeel/crawfish">Ссылка на репозиторий</a>
                </div>
                <div class="footer__block">
                    <p>Проект Gathering</p>
                    <a href="https://github.com/CyberWeel/gathering">Ссылка на репозиторий</a>
                </div>
            </div>
        </div>
    </footer>
    <?php if (!isset($_COOKIE['agreedWithCookie'])): ?>
    <div class="cookie">
        На нашем сайте используются cookie. Продолжая пользоваться сайтом, вы
        соглашаетесь на их использование.
        <div class="close"></div>
    </div>
    <?php endif ?>
    <?php require_once CORE.'/theme-styles.php' ?>
    <script src="/js/main-dist.js"></script>
</body>
</html>
