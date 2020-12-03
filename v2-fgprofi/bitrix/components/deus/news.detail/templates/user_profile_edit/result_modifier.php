<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//проверяем разрешение на вход пользователю
if(!isAdministrator()){
	if($arResult['ACTIVE'] != 'Y' || $arResult["PROPERTIES"]['SIGN_OF_USER_DATA_DELETION']['VALUE'] == 3){
		LocalRedirect('/personal/', 301);
	}
}
//подключаем highload
$HLWorker = new reestr\HLWorker();
$HL_table = $HLWorker->init($arParams['HBL_SETTING']);
$fieldsHL = $HLWorker->getDataFromHL($HL_table,array(),array('UF_*'));
$sorted_fields = array();
foreach($fieldsHL as $one){
	$sorted_fields[$one['UF_CODE']] = $one;
}
$filed_types = $HLWorker->getFiledTypes();

foreach($arResult["PROPERTIES"] as &$prop){
	if(in_array($prop['CODE'], $arParams["FIELDS_GROOP_USER"]["PROPERTY_ONLY_ADMIN"]) && !isAdministrator()){
	    continue;
	}
	if($sorted_fields[$prop['CODE']]){
		if($sorted_fields[$prop['CODE']]['UF_REQUIRE'] > 0)
			$prop['IS_REQUIRED'] = 'Y';

		$prop['FIELD_TYPE'] = $filed_types[$sorted_fields[$prop['CODE']]['UF_TYPE']];
		$prop['MASK_CLASS'] = $sorted_fields[$prop['CODE']]['UF_MASK_CLASS'];
		$prop['MULTI'] = $sorted_fields[$prop['CODE']]['UF_MULTI'];
		$prop['SORT'] = $sorted_fields[$prop['CODE']]['UF_SORT'];
		$prop['DESC_FIELD'] = $sorted_fields[$prop['CODE']]['UF_DESC_FIELD'];
	}
	if($prop['PROPERTY_TYPE'] == 'E'){
		$prop['SELECTED'] = array();
		if(is_array($prop['VALUE'])){
			foreach($prop['VALUE'] as $sel){
				if($prop['CODE'] == "TARGET_AUDIENCE"){
					$filt = array("ID"=>$sel);
					$filt["IBLOCK_ID"] = array(3, 6);
					$name = CIBlockElement::getList(array(),$filt,false,false,array("ID","NAME","IBLOCK_ID"))->Fetch();
					if($name['IBLOCK_ID'] == 3){
						$prop['SELECTED'][] = array('ID'=>$name['ID'],"NAME" => $name['NAME'],"IBLOCK_ID" => $name['IBLOCK_ID']);
					}else{
						if($name){
							$prop['SELECTED_CHECK'][$name['ID']] = array('ID'=>$name['ID'],"NAME" => $name['NAME'],"IBLOCK_ID" => $name['IBLOCK_ID']);
						}
						
					}
				}else{
					if(is_numeric($sel))
						$filt = array("ID"=>$sel);
					else
						$filt = array("NAME"=>$sel);
					if(isset($prop['LINK_IBLOCK_ID']) && $prop['LINK_IBLOCK_ID'] != ""){
						$filt["IBLOCK_ID"] = $prop['LINK_IBLOCK_ID'];
					}
					$name = CIBlockElement::getList(array(),$filt,false,false,array("ID","NAME","IBLOCK_ID"))->Fetch();

					$prop['SELECTED'][] = array('ID'=>$name['ID'],"NAME" => $name['NAME'],"IBLOCK_ID" => $name['IBLOCK_ID']);
				}
				
			}
		}
	}
}