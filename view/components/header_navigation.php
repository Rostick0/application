<nav class="header__nav blue darken-1">
    <div class="container h-100-pc">
        <ul class="header__navigation h-100-pc">
            <li class="header__navigation_item <?= HtmlDom::setClass('active', $URI === '/') ?>">
                <a href="/">
                    Главная
                </a>
            </li>
            <li class="header__navigation_item <?= HtmlDom::setClass('active', $URI === '/project/create') ?>">
                <a href="/project/create">
                    Создание
                </a>
            </li>
            <li class="header__navigation_item <?= HtmlDom::setClass('active', $URI === '/project/my') ?>">
                <a href="/project/my">
                    Мои проекты
                </a>
            </li>
            <li class="header__navigation_item">
                <a href="">
                    Выход
                </a>
            </li>
        </ul>
    </div>
</nav>