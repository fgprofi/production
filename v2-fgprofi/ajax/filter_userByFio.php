<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;


    if (CModule::IncludeModule("iblock")) {
        $arParams = array(
            "TYPE_F" => 7,
            "TYPE_U" => 8,
        );
        
        $search = $arData["search"];
        $searchProp = array("SURNAME", "FIRST_NAME", "MIDDLENAME", "EMAIL"/*, "PHONE"*/);

        $iblock_id = $arParams[$arData["ib"]];

        // $arFilter = array( 
        //   "ACTIVE" => "Y"
        // );

        // $rsProperty = CIBlock::GetProperties(
        //     $iblock_id,
        //     array(),
        //     $arFilter
        // );

        // while($element = $rsProperty->Fetch())
        // {
        //     $arResult["PROPERTY"][$element["CODE"]] = $element["ID"];
        //     echo "<pre>"; print_r($element); echo "</pre>";
        // }


        // $pos = strpos($search, "+7");
        // //echo $pos;
        // if($pos == 0){
        //     $arSearch[] = $search;
        // }else{
            $arSearch = explode(" ", $search);
        //}
        $arSearch = array_filter($arSearch);
        $logicFio["LOGIC"] = "OR";
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_HIDDEN_VIEW");
        foreach ($searchProp as $key => $fioProp) {
            $fioProp = "PROPERTY_".$fioProp;
            foreach ($arSearch as $value) {
                $logicFio[] = array($fioProp => "%".$value."%");
            }
            $searchPropSelect[] = $fioProp;
        }
        
        $arFilter = Array("IBLOCK_ID" => $iblock_id, "ACTIVE"=>"Y");
        // if($pos == 0){
        //     $logicFio[] = array("PROPERTY_PHONE" => $value."%");
        // }else{
            $arFilter[] = $logicFio;
        //}
        $arSelect = array_merge($arSelect, $searchPropSelect);
        // echo "<pre>"; print_r($arSelect); echo "</pre>";
        // echo "<pre>"; print_r($arFilter); echo "</pre>";
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $str = "";
        $i = 0;
        $arProp = array();
        while ($arRes = $res->Fetch()) {
            if($i == 0){
               foreach ($searchProp as $key => $value) {
                    $arDataProp = explode(":",$arRes["PROPERTY_".$value."_VALUE_ID"]);
                    $arProp["PROPERTY_".$value."_VALUE"] = $arDataProp[1];
                } 
            }
            
            $hiddenView = explode(",", $arRes["PROPERTY_HIDDEN_VIEW_VALUE"]);
            //echo "<pre>"; print_r($hiddenView); echo "</pre>";
            $error = true;
            foreach($arProp as $codeProp => $dataProp){
                if(!in_array($dataProp, $hiddenView)){
                    foreach ($arSearch as $search) {
                        $pos = stripos($arRes[$codeProp], $search);
                        if($pos !== false){
                            $error = false;
                        }
                    }
                }
            }
            if(!$error){
                //$arResult[] = $arRes;
                $str .= $arRes["ID"].",";
            }
            $i++;
        }
        $str = trim($str, ",");
        if($str == ""){
            $str = "0";
        }
        echo $str;
        //echo json_encode($arResult, 1);
        //echo "<pre>"; print_r($arResult); echo "</pre>";
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>