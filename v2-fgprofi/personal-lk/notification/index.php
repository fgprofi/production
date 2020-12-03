<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Настройки пользователя"); ?>


<main class="main main--snow">
    <div class="content">
        <div class="containered">
            <div class="sidebar">
                <div class="sidebar__name">Мой профиль</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/personal/edit/">Настройки</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/personal-lk/communication/">Общение</a>
                    </li>
                    <li class="sidebar__item active">
                        <a class="sidebar__link" href="/personal-lk/notification/">Уведомления</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link drop-login__menu-item_feedback" href="#">Обратная связь</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/personal-lk/faq/">FAQ</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/support/">Техподдержка</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link logout_href" href="">Выход</a>
                    </li>
                </ul>
            </div>




            <div class="notification">
                <div class="notification__title">Уведомления</div>
                <div class="notification__content">
                    <div class="notification__item">
                        <div class="notification__item-close"></div>
                        <div class="notification__item-image">
                            <img class="img" src="/bitrix/templates/pakk/img/avatar.svg" alt="">
                        </div>
                        <div class="notification__item-text">
                            <div class="notification__item-name">Техническая поддержка</div>
                            <div class="notification__item-descr">Excepteur anim officia do velit do in labore mollit dolor elit sit. Occaecat officia cillum non ex, anim officia do velit do in labore mollit dolor elit...</div>
                        </div>
                    </div>
                    <div class="notification__item">
                        <div class="notification__item-close"></div>
                        <div class="notification__item-image">
                            <img class="img" src="/bitrix/templates/pakk/img/avatar.svg" alt="">
                        </div>
                        <div class="notification__item-text">
                            <div class="notification__item-name">Модератор</div>
                            <div class="notification__item-descr">Excepteur anim officia do velit do in labore mollit dolor elit sit. Occaecat officia cillum non ex, anim officia do velit do in labore mollit dolor elit...</div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</main>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>