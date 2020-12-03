<?

if(isset($arParams["ACCOUNT_TABS"][$arResult["IBLOCK_ID"]])){
    $arTabs = array();
    $arHiddenProp = explode(",", $arResult["PROPERTIES"]["HIDDEN_VIEW"]["VALUE"]);
    foreach ($arParams["ACCOUNT_TABS"][$arResult["IBLOCK_ID"]] as $nameTab => $arPropTab) {
        
        $tabPropVal = array();
        $tab = array();
        foreach ($arPropTab as $propTab) {
            if(isset($arResult["DISPLAY_PROPERTIES"][$propTab]["~VALUE"]) && $arResult["DISPLAY_PROPERTIES"][$propTab]["~VALUE"] != "" && !in_array($arResult["DISPLAY_PROPERTIES"][$propTab]["ID"], $arHiddenProp)){
                if($arResult["DISPLAY_PROPERTIES"][$propTab]["LINK_IBLOCK_ID"] != 0){
                    foreach ($arResult["DISPLAY_PROPERTIES"][$propTab]["LINK_ELEMENT_VALUE"] as $linkValueProp) {
                        $tabPropVal[$arResult["DISPLAY_PROPERTIES"][$propTab]["NAME"]][] = $linkValueProp["NAME"]; 
                    }
                }else{
                    $tabPropVal[$arResult["DISPLAY_PROPERTIES"][$propTab]["NAME"]] = $arResult["DISPLAY_PROPERTIES"][$propTab]["~VALUE"]; 
                }
            }
        }
        if(!empty($tabPropVal)){
            $tab["PROPS"] = $tabPropVal;
            $tab["NAME"] = $nameTab;
            $arTabs[] = $tab;
        }
    }
    $arResult["TABS"] = $arTabs;
}
// global $USER;
// if ($USER->IsAdmin()){
//     echo "<pre>"; print_r($arUser); echo "</pre>";
//     echo "<pre>"; print_r($arParams["USER_PROP"]); echo "</pre>";
// }

?>