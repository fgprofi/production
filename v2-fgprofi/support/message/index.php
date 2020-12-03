<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Уведомления");
?>
<?
/*CModule::IncludeModule('support');
function GetMessages($ticketID, $arFilter = array(), $checkRights = "Y")
{
    $arFilter["TICKET_ID"] = $ticketID;
    $arFilter["TICKET_ID_EXACT_MATCH"] = "Y";
    $is_filtered = null;
    $by = "s_id";
    $order = "asc";
    return CTicket::GetMessageList($by, $order, $arFilter, $is_filtered, $checkRights, "Y");
}
global $USER;

$arMessType = array(
    "TICKET" => "Техническая поддержка",
);

$arFilter = array(
    "OWNER" => $USER->getID(),
    "!LAST_MESSAGE_BY_SUPPORT_TEAM" => "Y",
);
$rs = CTicket::GetList(
    $by="ID", 
    $order="asc",
    $arFilter,
    $isFiltered,
    "Y",
    "Y",
    "Y",
    false,
    Array("SELECT" => array("UF_*" ))
);

while($ar = $rs->Fetch()) 
{
    $rsOnline = CTicket::GetOnline(intval($ar["ID"]));
    while ($arOnline = $rsOnline->GetNext())
    {
        $arOnline["INT_TIMESTAMP_X"] = MakeTimeStamp($arOnline["TIMESTAMP_X"]);
        $ar["ONLINE"][$arOnline["USER_ID"]] = $arOnline;
    }
    $ar["TYPE"] = "TICKET";
    //echo '<pre>';print_r($ar["ONLINE"]);echo '</pre>';
    $obMessages = GetMessages($ar["ID"], array(), "Y");
    while($arMessage = $obMessages->Fetch()){
        $arMessage["INT_TIMESTAMP_X"] = MakeTimeStamp($arMessage["TIMESTAMP_X"]);
        $arMessages[] = $arMessage;
    }
    $lastMess = array_pop($arMessages);
    //echo '<pre>';print_r($lastMess);echo '</pre>';
    if(!isset($ar["ONLINE"][$USER->getID()]) || $ar["ONLINE"][$USER->getID()]["INT_TIMESTAMP_X"] < $lastMess["INT_TIMESTAMP_X"]){
        
        $stringMess = strip_tags($lastMess["MESSAGE"]);
        if(strlen($stringMess) > 152){
            $stringMess = mb_substr($stringMess,0,152,'UTF-8');
            $stringMess = rtrim($stringMess, "!,.-");
            $stringMess = substr($stringMess, 0, strrpos($stringMess, ' '));
            $stringMess = $stringMess."...";
        }
        $ar["MESS"] = $stringMess;
        $arResult["MESSAGE"][] = $ar;
    }
}*/

//echo '<pre>';print_r($arResult);echo '</pre>';
?>
<main class="main main--snow">
    <div class="content">
        <div class="containered">
            <?/*<div class="sidebar">
                <div class="sidebar__name">Мой профиль</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/personal/edit/">Настройки</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link" href="/personal-lk/communication/">Общение</a>
                    </li>
                    <li class="sidebar__item li_count_message active">
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
            </div>*/?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>




            <?$APPLICATION->IncludeComponent("deus:unread.messages", "", Array(
                "TITLE_TYPE_MESS" => array(
                    "TICKET" => "Техническая поддержка",
                    "MAILING" => "Рассылка",
                ),
                "DEBUG" => "Y"
            ));?>




        </div>
    </div>
</main>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>