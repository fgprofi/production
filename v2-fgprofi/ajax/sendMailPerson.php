<?php
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;
if ($USER->IsAuthorized()){
	CModule::IncludeModule("iblock");
	CModule::IncludeModule('highloadblock');

	$hlbl = 4;
	$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch(); 

	$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
	$entity_data_class = $entity->getDataClass(); 

	$dataFields = $_REQUEST;
	$dataFields['user_id'] = trim(strip_tags(htmlspecialcharsBack($dataFields['user_id'])));
	$dataFields['ib_id'] = trim(strip_tags(htmlspecialcharsBack($dataFields['ib_id'])));
	$dataFields['theme'] = trim(strip_tags(htmlspecialcharsBack($dataFields['theme'])));
	$dataFields['text_mail'] = trim(strip_tags(htmlspecialcharsBack($dataFields['text_mail'])));

	$arSelect = Array(
		"ID", 
		"IBLOCK_ID", 
		"NAME",
		"PROPERTY_EMAIL"
	);
	$arFilter = Array("IBLOCK_ID"=>$dataFields['ib_id'], "ID"=>$dataFields['user_id']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	if($ob = $res->Fetch()){ 
		$dataFields['USER_INFO'] = $ob;
	}
	if($USER->GetID() == 1){
		$dataFields['THIS_USER_INFO'] = array(
			"NAME" => "Администратор",
			"PROPERTY_EMAIL_VALUE" => "cons@fgprofi.ru",
			"ID" => 1,
		);
	}else{
		$dataFields['THIS_USER'] = needAuth('/auth/', false, true);
		$arFilter = Array("IBLOCK_ID"=>$dataFields['THIS_USER']['IBLOCK_ID'], "ID"=>$dataFields['THIS_USER']['ID_USER_INFO']);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($ob = $res->Fetch()){ 
			$dataFields['THIS_USER_INFO'] = $ob;
		}
	}
	$arEventFields = array(
		"EMAIL"=>$dataFields['USER_INFO']["PROPERTY_EMAIL_VALUE"],
		"THEME"=>$dataFields['theme'],
		"TEXT"=>$dataFields['text_mail'],
		"USER_FROM"=>$dataFields['THIS_USER_INFO']["NAME"],
		"SENDER_EMAIL_FROM"=>$dataFields['THIS_USER_INFO']["PROPERTY_EMAIL_VALUE"],
	);
	$file_id = "";
	if(isset($_FILES["file-download"])){
		$arr_file = Array(
       "name" => $_FILES["file-download"]['name'],
       "size" => $_FILES["file-download"]['size'],
       "tmp_name" => $_FILES["file-download"]['tmp_name'],
       "type" => $_FILES["file-download"]['type'],
       "old_file" => "",
       "del" => "Y",
       "MODULE_ID" => "");
		$file_id = CFile::SaveFile($arr_file, "file-download");
	}
	//echo "<pre>"; print_r($arEventFields); echo "</pre>";
	// echo "<pre>"; print_r($_FILES); echo "</pre>";
	// echo "<pre>"; print_r($arr_file); echo "</pre>";
	//echo "<pre>"; print_r($file_id); echo "</pre>";
	if(CEvent::Send("COMMUNICATION_USERS", "s1", $arEventFields, "Y", "", array($file_id))){
		echo '<div id="success-message" class="success-message"><img src="/bitrix/templates/pakk/img/message-success.png" alt="Отправлено" class="success-message__img"><p class="success-message__text">Письмо успешно отправлено</p></div>';
		$data = array(
			"UF_TITLE"=>'Сообщение от пользователя '.$arEventFields["USER_FROM"].', по теме "'.$arEventFields["THEME"].'"',
			"UF_DATE"=>date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
			"UF_USER_IN"=>$dataFields['USER_INFO']["ID"],
			"UF_USER_OUT"=>$dataFields['THIS_USER_INFO']["ID"],
		);

		$result = $entity_data_class::add($data);
	}
	// if($file_id != ""){
	// 	CFile::Delete($file_id);
	// }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>