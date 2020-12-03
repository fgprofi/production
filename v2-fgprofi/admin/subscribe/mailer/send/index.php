<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); 
$arMailingRubric = getMailingRubric();
//echo "<pre>"; print_r($arMailingRubric); echo "</pre>";
global $DB;
if($_REQUEST["select_users"] && $_REQUEST["select_users"] != ""){
    $arUser = trim($_REQUEST["select_users"], ",");
    $arUser = explode(",", $arUser);
    $arUsers = getUsers($arUser);
}
$strUser = "";
$strUserEmails = "";
$strTitle = "";
$rubricXMLID = "";
$mailText = "";
$file = "";
$loadIb = "";
$customEmails = "";
$startIb = "";
if($_REQUEST["load_id"] && $_REQUEST["load_id"] != ""){
    $res = CIBlockElement::GetByID($_REQUEST["load_id"]);
    if($ar_res = $res->GetNext()){
        $arUser = array();
        $loadIb = $ar_res["IBLOCK_ID"]; 
        // $db_props = CIBlockElement::GetPropertyValues($ar_res["IBLOCK_ID"], array("ID"=>$ar_res["ID"]), false, Array("CODE"=>"USERS"));
        // while($ar_props = $db_props->Fetch()){
        //     $arLoadProps[$ar_props["CODE"]][] = $ar_props["VALUE"];
        // }
        $arSelect = Array("ID", "NAME", "IBLOCK_ID", "DATE_ACTIVE_FROM");
        $arFilter = Array("IBLOCK_ID"=>$ar_res["IBLOCK_ID"], "ID"=>$ar_res["ID"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($ob = $res->GetNextElement())
        {
            $arProps = $ob->GetProperties();
            foreach ($arProps as $prCode => $prValue) {
                $arLoadProps[$prCode] = $prValue["VALUE"];
            }
            
            //echo "<pre>"; print_r($arProps); echo "</pre>";
        }
        //echo "<pre>"; print_r($arLoadProps); echo "</pre>";
        if(isset($arLoadProps["USERS"]) && count($arLoadProps["USERS"])>0){
            $arUser = $arLoadProps["USERS"];
            $res = CIBlockElement::GetByID($arUser[0]);
            if($arResFirstUser = $res->GetNext()){
                $startIb = $arResFirstUser["IBLOCK_ID"];
            }
        }

        if(isset($ar_res["NAME"]) && $ar_res["NAME"]!="" && $ar_res["IBLOCK_ID"]==15){
            $strTitle = $ar_res["NAME"];
        }
        if(isset($arLoadProps["TITLE"]) && $arLoadProps["TITLE"]!="" && $ar_res["IBLOCK_ID"]!=15){
            $strTitle = $arLoadProps["TITLE"];
        }
        if(isset($arLoadProps["CUSTOM_EMAILS"]["TEXT"]) && $arLoadProps["CUSTOM_EMAILS"][0]["TEXT"]!=""){
            $customEmails = $arLoadProps["CUSTOM_EMAILS"]["TEXT"];
        }
        if(isset($arLoadProps["RUBRIC"]) && count($arLoadProps["RUBRIC"])>0){
            $rubricXMLID = $arLoadProps["RUBRIC"];
        }
        if(isset($arLoadProps["FILE"]) && $arLoadProps["FILE"] !=""){
            $file = $arLoadProps["FILE"];
        }
        if(isset($ar_res["DETAIL_TEXT"]) && $ar_res["DETAIL_TEXT"]!=""){
            $mailText = $ar_res["DETAIL_TEXT"];
        }
        //echo "<pre>"; print_r($arLoadProps); echo "</pre>";
    }else{
        header('Location: /admin/subscribe/mailer/');
    }
    $arUsers = getUsers($arUser);
}



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
<?//echo "<pre>"; print_r($arUsers); echo "</pre>";?>
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
            <div class="main-content newsletter-write">

                <div class="newsletter__title">
                    <div class="newsletter__title-heading">Рассылка № <span class="newsletter__num"><?=getNextCounter(15)?></span></div>
                    <a class="link link-button link-button--transparent fancybox-popup__link" href="#audience-popup" rel="tofollow">Выбрать из аудитории</a>
                </div>

                <form class="newsletter__form on_before_submit_mailer"  method="POST" action="/admin/subscribe/mailer/send/success/">
                    <input type="hidden" name="count" value="<?=getNextCounter(15, false)?>">
                    <?if($loadIb != ""):?>
                        <?if($loadIb == 17):?>
                            <input type="hidden" name="load_audit" value="<?=$_REQUEST["load_id"]?>">
                        <?endif;?>
                        <?if($loadIb == 16):?>
                            <input type="hidden" name="load_template" value="<?=$_REQUEST["load_id"]?>">
                        <?endif;?>
                    <?endif;?>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label newsletter__form-label--whom">Кому: <span><?=$strUser?></span></label>
                        <div class="newsletter__form-whom-edit">
                            <?foreach($arUsers as $user):?>
                                <div class="newsletter__form-whom-edit-item" data-user-id="<?=$user["ID"]?>" data-user-email="<?=$user["EMAIL"]?>"><?=$user["NAME"]?></div>
                            <?endforeach;?>
                        </div>
                        <textarea name="users" style="display: none;"><?=implode(",", $arUser)?></textarea>
                        <textarea name="emails" style="display: none;"><?=$strUserEmails?></textarea>
                        <input type="hidden" name="users_ib" value="<?=$startIb?>">
                        <?/*<input type="text" class="newsletter__form-input newsletter__form--whom" name="users_search" value="<?//=$customEmails?>">*/?>
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        <label class="newsletter__form-label">Заголовок: </label>
                        <input type="text" name="title-mail" class="newsletter__form-input newsletter__form--title" value="<?=$strTitle?>" placeholder="введите текст">
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--flex">
                        

                        <?/*<label for="rubricator-input-1" class="rubricator-select">
                            <input type="radio" name="list" value="not_changed" id="rubricator-input-1" class="rubricator-input">
                            <div class="rubricator-items">
                                <?foreach($arMailingRubric as $rubric):?>
                                    <?$rubricCheck = "";
                                    if($rubric["UF_XML_ID"] == $rubricXMLID){
                                        $rubricCheck = "checked";
                                    }?>
                                    <input type="radio" name="list" value="<?=$rubric["UF_XML_ID"]?>" <?=$rubricCheck?> id="list[<?=$rubric["ID"]?>]">
                                    <label for="list[<?=$rubric["ID"]?>]"><?=$rubric["UF_NAME"]?></label>
                                <?endforeach;?>
                                <span class="rubricator-title">Выберите тему письма</span>
                            </div>
                        </label>*/?>
                        <div class="rubricator-select">
                            <div class="rubricator-items">
                                <?//echo "<pre>"; print_r($rubricXMLID); echo "</pre>";?>
                                <?
                                $rubricCheck = "";
                                $rubricCheckName = "Выберите тему письма";
                                foreach($arMailingRubric as $rubric):?>
                                    <?//echo "<pre>"; print_r($rubric); echo "</pre>";?>
                                    <?if($rubric["UF_XML_ID"] == $rubricXMLID){
                                        $rubricCheck = $rubric["UF_XML_ID"];
                                        $rubricCheckName = $rubric["UF_NAME"];
                                    }?>
                                    <div data-value='<?=$rubric["UF_XML_ID"]?>' class="rubricator-items__option"><?=$rubric["UF_NAME"]?></div>
                                <?endforeach;?>
                            </div>
                            <div class="rubricator-title"><?=$rubricCheckName?></div>
                            <input type="hidden" class="rubricator-input" name="list" value="<?=$rubricCheck?>">
                        </div>
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
                            'content' => $mailText,
                            'bUseFileDialogs' => true,
                            'bFloatingToolbar' => true,
                            'bArisingToolbar' => true,
                            'toolbarConfig' => array(/* кнопки редактирования */
	                            'Bold', 'Italic', 'Underline', 'RemoveFormat', 'Source', 'Video',
	                            'CreateLink', 'DeleteLink', 'Image', 'Video',
	                            'BackColor', 'ForeColor',
	                            'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
	                            'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
	                            'StyleList', 'HeaderList',
	                            'FontList', 'FontSizeList','Table','Html',
                            ),
                        ));

                        ?>
                    </div>
                    <div class="newsletter__form-group newsletter__form-group--file">
                        <div class="newsletter__form-file <?if($file != ''){echo 'active';}?>">
                            
                            <div class="start-title-file">
                                <img src="/bitrix/templates/pakk/img/upload-file.svg" alt="Загрузить" class="newsletter__form-file-img">
                                Прикрепить файл
                                <span>максимальный вес файла 300 кб</span>
                            </div>
                            <div class="change-title-file">
                                <img src="/bitrix/templates/pakk/img/upload-file.svg" alt="Загрузить" class="newsletter__form-file-img">
                                <span></span>
                            </div>
                        </div>
                        <div class="form-file-wrap" <?if($file != ''){echo 'style="display:block;"';}?>>
                            <?
                            $APPLICATION->IncludeComponent( "bitrix:main.file.input", "file",
                                array(
                                    "INPUT_NAME"       => "FILE_UPLOAD",
                                    "MULTIPLE"         => "N",
                                    "MODULE_ID"        => "iblock",
                                    "MAX_FILE_SIZE"    => 300000,
                                    "ALLOW_UPLOAD"     => "F",
                                    "ALLOW_UPLOAD_EXT" => "",
                                    "INPUT_VALUE" => $file
                                ),
                                false
                            ); ?>
                        </div>

                        <div class="newsletter__form-calendar-container">
                            <!-- Если добавить класс .newsletter__form-calendar-wrap--active, то календарь будет активен -->
                            <div class="newsletter__form-calendar-wrap">
                                <div class="newsletter__form-calendar"></div>
                            </div>
                            <div class="newsletter__form-calendar-popup">
                                <div class="datepicker-cron" style="display: none;"></div>
                                Отправить письмо <span class="green-pointer select-time-open">сейчас</span>
                                <span class="select-time">
                                    <span class="request-datepicker green-pointer">сегодня</span> в 
                                    <?$dateSend = date($DB->DateFormatToPHP("d.m.Y"), time());?>
                                    <input type="hidden" name="date-cron" disabled="disabled" value="<?=$dateSend?>">
                                    <input type="text" class="datepicker-cron-time green-pointer" disabled="disabled" name="time-cron" value="00:00">
                                    <span class="select-time-close">×</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="newsletter__form-btns">
                        <button type="submit" class="link link-button">Отправить</button>
                        <?/*<button class="link link-button link-button--transparent">Сохранить как шаблон</button>*/?>
                        <a href="#save-template" rel="nofollow" class="link link-button link-button--transparent fancybox-popup__link save-template-popup">Сохранить как шаблон</a>
                        <button class="link link-button link-button--cansel">Сбросить<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 24 24">
                                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                            </svg></button>
                        <?if($loadIb == 14):?>
                            <!-- Если добавить класс .newsletter__form-trash-wrap--active, то корзина будет активна -->
                            <div class="newsletter__form-trash-wrap" data-id="<?=$_REQUEST["load_id"]?>" data-back="true">
                                <div class="newsletter__form-trash"></div>
                            </div>
                            <div id="success-delete-popup" data-back="true">
                                <div class="success-delete-popup-text">
                                    Вы действительно хотите удалить элемент?
                                    <a class="success-delete-popup-btn">
                                        <div class="button-green">
                                            Да
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?endif;?>
                    </div>
                </form>






            </div>
        </div>
    </div>
    </div>
</main>
<div id="save-template" class="save-template">
    <div class="save-template__title">Шаблон № <?=getNextCounter(16)?></div>
    <?/*<div class="save-audience__rubricator">Рубрикатор</div>*/?>
    <form action="" class="save-template__form">
        <input type="hidden" name="name-template" value="Шаблон № <?=getNextCounter(16)?>">
        <textarea class="save-template__textarea" name="prev-text" placeholder="Описание шаблона..."></textarea>
        <div class="save-template__btns">
            <button type="submit" class="link link-button" href="#">Сохранить</button>
            <button type="submit" class="link link-button link-button--cansel" href="#">Отменить <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg></button>
        </div>
    </form>
</div>
<?/*<div id="audience-popup" class="audience-popup">
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
</div>*/?>
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