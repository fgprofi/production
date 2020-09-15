<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// function randSubdivision($arSubdivision){
//     do{
//         $rand = randString(3, array("0123456789"));
//         //echo $rand."<br>";
//     }while($arSubdivision[$rand]);
//     return $rand;
// }
if (isset($_REQUEST)) {
    $arData = $_REQUEST;
    //echo "<pre>"; print_r($_REQUEST); echo "</pre>";
    if (CModule::IncludeModule("iblock") && $arData["OGRN"] != "") {
        $resSubDiv = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>8), false, false, array("ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_SUBDIVISION","PROPERTY_OGRN"));
        $arIsRand = array();
        while($arResSubDiv = $resSubDiv->Fetch()){
            $arIsRand[$arResSubDiv["PROPERTY_SUBDIVISION_VALUE"]] = $arResSubDiv["PROPERTY_SUBDIVISION_VALUE"];
        }
        // for ($i=0; $i < 1000; $i++) { 
        //     $arIsRand[$i] = $i;
        // }
        //echo "<pre>"; print_r($arIsRand); echo "</pre>";
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_SUBDIVISION","PROPERTY_OGRN");
        $arFilter = Array("IBLOCK_ID"=>8);
        //$arFilter["PROPERTY_SUBDIVISION"] = false;
        $arFilter["PROPERTY_OGRN"] = $arData["OGRN"];
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $rand = "";
        if($ob = $res->Fetch())
        {
            $rand = randSubdivision($arIsRand);
        }
        echo $rand;
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>