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
                    <li class="sidebar__item active">
                        <a class="sidebar__link" href="/personal-lk/communication/">Общение</a>
                    </li>
                    <li class="sidebar__item">
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



            <div class="communication">
                <form action="#" class="communication__form">
                    <input type="text" class="input__search" placeholder="Кого вы хотите найти?">
                </form>
                <div class="filter">
                    <div class="filter__head">
                        <div class="filter__left">
                            <label class="filter__label select_all">
                                <input class="filter__input" type="checkbox">
                                <span class="filter__check"></span>
                                <span class="filter__name">Выбрать всех</span>
                            </label>
                        </div>
                        <!-- <div class="filter__right">
                            <a class="link link-button link-button--disabled">Написать</a>
                        </div> -->
                    </div>
                    <div class="filter__body">

                        <div class="filter__item">
                            <div class="filter__left">
                                <label class="filter__label">
                                    <input class="filter__input" type="checkbox">
                                    <span class="filter__check"></span>
                                </label>
                            </div>
                            <a class="filter__middle" href="/personal/fiz_faces/439/">
                                <div class="filter__profile profile-filter">
                                    <div class="profile-filter__image">
                                        <div class="header-login__img-wrap">
                                            <img class="header-login__img" src="/upload/resize_cache/iblock/382/64_64_2/38276357eb22cf520ee7b1e1809ee8d5.jpg">
                                            <span class="header-login__initials">ФВ</span>
                                        </div>
                                    </div>
                                    <div class="profile-filter__info">
                                        <p class="profile-filter__name">Финогенов Вадим Кириллович</p>
                                        <p class="profile-filter__identifier">
                                            <span class="profile-filter__id">ID: 439 | </span>
                                            <span class="profile-filter__status">физическое лицо</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="filter__right">
                                <a href="#write-message" class="link link-button link-button--disabled fancybox-popup__link">Написать</a>
                            </div>
                        </div>

                        <div class="filter__item filter__item--empty">
                            Нет результатов поиска
                        </div>

                    </div>
                </div>
            </div>





        </div>
    </div>
</main>


<div id="write-message" class="write-message">
    <div class="popup__title">Новое сообщение</div>
    <div class="popup__content">
        <div class="popup__person">
            <div class="popup__img-wrap">
                <img src="/upload/resize_cache/iblock/382/64_64_2/38276357eb22cf520ee7b1e1809ee8d5.jpg" class="popup__img">
            </div>
            <div class="popup__text">
                <div class="popup__name">Финогенов Вадим Кириллович</div>
                <div class="popup__id-wrap">
                    <span class="popup__id">ID: 439 | </span>
                    <span class="popup__status">физическое лицо</span>
                </div>
            </div>
        </div>
        <form action="#" class="popup__form">
            <input type="text" class="popup__theme input__search" placeholder="Тема письма">
            <textarea class="popup__textarea" placeholder="Введите текст сообщения"></textarea>
            <div class="popup__form-btns">
                <input type="file" class="popup__file">
                <button class="link link-button report-link" type="submit">Отправить</button>
            </div>
        </form>
    </div>
</div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>