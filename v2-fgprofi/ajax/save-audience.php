<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
	if(CModule::IncludeModule("iblock")){ 
		$arUser = trim($arData["audience-users"], ",");
		$arUser = explode(",", $arUser);
		$dataUsers = getUsers($arUser);
		$el = new CIBlockElement;
		$PROP["USERS"] = $arUser;
		$nextCount = getNextCounter(17, false);
		$PROP["COUNTER"] = $nextCount;
		$dateSend = date($DB->DateFormatToPHP(CSite::GetDateFormat()), time());
		$PROP["DATE_CREATE"] = $dateSend;
		$dataCategoryUsers = getCategoryUsers(17);
		$PROP["CATEGORY_USERS"] = $dataCategoryUsers[$dataUsers[0]["IBLOCK_ID"]]["ID"];
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => 1,
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_ID"      => 17,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $arData['name-audience'],
			"PREVIEW_TEXT"   => $arData['prev-text'],
			"ACTIVE"         => "Y",
		);

		$PRODUCT_ID = $el->Add($arLoadProductArray);
		//echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>