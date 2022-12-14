<? if ($page_count > 1) : ?>
    <ul class="pagination">
        <? if ($page_count > 10) : ?>
            <li>
                <a href="?page=<?= $page_ceil - 10 . $project_query_add ?>">
                    <i class="material-icons">
                        chevron_left
                    </i>
                </a>
            </li>
        <? else : ?>
            <li class="disabled">
                <a href="#">
                    <i class="material-icons">
                        chevron_left
                    </i>
                </a>
            </li>
        <? endif; ?>
        
        <? for ($i = $page_ceil; $i < $page_ceil + 10; $i++) : ?>
            <? if ($page_count < $i) break; ?>
            <li class="<?= $i == $page ? 'active blue darken-1' : 'waves-effect' ?>">
                <a href="?page=<?= $i . $project_query_add ?>">
                    <?= $i ?>
                </a>
            </li>
        <? endfor; ?>
        <? if (floor($page_count/10)*10 > $page) : ?>
            <li class="waves-effect">
                <a href="?page=<?= $page_ceil + 10 . $project_query_add ?>">
                    <i class="material-icons">
                        chevron_right
                    </i>
                </a>
            </li>
        <? else : ?>
            <li class="disabled">
                <a href="#">
                    <i class="material-icons">
                        chevron_right
                    </i>
                </a>
            </li>
        <? endif; ?>
    </ul>
<? endif; ?>