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
                    <li class="sidebar__item">
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
            <div class="main-content newsletter">



                <div class="newsletter__heading">Аудитория</div>



                <form class="newsletter__form" action="#">
                    <input type="text" class="newsletter__input input__search" placeholder="Искать по названию, дате">
                    <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                    </label>


                    <label for="rubricator-input-1" class="rubricator-select">

                        <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">

                        <div class="rubricator-items">
                            <input type="radio" name="list" value="first_value" id="list[0]">
                            <label for="list[0]">Опрос</label>
                            <input type="radio" name="list" value="second_value" id="list[1]">
                            <label for="list[1]">Поздравление</label>
                            <input type="radio" name="list" value="second_value" id="list[2]">
                            <label for="list[2]">Информационное сообщение</label>
                            <input type="radio" name="list" value="second_value" id="list[3]">
                            <label for="list[3]">Мнение</label>
                            <span class="rubricator-title">Рубрикатор</span>
                        </div>
                    </label>
                </form>


                <div class="newsletter__content">

                    <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--audience">
                        <div class="newsletter__img newsletter__img--audience"></div>
                        <div class="newsletter-text">
                            <div class="newsletter__name">Аудитория № 001</div>
                            <div class="newsletter__subtitle">№003 | Преподователи | Жещины, Мужчины | 23 - 48 лет |</div>
                            <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                        </div>
                        <div class="newsletter__item-delete">
                            <div class="newsletter__form-trash-wrap">
                                <div class="newsletter__form-trash"></div>
                            </div>
                        </div>
                    </a>

                    <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--audience">
                        <div class="newsletter__img newsletter__img--audience"></div>
                        <div class="newsletter-text">
                            <div class="newsletter__name">Аудитория № 002</div>
                            <div class="newsletter__subtitle">№003 | Уичтеля | Жещины | 23 - 48 лет |</div>
                            <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                        </div>
                        <div class="newsletter__item-delete">
                            <div class="newsletter__form-trash-wrap">
                                <div class="newsletter__form-trash"></div>
                            </div>
                        </div>
                    </a>



                    <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--audience">
                        <div class="newsletter__img newsletter__img--audience"></div>
                        <div class="newsletter-text">
                            <div class="newsletter__name">Аудитория № 003</div>
                            <div class="newsletter__subtitle">№003 | Преподователи | Жещины, Мужчины | 23 - 48 лет |</div>
                            <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
                        </div>
                        <div class="newsletter__item-delete">
                            <div class="newsletter__form-trash-wrap">
                                <div class="newsletter__form-trash"></div>
                            </div>
                        </div>
                    </a>



                    <a href="/admin/newsletter/write" class="newsletter__item newsletter__item--audience">
                        <div class="newsletter__img newsletter__img--audience"></div>
                        <div class="newsletter-text">
                            <div class="newsletter__name">Аудитория № 004</div>
                            <div class="newsletter__subtitle">№003 | Уичтеля | Жещины | 23 - 48 лет</div>
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
        </div>
    </div>
</main>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>