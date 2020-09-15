<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
	if(CModule::IncludeModule("iblock")){ 
		//echo "<pre>"; print_r($arData); echo "</pre>";
		if(isset($arData["id"]) && $arData["id"] != ""){
			CIBlockElement::Delete($arData["id"]);
		}
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>