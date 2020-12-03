<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Шаблоны"); 
$arCategoryUsers = getCategoryUsers(15);
$arMailingRubric = getMailingRubric();
$actionForm = "/ajax/mailing-template-filter.php";
//echo "<pre>"; print_r($arCategoryUsers); echo "</pre>";?>
<main class="main">
    <div class="content">
        <div class="containered">
            <?/*<div class="sidebar sidebar--lk">
                <div class="sidebar__name">Модерация</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/admin/">Пользователи</a>
                    </li>
                    <li class="sidebar__item f_need_moderation">
                        <a class="sidebar__link" href="/admin/queries_f/">Запросы физ.лица</a>
                    <div class="count_need_moderation">2<div></div></div></li>
                    <li class="sidebar__item u_need_moderation">
                        <a class="sidebar__link" href="/admin/queries_u/">Запросы юр.лица</a>
                    <div class="count_need_moderation">2<div></div></div></li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/admin/report">Отчет</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/support/">Техподдержка</a>
                    </li>
                    <li class="sidebar__item active">
                        <div class="sidebar__link sidebar__link-info">Рассылка</div>
                        <div class="sidebar__tab-content" style="display: block;">
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/audience/">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab active" href="/admin/subscribe/mailer/template/">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/history/">Архив рассылок</a>
                        </div>
                    </li>

                    <li class="sidebar__item ">
                        <a class="sidebar__link logout_href" href="#">Выход</a>
                    </li>
                </ul>
            </div>*/?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
            <div class="main-content newsletter newsletter-search__content mailing-filter">

                <!-- <div class="newsletter__btn">
                    <a class="link link-button" href="/admin/newsletter/write/">Новая рассылка</a>
                </div> -->

                <div class="newsletter__heading">Шаблоны</div>

                <div class="newsletter__tab-info">
                    <div class="newsletter__tab-btn">
                        <div class="newsletter__tab-btn-wrap active">Физические лица</div>
                    </div>
                    <div class="newsletter__tab-btn">
                        <div class="newsletter__tab-btn-wrap">Юридические лица</div>
                    </div>
                </div>

                <div class="newsletter__tab-content active">
                    <form class="newsletter__form" action="<?=$actionForm?>">
                        <input type="hidden" name="category_users" value="<?=$arCategoryUsers[7]["VALUE"]?>">
                        <input type="text" class="newsletter__input input__search" name="name-text" placeholder="Введите название шаблона">
                        <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                        </label>


                        <?/*<label for="rubricator-input-1" class="rubricator-select">

                            <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">

                            <div class="rubricator-items">
                                <?foreach($arMailingRubric as $rubric):?>
                                    <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" id="list[<?=$rubric["ID"]?>]_f">
                                    <label for="list[<?=$rubric["ID"]?>]_f"><?=$rubric["UF_NAME"]?></label>
                                <?endforeach;?>
                                <span class="rubricator-title">Рубрикатор</span>
                            </div>
                        </label>*/?>
                        <div class="rubricator-select">
                            <div class="rubricator-items">
                                <?
                                $rubricCheckName = "Выберите тему письма";
                                foreach($arMailingRubric as $rubric):?>
                                    <div data-value='<?=$rubric["UF_XML_ID"]?>' class="rubricator-items__option"><?=$rubric["UF_NAME"]?></div>
                                <?endforeach;?>
                                <div data-value='' class="rubricator-items__option">Без рубрики</div>
                            </div>
                            <div class="rubricator-title"><?=$rubricCheckName?></div>
                            <input type="hidden" class="rubricator-input" name="list" value="">
                        </div>
                    </form>
                    <?$GLOBALS['arrFilterTemplateF'] = array('PROPERTY_CATEGORY_USERS_VALUE' => $arCategoryUsers[7]["VALUE"]);
                    $APPLICATION->IncludeComponent("bitrix:news.list","mailing-template",Array(
                                "AJAX_MODE" => "N",
                                "IBLOCK_TYPE" => "mailing",
                                "IBLOCK_ID" => "16",
                                "NEWS_COUNT" => "9999",
                                "SORT_BY1" => "ACTIVE_FROM",
                                "AR_RUBRICS" => $arMailingRubric,
                                "SORT_ORDER1" => "DESC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "arrFilterTemplateF",
                                "FIELD_CODE" => Array("ID"),
                                "PROPERTY_CODE" => Array("RUBRIC", "USERS", "COUNTER", "CATEGORY_USERS"),
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "SET_TITLE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "CACHE_TYPE" => "N",
                                "CACHE_TIME" => "3600",
                                "CACHE_FILTER" => "Y",
                                "CACHE_GROUPS" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                                "PAGER_TITLE" => "",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => "",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "SET_STATUS_404" => "N",
                                "SHOW_404" => "N",
                            )
                        );?>
                </div>
                <div class="newsletter__tab-content">
                    <form class="newsletter__form" action="<?=$actionForm?>">
                        <input type="hidden" name="category_users" value="<?=$arCategoryUsers[8]["VALUE"]?>">
                        <input type="text" class="newsletter__input input__search" name="name-text" placeholder="Введите название шаблона">
                        <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                        </label>


                        <?/*<label for="rubricator-input-2" class="rubricator-select">

                            <input type="radio" name="list" value="not_changed" id="rubricator-input-2" class="rubricator-input">

                            <div class="rubricator-items">
                                <?foreach($arMailingRubric as $rubric):?>
                                    <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" id="list[<?=$rubric["ID"]?>]_u">
                                    <label for="list[<?=$rubric["ID"]?>]_u"><?=$rubric["UF_NAME"]?></label>
                                <?endforeach;?>
                                <span class="rubricator-title">Рубрикатор</span>
                            </div>
                        </label>*/?>
                        <div class="rubricator-select">
                            <div class="rubricator-items">
                                <?
                                $rubricCheckName = "Выберите тему письма";
                                foreach($arMailingRubric as $rubric):?>
                                    <div data-value='<?=$rubric["UF_XML_ID"]?>' class="rubricator-items__option"><?=$rubric["UF_NAME"]?></div>
                                <?endforeach;?>
                                <div data-value='' class="rubricator-items__option">Без рубрики</div>
                            </div>
                            <div class="rubricator-title"><?=$rubricCheckName?></div>
                            <input type="hidden" class="rubricator-input" name="list" value="">
                        </div>
                    </form>
                    <?$GLOBALS['arrFilterTemplateU'] = array('PROPERTY_CATEGORY_USERS_VALUE' => $arCategoryUsers[8]["VALUE"]);
                    $APPLICATION->IncludeComponent("bitrix:news.list","mailing-template",Array(
                                "AJAX_MODE" => "N",
                                "IBLOCK_TYPE" => "mailing",
                                "IBLOCK_ID" => "16",
                                "NEWS_COUNT" => "9999",
                                "SORT_BY1" => "ACTIVE_FROM",
                                "AR_RUBRICS" => $arMailingRubric,
                                "SORT_ORDER1" => "DESC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "arrFilterTemplateU",
                                "FIELD_CODE" => Array("ID"),
                                "PROPERTY_CODE" => Array("RUBRIC", "USERS", "COUNTER", "CATEGORY_USERS"),
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "SET_TITLE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "CACHE_TYPE" => "N",
                                "CACHE_TIME" => "3600",
                                "CACHE_FILTER" => "Y",
                                "CACHE_GROUPS" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                                "PAGER_TITLE" => "",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => "",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "SET_STATUS_404" => "N",
                                "SHOW_404" => "N",
                            )
                        );?>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="success-delete-popup">
    <div class="success-delete-popup-text">
        Вы действительно хотите удалить шаблон?
        <a class="success-delete-popup-btn">
            <div class="button-green">
                Да
            </div>
        </a>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>