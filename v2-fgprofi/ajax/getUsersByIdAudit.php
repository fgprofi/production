<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;
    if (CModule::IncludeModule("iblock")) {
        //echo "<pre>"; print_r($arData); echo "</pre>";
        if($arData["users"]){
            $arDataUsers = explode(",",$arData["users"]);
        }
        $arSelect = Array("ID", "NAME","IBLOCK_ID", "PROPERTY_USERS","PROPERTY_CATEGORY_USERS");
        $arFilter = Array("IBLOCK_ID"=>17, "ID"=>$arData["audit"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($ob = $res->GetNextElement())
        {
            $el = $ob->GetFields();
            $el["PROPERTIES"] = $ob->GetProperties();
            $arUsers = array_merge($el["PROPERTIES"]["USERS"]["VALUE"],$arDataUsers);
            $resultUsers = array_unique($arUsers);
            $arResultUsers = getUsers($resultUsers);
            echo json_encode($arResultUsers, 1);
            //echo "<pre>"; print_r($arResultUsers); echo "</pre>";
        }
        
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>