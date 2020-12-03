<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); ?>
<main class="main">
    <div class="content">
        <div class="containered">
            <div class="sidebar sidebar--lk">
                <div class="sidebar__name">Модерация</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/admin/">Пользователи</a>
                    </li>
                    <li class="sidebar__item f_need_moderation">
                        <a class="sidebar__link" href="/admin/queries_f/">Запросы физ.лица</a>
                    </li>
                    <li class="sidebar__item u_need_moderation">
                        <a class="sidebar__link" href="/admin/queries_u/">Запросы юр.лица</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/admin/report">Отчет</a>
                    </li>
                    <li class="sidebar__item">`
                        <a class="sidebar__link" href="/support/">Техподдержка</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/vote/">Опросы</a>
                    </li>
                    <li class="sidebar__item active">
                        <div class="sidebar__link sidebar__link-info">Рассылка</div>
                        <div class="sidebar__tab-content">
                            <a class="sidebar__link sidebar__link-tab" href="/admin/newsletter/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/newsletter/audience/">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/newsletter/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/newsletter/template/">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/newsletter/history">Архив рассылок</a>
                        </div>
                    </li>

                    <li class="sidebar__item ">
                        <a class="sidebar__link logout_href" href="#">Выход</a>
                    </li>
                </ul>
            </div>
            <div class="main-content newsletter-search">


                <div class="newsletter__title">
                    <div class="newsletter__title-heading">Рассылка № <span class="newsletter__num">003</span></div>
                    <a class="link link-button link-button--transparent fancybox-popup__link" href="#audience-popup" rel="tofollow">Выбрать из аудитории</a>
                </div>

                <div class="newsletter-search__content">
                    <div class="newsletter__tab-info">
                        <div class="newsletter__tab-btn active">
                            <div class="newsletter__tab-btn-wrap newsletter__tab-btn-wrap--individual active">Физические лица</div>
                            <div class="newsletter__tab-btn-wrap newsletter__tab-btn-wrap--entity">Юридические лица</div>
                        </div>
                        <div class="newsletter__tab-btn">
                            <div class="newsletter__tab-btn-wrap">Шаблоны</div>
                        </div>
                        <div class="newsletter__tab-btn">
                            <div class="newsletter__tab-btn-wrap">Архив рассылок</div>
                        </div>
                    </div>


                    <div class="newsletter__tab-content active">
                        <form action class="newsletter-search__form">
                            <label class="newsletter-search__close" for=""><svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                                    <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                                </svg></label>
                            <input type="text" class="newsletter-search__input newsletter__form-input" placeholder="Поиск">
                        </form>

                        <a href="#save-audience" rel="nofollow" class="link link-button link-button--transparent fancybox-popup__link">Сохранить как аудиторию</a>


                        <div class="filter">
                            <div class="filter__head">
                                <div class="filter__left">
                                    <label class="filter__label select_all">
                                        <input class="filter__input" type="checkbox">
                                        <span class="filter__check"></span>
                                        <span class="filter__name">Выбрать всех</span>
                                    </label>
                                </div>
                                <div class="filter__right">
                                    <a class="link link-button link-button--disabled">Написать</a>
                                </div>
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
                                        <a class="link link-button link-button--transparent">Написать</a>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>






                    <div class="newsletter__tab-content">
                        <form class="newsletter__form" action="#">
                            <input type="text" class="newsletter__input input__search" placeholder="Искать по названию, дате">
                            <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                            </label>


                            <label for="rubricator-input-1" class="rubricator-select">

                                <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">

                                <div class="rubricator-items">
                                    <input type="radio" name="list" value="first_value" id="list[8]">
                                    <label for="list[8]">Опрос</label>
                                    <input type="radio" name="list" value="second_value" id="list[9]">
                                    <label for="list[9]">Поздравление</label>
                                    <input type="radio" name="list" value="second_value" id="list[10]">
                                    <label for="list[10]">Информационное сообщение</label>
                                    <input type="radio" name="list" value="second_value" id="list[11]">
                                    <label for="list[11]">Мнение</label>
                                    <span class="rubricator-title">Рубрикатор</span>
                                </div>
                            </label>
                        </form>


                        <div class="newsletter__content">

                            <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--template">
                                <div class="newsletter__img newsletter__img--template"></div>
                                <div class="newsletter-text">
                                    <div class="newsletter__name">Короновирус</div>
                                    <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                    <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                </div>
                                <div class="newsletter__item-delete">
                                    <div class="newsletter__form-trash-wrap">
                                        <div class="newsletter__form-trash"></div>
                                    </div>
                                </div>
                            </a>

                            <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--template">
                                <div class="newsletter__img newsletter__img--template"></div>
                                <div class="newsletter-text">
                                    <div class="newsletter__name">Короновирус</div>
                                    <div class="newsletter__subtitle">№029 | Информационное сообщение | Физические лица</div>
                                    <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                </div>
                                <div class="newsletter__item-delete">
                                    <div class="newsletter__form-trash-wrap">
                                        <div class="newsletter__form-trash"></div>
                                    </div>
                                </div>
                            </a>



                            <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--template">
                                <div class="newsletter__img newsletter__img--template"></div>
                                <div class="newsletter-text">
                                    <div class="newsletter__name">Короновирус</div>
                                    <div class="newsletter__subtitle">№029 | Мнение | Физические лица</div>
                                    <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                </div>
                                <div class="newsletter__item-delete">
                                    <div class="newsletter__form-trash-wrap">
                                        <div class="newsletter__form-trash"></div>
                                    </div>
                                </div>
                            </a>



                            <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--template">
                                <div class="newsletter__img newsletter__img--template"></div>
                                <div class="newsletter-text">
                                    <div class="newsletter__name">Короновирус</div>
                                    <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                    <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                </div>
                                <div class="newsletter__item-delete">
                                    <div class="newsletter__form-trash-wrap">
                                        <div class="newsletter__form-trash"></div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    <div class="newsletter__tab-content">

                        <form class="newsletter__form" action="#">
                            <input type="text" class="newsletter__input input__search" placeholder="Искать по названию, дате">
                            <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                            </label>


                            <label for="rubricator-input-3" class="rubricator-select">

                                <input type="radio" name="list" value="not_changed" id="rubricator-input-3" class="rubricator-input">

                                <div class="rubricator-items">
                                    <input type="radio" name="list" value="first_value" id="list[12]">
                                    <label for="list[12]">Опрос</label>
                                    <input type="radio" name="list" value="second_value" id="list[13]">
                                    <label for="list[13]">Поздравление</label>
                                    <input type="radio" name="list" value="second_value" id="list[14]">
                                    <label for="list[14]">Информационное сообщение</label>
                                    <input type="radio" name="list" value="second_value" id="list[15]">
                                    <label for="list[15]">Мнение</label>
                                    <span class="rubricator-title">Рубрикатор</span>
                                </div>
                            </label>
                        </form>


                        <div class="newsletter__content">
                            <div class="newsletter__date">
                                <div class="newsletter__date-header">03 апреля</div>
                                <a href="/admin/newsletter/write" class="newsletter__item">
                                    <div class="newsletter__img"></div>
                                    <div class="newsletter-text">
                                        <div class="newsletter__name">Короновирус</div>
                                        <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                        <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                    </div>
                                </a>

                                <a href="/admin/newsletter/write" class="newsletter__item">
                                    <div class="newsletter__img"></div>
                                    <div class="newsletter-text">
                                        <div class="newsletter__name">Короновирус</div>
                                        <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                        <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                    </div>
                                </a>
                            </div>

                            <div class="newsletter__date">
                                <div class="newsletter__date-header">03 апреля</div>
                                <a href="/admin/newsletter/write" class="newsletter__item">
                                    <div class="newsletter__img"></div>
                                    <div class="newsletter-text">
                                        <div class="newsletter__name">Короновирус</div>
                                        <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                        <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                    </div>
                                </a>
                            </div>

                            <div class="newsletter__date">
                                <div class="newsletter__date-header">03 апреля</div>
                                <a href="/admin/newsletter/write" class="newsletter__item">
                                    <div class="newsletter__img"></div>
                                    <div class="newsletter-text">
                                        <div class="newsletter__name">Короновирус</div>
                                        <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                                        <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                                    </div>
                                </a>
                            </div>
                        </div>


                    </div>


                    <a class="link link-button" href="#">Перейти в форму рассылки</a>
                </div>

            </div>
        </div>
    </div>
    </div>
</main>



<div id="save-audience" class="save-audience">
    <div class="save-audience__title">Аудитория № 003</div>
    <div class="save-audience__rubricator">Рубрикатор</div>
    <form action="" class="save-audience__form">
        <textarea class="save-audience__textarea" placeholder="Описание аудитории..."></textarea>
        <div class="save-audience__btns">
            <button type="submit" class="link link-button" href="#">Сохранить</a>
                <button type="submit" class="link link-button link-button--cansel" href="#">Отменить <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                        <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                    </svg></a>
        </div>
    </form>
</div>








<div id="audience-popup" class="audience-popup">
    <div class="audience-popup__title">Выбрать из аудитории</div>
    <div class="audience-popup__content">
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 001</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 002</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 003</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 004</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 005</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 006</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 007</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
        <div class="audience-popup__item">
            <div class="audience-popup__item-name">Аудитория № 008</div>
            <div class="audience-popup__item-text">Активно развивающиеся страны третьего мира неоднозначны </div>
        </div>
    </div>
    <div class="audience-popup__btns">
        <button class="link link-button">Выбрать</button>
        <button class="link link-button link-button--cansel">Отменить<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>