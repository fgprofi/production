<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;


    if (CModule::IncludeModule("iblock")) {
        
        $search = $arData["search"];
        $searchProp = array("PROPERTY_SURNAME", "PROPERTY_FIRST_NAME", "PROPERTY_MIDDLENAME");
        $arSearch = explode(" ", $search);
        $arSearch = array_filter($arSearch);
        $logicFio["LOGIC"] = "OR";
        foreach ($searchProp as $key => $fioProp) {
            foreach ($arSearch as $value) {
                $logicFio[] = array($fioProp => "%".$value."%");
            }
        }
        $arSelect = array("ID", "IBLOCK_ID", "NAME");
        $arSelect = array_merge($arSelect, $searchProp);
        $arSelect[] = "PROPERTY_EMAIL";
        $arSearchIb = array(7, 8);
        $arResult = array();
        if(isset($arData["ib"]) && $arData["ib"] != ""){
            $arFilter = Array("IBLOCK_ID" => $arData["ib"], "ACTIVE"=>"Y");
            $arFilter[] = $logicFio;
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($arRes = $res->Fetch()) {
                $arResult[] = $arRes;
            }
        }else{
            foreach ($arSearchIb as $ib) {
                $arFilter = Array("IBLOCK_ID" => $ib, "ACTIVE"=>"Y");
                $arFilter[] = $logicFio;
                $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($arRes = $res->Fetch()) {
                    $arResult[] = $arRes;
                }
            }
        }
        echo json_encode($arResult, 1);
        //echo "<pre>"; print_r($arResult); echo "</pre>";
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>