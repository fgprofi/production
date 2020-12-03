<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); 
$arMailingRubric = getMailingRubric();

if($_REQUEST["select_users"] && $_REQUEST["select_users"] != ""){
    $arUser = trim($_REQUEST["select_users"], ",");
    $arUser = explode(",", $arUser);
    $arUsers = getUsers($arUser);
}
$strUser = "";
$strUserEmails = "";
foreach ($arUsers as $user) {
    $strUser .= $user["NAME"].",";
    $strUserEmails .= $user["EMAIL"].",";
}
$strUser = trim($strUser, ",");
$strUserEmails = trim($strUserEmails, ",");
if(strlen($strUser)>47){
    $strUser = substr($strUser, 0, 47);
    $strUser .= "..."; 
}


?>
<?//echo "<pre>"; print_r($_REQUEST["select_users"]); echo "</pre>";?>
<main class="main main--snow">
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
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/audience/">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/#template">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/#history">Архив рассылок</a>
                        </div>
                    </li>


                    <li class="sidebar__item ">
                        <a class="sidebar__link logout_href" href="#">Выход</a>
                    </li>
                </ul>
            </div>*/?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
            <div class="main-content newsletter-write">

                <div class="newsletter__title">
                    <div class="newsletter__title-heading">Рассылка № <span class="newsletter__num"><?=getNextCounter(15)?></span></div>
                    <a class="link link-button link-button--transparent fancybox-popup__link" href="#audience-popup" rel="tofollow">Выбрать из аудитории</a>
                </div>

                <form class="newsletter__form" method="POST" action="/admin/subscribe/mailer/send/success/">
                    <input type="hidden" name="count" value="<?=getNextCounter(15, false)?>">
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label newsletter__form-label--whom">Кому: <span><?=$strUser?></span></label>
                        <div class="newsletter__form-whom-edit">
                            <?foreach($arUsers as $user):?>
                                <div class="newsletter__form-whom-edit-item"><?=$user["NAME"]?></div>
                            <?endforeach;?>
                        </div>
                        <textarea name="users" style="display: none;"><?=implode(",", $arUser)?></textarea>
                        <textarea name="emails" style="display: none;"><?=$strUserEmails?></textarea>
                        <input type="text" class="newsletter__form-input newsletter__form--whom">
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label">Заголовок: </label>
                        <input type="text" name="title-mail" class="newsletter__form-input newsletter__form--title" placeholder="введите текст">
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        

                        <label for="rubricator-input-1" class="rubricator-select">
                            <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">
                            <div class="rubricator-items">
                                <?foreach($arMailingRubric as $rubric):?>
                                    <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" id="list[<?=$rubric["ID"]?>]">
                                    <label for="list[<?=$rubric["ID"]?>]"><?=$rubric["UF_NAME"]?></label>
                                <?endforeach;?>
                                <span class="rubricator-title">Выберите тему письма</span>
                            </div>
                        </label>

                    </div>
                    <div class="newsletter__form-group newsletter__form-group--message">
                        <?/*<div class="newsletter__form-message">
                            <div class="newsletter__form-message-title">Сообщение</div>
                            <div class="textarea-edit">
                                <div class="textarea-edit__bold textarea-edit__item">B</div>
                                <div class="textarea-edit__italic textarea-edit__item">i</div>
                                <div class="textarea-edit__under textarea-edit__item">U</div>
                                <div class="textarea-edit__qoute textarea-edit__item">Цитата</div>
                                <div class="textarea-edit__code textarea-edit__item">Код</div>
                            </div>
                        </div>
                        <textarea class="newsletter__form-textarea" placeholder="Введите текст сообщения"></textarea>*/
                        $name = 'TEXT_MAIL';
                        $id = preg_replace("/[^a-z0-9]/i", '', $name);
                        $LHE = new CLightHTMLEditor;
                        $LHE->Show(array(
                            'id' => $id,
                            'width' => '100%',
                            'height' => '400px',
                            'inputName' => $name,
                            'content' => '',
                            'bUseFileDialogs' => true,
                            'bFloatingToolbar' => true,
                            'bArisingToolbar' => true,
                            'toolbarConfig' => array(
                                'Bold', 'Italic', 'Underline', 'RemoveFormat',
                                'CreateLink', 'DeleteLink', 'Image', 'Video',
                                'BackColor', 'ForeColor',
                                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
                                'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
                                'StyleList', 'HeaderList',
                                'FontList', 'FontSizeList', 'BBCode',
                            ),
                        ));

                        ?>
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--file">
                        <div class="newsletter__form-file">
                            <img src="/bitrix/templates/pakk/img/upload-file.svg" alt="Загрузить" class="newsletter__form-file-img">
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