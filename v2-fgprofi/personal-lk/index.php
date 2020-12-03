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




            <div class="account">
                <div class="account__info">
                    <p class="account__name">Разинкин Сергей </p>
                    <p class="account__identifier">
                        <span class="account__id">ID: 526</span>
                        <span class="account__status">Физическое лицо</span>
                    </p>
                    <a class="link link-button" href="/personal/edit/">Редактировать профиль</a>
                    <a class="link link-button link-button--disabled fancybox-popup__link" href="#write-message">Написать сообщение</a>
                </div>
                <div class="account__image">
                    <div class="account__img-wrap img-wrap">
                        <img class="img" src="/bitrix/templates/pakk/img/avatar.svg" alt="">
                    </div>
                </div>

                <div class="account__tab">
                    <div class="account__tab-wrap">
                        <div class="account__tab-btn active">Информация</div>
                        <div class="account__tab-btn">Образование</div>
                        <div class="account__tab-btn">Место работы</div>
                        <div class="account__tab-btn">Область работы</div>
                    </div>
                    <div class="account__tab-content show">
                        <div class="account__tab-title">Информация</div>
                        <div class="account__tab-text">
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Дата рождения </div>
                                <div class="account__tab-item-descr">01.12.1987</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Владение языками </div>
                                <div class="account__tab-item-descr">Русский <span>/ Английский / Китайский</span></div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Регион проживания</div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Населенный пункт </div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Контакты</div>
                                <div class="account__tab-item-descr">+7 (900) 123 - 32 - 98</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Почта</div>
                                <div class="account__tab-item-descr">ivanov@info.ru </div>
                            </div>
                        </div>
                    </div>
                    <div class="account__tab-content">
                        <div class="account__tab-title">Образование</div>
                        <div class="account__tab-text">
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Дата рождения </div>
                                <div class="account__tab-item-descr">01.12.1987</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Владение языками </div>
                                <div class="account__tab-item-descr">Русский <span>/ Английский / Китайский</span></div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Регион проживания</div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Населенный пункт </div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Контакты</div>
                                <div class="account__tab-item-descr">+7 (900) 123 - 32 - 98</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Почта</div>
                                <div class="account__tab-item-descr">ivanov@info.ru </div>
                            </div>
                        </div>
                    </div>
                    <div class="account__tab-content">
                        <div class="account__tab-title">Место работы</div>
                        <div class="account__tab-text">
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Дата рождения </div>
                                <div class="account__tab-item-descr">01.12.1987</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Владение языками </div>
                                <div class="account__tab-item-descr">Русский <span>/ Английский / Китайский</span></div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Регион проживания</div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Населенный пункт </div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Контакты</div>
                                <div class="account__tab-item-descr">+7 (900) 123 - 32 - 98</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Почта</div>
                                <div class="account__tab-item-descr">ivanov@info.ru </div>
                            </div>
                        </div>
                    </div>
                    <div class="account__tab-content">
                        <div class="account__tab-title">Область работы</div>
                        <div class="account__tab-text">
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Дата рождения </div>
                                <div class="account__tab-item-descr">01.12.1987</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Владение языками </div>
                                <div class="account__tab-item-descr">Русский <span>/ Английский / Китайский</span></div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Регион проживания</div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Населенный пункт </div>
                                <div class="account__tab-item-descr">г. Москва</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Контакты</div>
                                <div class="account__tab-item-descr">+7 (900) 123 - 32 - 98</div>
                            </div>
                            <div class="account__tab-item">
                                <div class="account__tab-item-name">Почта</div>
                                <div class="account__tab-item-descr">ivanov@info.ru </div>
                            </div>
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

<div id="success-message" class="success-message">
    <img src="/bitrix/templates/pakk/img/message-success.png" alt="Отправлено" class="success-message__img">
    <p class="success-message__text">Письмо успешно отправлено</p>
</div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>