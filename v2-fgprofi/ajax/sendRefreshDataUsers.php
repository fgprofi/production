<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST["id"]) && count($_REQUEST["id"])>0) {
	if (CModule::IncludeModule("iblock")) {
		$arDataSend = array();
		$arFilter = array(
			"IBLOCK_ID" => array(7),
			"ID" => $_REQUEST["id"]
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
			if($send_mess->sendRefreshDataUser($arResult)){
				$arDataSend[] = $arResult["props"]['SURNAME']['VALUE'].' '.$arResult["props"]['FIRST_NAME']['VALUE'];
			}
		}
		//echo "<pre>"; print_r($arDataSend); echo "</pre>";
		echo json_encode($arDataSend);
	}
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>