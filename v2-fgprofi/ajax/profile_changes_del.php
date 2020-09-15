<?php
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php" );

$event = new reestr\sendMessage();

if ( isset( $_REQUEST ) ) {
	$arData = $_REQUEST;
	// echo "<pre>"; print_r($arData); echo "</pre>";
	// die();
	if ( CModule::IncludeModule( "iblock" ) ) {
		if(isset($arData["id"]) && $arData["id"] != ""){
			$obEl = new CIBlockElement();
			$obEl->SetPropertyValuesEx($arData['id'], $arData["ib"], array('SIGN_OF_USER_DATA_DELETION' => 3));
		}
		
	}
}
