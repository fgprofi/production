<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Рассылка"); 

if(CModule::IncludeModule("iblock")){
    $categoryUsers = getCategoryUsers(15);
    $allRubric = getMailingRubric();
    $el = new CIBlockElement;
    $users = explode(",", $_REQUEST["users"]);
    $PROP = array();
    $dataUsers = getUsers($users);
    $dateSend = date($DB->DateFormatToPHP(CSite::GetDateFormat()), time());
    $dateActiveFrom = $dateSend;
    if(isset($_REQUEST["date-cron"]) && $_REQUEST["date-cron"] != ""){
        $dateSend = $_REQUEST["date-cron"];
        if(isset($_REQUEST["time-cron"]) && $_REQUEST["time-cron"] != ""){
            $timeSend = $_REQUEST["time-cron"].":00";
        }else{
            $timeSend = "00:00:00";
        }
        $dateSend = $dateSend." ".$timeSend;
    }else{
        $timeNextMinuts = time()+60;
        $dateSend = date($DB->DateFormatToPHP("d.m.Y H:i:s"), $timeNextMinuts);
    }
    // echo "<pre>"; print_r($dateSend); echo "</pre>";
    // die();
    $PROP["RUBRIC"] = $_REQUEST["list"];
    $PROP["USERS"] = $users;
    $PROP["COUNTER"] = $_REQUEST["count"];
    $PROP["DATE_SEND"] = $dateSend;
    $PROP["CUSTOM_EMAILS"] = $_REQUEST["custom-mail"];
    if(isset($_REQUEST["FILE_UPLOAD"]) && $_REQUEST["FILE_UPLOAD"] != ""){
        $copyFile = CFile::CopyFile($_REQUEST["FILE_UPLOAD"]);
        $PROP["FILE"] = $copyFile; 
    }
    $PROP["TEMPL"] = $_REQUEST["load_template"];
    $PROP["AUDIT"] = $_REQUEST["load_audit"];
    $PROP["CATEGORY_USERS"] = $categoryUsers[$dataUsers[0]["IBLOCK_ID"]]["ID"];
    
    //echo "<pre>"; print_r($dataUsers); echo "</pre>";
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => 1,
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"      => 15,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_REQUEST["title-mail"],
        "ACTIVE"         => "Y",
        "DATE_ACTIVE_FROM" => $dateSend,
        "DETAIL_TEXT"    => $_REQUEST["TEXT_MAIL"],
        "DETAIL_TEXT_TYPE" => 'html'
    );
    //echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
    $emails = explode(",", $_REQUEST["emails"]);
    if($PRODUCT_ID = $el->Add($arLoadProductArray)){
        // foreach ($emails as $mail) {
        //     $arEventFields = array(
        //         "EMAIL_TO"=>$mail,
        //         "THEME"=>$_REQUEST["title-mail"],
        //         "RUBRIC"=>$allRubric[$_REQUEST["list"]]["UF_NAME"],
        //         "TEXT"=>$_REQUEST["TEXT_MAIL"]
        //     );
        //     //echo "<pre>"; print_r($arEventFields); echo "</pre>";
        //     if(CEvent::Send("SEND_MAILING", "s1", $arEventFields)/*true*/){
        //         //echo "Отправили рассылку на ".$mail."<br>";
        //         $arLoadProductArray = Array(
        //             "DATE_ACTIVE_TO"    => date($DB->DateFormatToPHP(CSite::GetDateFormat()), time()),
        //         );
        //         //echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
        //         if($el->Update($result["FIELDS"]["ID"], $arLoadProductArray)){
        //             //echo "Обновили рассылку<br>";
        //             header("Refresh: 0;");
        //         }
        //     }
        // }
    }
}
//echo "<pre>"; print_r($arRubrics); echo "</pre>";?>
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
                    <div class="newsletter__title-heading">Рассылка создана</div>
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