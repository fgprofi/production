<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); ?>
<main class="main main--snow">
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
            <div class="main-content newsletter-write">

                <div class="newsletter__title">
                    <div class="newsletter__title-heading">Рассылка № <span class="newsletter__num">003</span></div>
                    <a class="link link-button link-button--transparent fancybox-popup__link" href="#audience-popup" rel="tofollow">Выбрать из аудитории</a>
                </div>

                <form action class="newsletter__form">
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label newsletter__form-label--whom">Кому: <span>Иванова Людмила, Иванов Анатольевич, Иванова Лю...</span></label>
                        <div class="newsletter__form-whom-edit">
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                            <div class="newsletter__form-whom-edit-item">Lorem ipsum</div>
                        </div>

                        <!-- <input type="text" class="newsletter__form-input newsletter__form--whom"> -->
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label">Заголовок: </label>
                        <input type="text" class="newsletter__form-input newsletter__form--title" placeholder="введите текст">
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">


                        <!-- <label for="rubricator-input-1" class="rubricator-select">
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
                                <span class="rubricator-title">Выберите тему письма</span>
                            </div>
                        </label> -->

                        <div class="rubricator-select">
                            <div class="rubricator-title">Выберите тему письма</div>
                            <input type="radio" class="rubricator-input">
                            <div class="rubricator-items">
                                <div data-value='1' class="rubricator-items__option">Тест</div>
                                <div data-value='2' class="rubricator-items__option">Lorem </div>
                                <div data-value='3' class="rubricator-items__option">Lorem, ipsum.</div>
                                <div data-value='4' class="rubricator-items__option">Lorem123</div>
                            </div>
                        </div>

                    </div>
                    <div class="newsletter__form-group newsletter__form-group--message">
                        <div class="newsletter__form-message">
                            <div class="newsletter__form-message-title">Сообщение</div>
                            <div class="textarea-edit">
                                <div class="textarea-edit__bold textarea-edit__item">B</div>
                                <div class="textarea-edit__italic textarea-edit__item">i</div>
                                <div class="textarea-edit__under textarea-edit__item">U</div>
                                <div class="textarea-edit__qoute textarea-edit__item">Цитата</div>
                                <div class="textarea-edit__code textarea-edit__item">Код</div>
                            </div>
                        </div>
                        <textarea class="newsletter__form-textarea" placeholder="Введите текст сообщения"></textarea>
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--file">
                        <div class="newsletter__form-file">
                            <img src="../../../bitrix/templates/pakk/img/upload-file.svg" alt="Загрузить" class="newsletter__form-file-img">
                            Прикрепить файл
                            <span>максимальный вес файла 300 кб</span>
                        </div>


                        <div class="newsletter__form-calendar-container">
                            <!-- Если добавить класс .newsletter__form-calendar-wrap--active, то календарь будет активен -->
                            <div class="newsletter__form-calendar-wrap">
                                <div class="newsletter__form-calendar"></div>
                            </div>
                            <div class="newsletter__form-calendar-popup">
                                Отправить письмо <span>сегодня</span> в <span>14:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="newsletter__form-btns">
                        <button type="submit" class="link link-button">Отправить</button>
                        <button class="link link-button link-button--transparent">Сохранить как шаблон</button>
                        <button class="link link-button link-button--cansel">Сбросить<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                            </svg></button>

                        <!-- Если добавить класс .newsletter__form-trash-wrap--active, то корзина будет активна -->
                        <div class="newsletter__form-trash-wrap">
                            <div class="newsletter__form-trash"></div>
                        </div>
                    </div>
                </form>






            </div>
        </div>
    </div>
    </div>
</main>

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