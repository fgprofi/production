<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); 
$arMailingRubric = getMailingRubric();
?>
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
                    <li class="sidebar__item active">
                        <div class="sidebar__link sidebar__link-info">Рассылка</div>
                        <div class="sidebar__tab-content" style="display: block;">
                            <a class="sidebar__link sidebar__link-tab active" href="/admin/subscribe/mailer/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/audience/">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/template/">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/history/">Архив рассылок</a>
                        </div>
                    </li>

                    <li class="sidebar__item ">
                        <a class="sidebar__link logout_href" href="#">Выход</a>
                    </li>
                </ul>
            </div>*/?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
            <div class="main-content newsletter-search">


                <div class="newsletter__title">
                    <div class="newsletter__title-heading">Рассылка № <span class="newsletter__num"><?=getNextCounter(15)?></span></div>
                    <?/*<a class="link link-button link-button--transparent fancybox-popup__link" href="#audience-popup" rel="tofollow">Выбрать из аудитории</a>*/?>
                </div>

                <div class="newsletter-search__content">
                    <div class="newsletter__tab-info">
                        <div class="newsletter__tab-btn active">
                            <div class="newsletter__tab-btn-wrap newsletter__tab-btn-wrap--individual active">Физические лица</div>
                            <div class="newsletter__tab-btn-wrap newsletter__tab-btn-wrap--entity">Юридические лица</div>
                        </div>
                        <div class="newsletter__tab-btn" id="tab-template">
                            <div class="newsletter__tab-btn-wrap">Шаблоны</div>
                        </div>
                        <div class="newsletter__tab-btn" id="tab-history">
                            <div class="newsletter__tab-btn-wrap">Архив рассылок</div>
                        </div>
                    </div>


                    <div class="newsletter__tab-content active">
                        
						<?$APPLICATION->IncludeComponent(
							"deus:filter.faces",
							"filter-mailer-new",
							Array(
								"MULTI_SELECT"=>array(
									"LANGUAGE_SKILLS",
								),
								"PROPERTIES"=>array(
									"TYPE_F" => array(
										"NAME"=>"TYPE_F",
										"IBLOCK_ID"=>7,
										"PROP"=>array(
                                            "FIRST_NAME",
                                            "SURNAME",
                                            "DATE_OF_BIRTH",
                                            "EMAIL",
                                            "SOC",
                                            "POSITION",
                                            "SIFLAS",
                                            "LANGUAGE_SKILLS",
                                            "REGION_OF_RESIDENCE",
                                            "LOCALITY",
                                            "PLACE_OF_WORK",
                                            "EDUCATION",
                                            "KIND_OF_ACTIVITY",
                                            "FINANCIAL_LITERACY_COMPETENCIES",
                                            "TARGET_AUDIENCE",
                                            "WORK_REGIONS",
                                            "AUTHOR_OF_MATERIALS",
                                            "SIGN_OF_USER_DATA_DELETION",
                                            "PERSONAL_DATA",
                                            "VERIFICATION_PASSED_BY_MODERATOR",
                                            "EXPERT_RATING",
										),
									),
									"TYPE_U" => array(
										"NAME"=>"TYPE_U",
										"IBLOCK_ID"=>8,
										"PROP"=>array(
                                            "FIRST_NAME",
                                            "INN",
                                            "KPP",
                                            "OGRN",
                                            "ACTUAL_ADDRESS",
                                            "PHONE",
                                            "EMAIL",
                                            "SITE_PAGE",
                                            "ADDITIONAL_INFORMATION",
                                            "NAME_SUBDIVISION",
                                            "LOCATION_REGION",
                                            "LOCALITY",
                                            "FINANCIAL_LITERACY_AREAS",
                                            "TYPE_ORGANIZATION",
                                            "TARGET_AUDIENCE",
                                            "REGIONS_THE_ORGANIZATION_WORKS_WITH",
                                            "CONTRACTOR_FOR_MATERIALS",
                                            "SIGN_OF_USER_DATA_DELETION",
                                            "VERIFICATION_PASSED_BY_MODERATOR",
                                            "EXPERT_RATING",
										),
									),
								),
							)
						);?>
                    </div>


                    <div class="newsletter__tab-content">
                        <form class="newsletter__form mailing-template" action="#">
                            <input type="text" class="newsletter__input input__search" name="mailing-template-text" placeholder="Искать по названию, дате">
                            <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                            </label>


                            <?/*<label for="rubricator-input-1" class="rubricator-select">

                                <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">
                                <?
                                //echo "<pre>"; print_r($res); echo "</pre>";?>
                                <div class="rubricator-items">
                                    <?foreach($arMailingRubric as $rubric):?>
                                        <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" id="list[<?=$rubric["ID"]?>]">
                                        <label for="list[<?=$rubric["ID"]?>]"><?=$rubric["UF_NAME"]?></label>
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

                        <?$APPLICATION->IncludeComponent("bitrix:news.list","mailing-template",Array(
                                "AJAX_MODE" => "N",
                                "IBLOCK_TYPE" => "mailing",
                                "IBLOCK_ID" => "16",
                                "NEWS_COUNT" => "9999",
                                "SORT_BY1" => "ACTIVE_FROM",
                                "AR_RUBRICS" => $arMailingRubric,
                                "SORT_ORDER1" => "DESC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "",
                                "FIELD_CODE" => Array("ID"),
                                "PROPERTY_CODE" => Array("RUBRIC", "USERS", "COUNTER"),
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

                        <form class="newsletter__form mailing-archive" action="#">
                            <input type="text" class="newsletter__input input__search" name="mailing-archive-text" placeholder="Искать по названию, дате">
                            <label class="newsletter__search-icon"><svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0807 11.4735L15.7528 17.1456M12.1294 7.12735C12.1294 10.2389 9.60701 12.7613 6.49548 12.7613C3.38396 12.7613 0.861572 10.2389 0.861572 7.12735C0.861572 4.01583 3.38396 1.49344 6.49548 1.49344C9.60701 1.49344 12.1294 4.01583 12.1294 7.12735Z" stroke="#828282" stroke-width="1.5" stroke-linecap="round" /></svg>
                            </label>


                            <?/*<label for="rubricator-input-3" class="rubricator-select">

                                <input type="radio" name="list" value="not_changed" id="rubricator-input-3" class="rubricator-input">
                                <?
                                //echo "<pre>"; print_r($res); echo "</pre>";?>
                                <div class="rubricator-items">
                                    <?foreach($arMailingRubric as $rubric):?>
                                        <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" id="list[<?=$rubric["ID"]?>1]">
                                        <label for="list[<?=$rubric["ID"]?>1]"><?=$rubric["UF_NAME"]?></label>
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
                                </div>
                                <div class="rubricator-title"><?=$rubricCheckName?></div>
                                <input type="hidden" class="rubricator-input" name="list" value="">
                            </div>
                        </form>

                        <?
                        $GLOBALS['arrFilterArchive'] = array('!DATE_ACTIVE_TO' => false);
                        $APPLICATION->IncludeComponent("deus:news.list","mailing-archive",Array(
                                "AJAX_MODE" => "N",
                                "IBLOCK_TYPE" => "mailing",
                                "IBLOCK_ID" => "15",
                                "NEWS_COUNT" => "9999",
                                "SORT_BY1" => "ACTIVE_FROM",
                                "AR_RUBRICS" => $arMailingRubric,
                                "SORT_ORDER1" => "DESC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "CHECK_ACTIVE" => "N",
                                "FILTER_NAME" => "arrFilterArchive",
                                "FIELD_CODE" => Array("ID","DATE_ACTIVE_TO"),
                                "PROPERTY_CODE" => Array("RUBRIC", "USERS", "COUNTER"),
                                "CHECK_DATES" => "N",
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


                    <a class="link link-button write_mail_users" href="/admin/subscribe/mailer/send/">Перейти в форму рассылки</a>
                </div>

            </div>
        </div>
    </div>
    </div>
</main>


<div id="save-audience" class="save-audience">
    <div class="save-audience__title">Аудитория № <?=getNextCounter(17)?></div>
    <?/*<div class="save-audience__rubricator">Рубрикатор</div>*/?>
    <form action="" class="save-audience__form">
    	<input type="hidden" name="name-audience" value="Аудитория № <?=getNextCounter(17)?>">
        <textarea class="save-audience__textarea" name="prev-text" placeholder="Описание аудитории..."></textarea>
        <textarea name="audience-users" style="display: none;"></textarea>
        <div class="save-audience__btns">
            <button type="submit" class="link link-button" href="#">Сохранить</a>
                <button type="submit" class="link link-button link-button--cansel" href="#">Отменить <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg></a>
        </div>
    </form>
</div>




<div id="success-delete-popup">
    <div class="success-delete-popup-text">
        Вы действительно хотите удалить элемент?
        <a class="success-delete-popup-btn">
            <div class="button-green">
                Да
            </div>
        </a>
    </div>
</div>


<?$APPLICATION->IncludeComponent("bitrix:news.list","popup-select-audience",Array(
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "mailing",
        "IBLOCK_ID" => "17",
        "NEWS_COUNT" => "9999",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "",
        "FIELD_CODE" => Array("ID"),
        "PROPERTY_CODE" => Array("COUNTER"),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
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

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>