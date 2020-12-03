<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$arRequiredFields = array(
    "name" => "Введите имя",
    //"phone" => "Введите Телефон",
    "email" => "Введите Email",
    "text_mail" => "Введите Текст сообщения",
    "theme" => "Введите Заголовок",
    "list" => "Выберите Тему",
);
if (isset($_REQUEST)) {
    $arData = $_REQUEST;
    
    global $USER;
    $arDataRes['user_id'] = $USER->getID();
    $arDataRes['name'] = trim(strip_tags(htmlspecialcharsBack($arData['name'])));
    $arDataRes['phone'] = trim(strip_tags(htmlspecialcharsBack($arData['phone'])));
    $arDataRes['email'] = trim(strip_tags(htmlspecialcharsBack($arData['email'])));
    $arDataRes['text_mail'] = trim(strip_tags(htmlspecialcharsBack($arData['text_mail'])));
    $arDataRes['theme'] = trim(strip_tags(htmlspecialcharsBack($arData['theme'])));
    $arDataRes['list'] = trim(strip_tags(htmlspecialcharsBack($arData['list'])));
    $errorStr = "";
    foreach ($arRequiredFields as $reqField => $error) {
        if(!isset($arDataRes[$reqField]) || $arDataRes[$reqField] == ""){
            $errorStr .= $error."<br>";
        }
    }
    // echo "<pre>"; print_r($arDataRes); echo "</pre>";
    // die();
    CModule::IncludeModule("support");
    // $arFilter = Array(
    //     "LID" => SITE_ID,
    //     "TYPE" => "C",
    // );

    // $by = "s_sid";
    // $sort = "asc";

    // $rsStatus = CTicketDictionary::GetList($by, $sort, $arFilter, $is_filtered); while($arRes = $rsStatus->GetNext()) {
    //     $arResult[$arRes["SID"]] = $arRes;
    // }
    if($errorStr == ""){
        $arFields = array(
            "TITLE" => $arDataRes['theme'],
            "MESSAGE" => $arDataRes['text_mail'],
            "CATEGORY_SID" => $arDataRes['list'],
            "AUTO_CLOSE_DAYS" => 365,
            "UF_AUTOR_FIO" => $arDataRes['name']
        );
        if($arDataRes['user_id'] != ""){
            $arFields["OWNER_USER_ID"] = $arDataRes['user_id'];
            $arFields["OWNER_SID"] = $arDataRes['user_id'];
        }else{
            $arFields["CREATED_MODULE_NAME"] = "email";
            $arFields["OWNER_SID"] = $arDataRes['email'];
            $arFields["SOURCE_SID"] = "email";
        }
        if($NEW_TICKET_ID = CTicket::Set($arFields, $MESSAGE_ID, $TICKET_ID, "N")){
            echo "1";
        }
    }else{
        echo $errorStr;
    }

} 


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>