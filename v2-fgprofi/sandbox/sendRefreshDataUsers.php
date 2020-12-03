<?
$_SERVER["DOCUMENT_ROOT"] = "/home/c/cc18971/reestr/public_html";
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (CModule::IncludeModule("iblock")) {
	$time = time() - 86400*183;
	$filterDate = date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), $time);
	$arFilter = array(
		"IBLOCK_ID" => array(7),
		"ACTIVE" => "Y",
		"!PROPERTY_PERSONAL_DATA" => false,
		"DATE_MODIFY_TO" => $filterDate
	);
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
	);
	$send_mess = new reestr\sendMessage();
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()){ 
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$arResult["props"] = $arProps;
		$arResult["fields"] = $arFields;
		$arData[$arFields["IBLOCK_ID"]][] = $arFields["NAME"];
		$send_mess->sendRefreshDataUser($arResult);
	}
	//echo "<pre>"; print_r($arData); echo "</pre>";
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>