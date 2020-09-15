<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){

	if(CModule::IncludeModule("iblock")){
		$properties = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>7, "ID" =>(int)$_REQUEST['id']));
		if($data = $properties->Fetch()){
			echo json_encode($data);
		}
		
	}
}