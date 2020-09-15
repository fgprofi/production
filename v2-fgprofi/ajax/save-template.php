<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
	if(CModule::IncludeModule("iblock")){ 
		$arUser = trim($arData["users"], ",");
		$arUser = explode(",", $arUser);
		$dataUsers = getUsers($arUser);
		$el = new CIBlockElement;
		$PROP["USERS"] = $arUser;
		$nextCount = getNextCounter(16, false);
		$PROP["COUNTER"] = $nextCount;
		// $dateSend = date($DB->DateFormatToPHP(CSite::GetDateFormat()), time());
		// $PROP["DATE_CREATE"] = $dateSend;
		$dataCategoryUsers = getCategoryUsers(16);
		$PROP["RUBRIC"] = $arData["list"];
		$PROP["TITLE"] = $arData["title-mail"];
		$PROP["CATEGORY_USERS"] = $dataCategoryUsers[$dataUsers[0]["IBLOCK_ID"]]["ID"];
		$PROP["CUSTOM_EMAILS"] = $arData["custom-mail"];
		if(isset($arData["FILE_UPLOAD"]) && $arData["FILE_UPLOAD"] != ""){
			$PROP["FILE"] = $arData["FILE_UPLOAD"];
		}
		
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => 1,
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_ID"      => 16,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $arData['name-template'],
			"PREVIEW_TEXT"   => $arData['prev-text'],
			"DETAIL_TEXT"   => $arData['TEXT_MAIL'],
			"ACTIVE"         => "Y",
			"DETAIL_TEXT_TYPE" => 'html'
		);

		if($PRODUCT_ID = $el->Add($arLoadProductArray)){
			echo $PRODUCT_ID;
		}
		// echo "1";
		// echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
		// echo "<pre>"; print_r($arMailRubrics); echo "</pre>";
		//echo "<pre>"; print_r($arData); echo "</pre>";
		//CFile::Delete($arData["FILE_UPLOAD"]);
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>