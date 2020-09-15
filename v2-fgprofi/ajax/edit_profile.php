<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
	if(CModule::IncludeModule("iblock")){ 
		if($_REQUEST["PROFILE_ID"] != "" && $_REQUEST["PROFILE_IB"] != ""){
			unset($arData["PROFILE_ID"]);
			unset($arData["PROFILE_IB"]);
			$arProp = array();
			$arFields = array();
			//echo "<pre>"; print_r($arData); echo "</pre>";
			foreach ($arData as $key => $value) {
				if(!is_array($value)){
					$value = trim(strip_tags(htmlspecialchars(strip_tags($value))));
				}
				else{
					$dataVal = array();
					//echo "<pre>"; print_r($value); echo "</pre>";
					foreach ($value as $keyVal => $valVal) {
						if($valVal != ""){
							$dataVal[$keyVal] = $valVal;
						}
					}
					if(!empty($dataVal)){
						$value = $dataVal;
					}
					//echo "<pre>"; print_r($value); echo "</pre>";
					$arV = array();
					foreach($value as $k=>$v){
						//echo $k;
						if($k){
							$arV[] = trim(strip_tags(htmlspecialchars(strip_tags($k))));
						}
					}
					$value = $arV;
				}
				if(stristr($key, 'PROPERTY_') !== FALSE){
					$key = str_replace('PROPERTY_', '', $key);
					if(empty($value)){
						$value = false;
					}
					$arProp[$key] = $value;
					//echo "<pre>"; print_r($key); echo "</pre>";
					//echo "<pre>"; print_r($value); echo "</pre>";
				}else{
					$arFields[$key] = $value;
				}
			}
			//echo "<pre>"; print_r($arProp); echo "</pre>";
			//сливаем свойства и нужные поля
			foreach($arFields as $k => $val){
				if(is_array($val)){
					$arProp[$k] = array();
					foreach($val as $id => $v){
						$arProp[$k][] = $id;
					}
				}
			}
			//echo "<pre>"; print_r($arProp); echo "</pre>";
			$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$_REQUEST["PROFILE_IB"]));

			while ($prop_fields = $properties->GetNext())
			{
				if($prop_fields["IS_REQUIRED"] == "Y"){
					$arAllPropReq[$prop_fields["ID"]] = $prop_fields["ID"];
				}
				$arAllProp[$prop_fields["ID"]] = $prop_fields["ID"];
			}
			foreach ($arProp as $propName => $prop) {
				// if($propName == "TARGET_AUDIENCE"){
				// 	if(isset($prop[122])){
				// 		//unset($prop[122]);
				// 	}
				// 	$arProp["TARGET_AUDIENCE"] = array_keys($prop);
				// }
				if($propName == "HIDDEN_VIEW"){

					foreach ($arData["HIDDEN_VIEW"] as $value) {
						if($value != 0 && $value != "" && isset($arAllProp[$value]) && !isset($arAllPropReq[$value])){
							unset($arAllProp[$value]);
						}
					}
					$dataValHiddenProp = implode(",", $arAllProp);
				}else{
					if(is_array($prop) && count($prop)>=1){
						if($prop[0] == ""){
							unset($prop[0]);
						}
					}
				}
			}
			
			if(isset($dataValHiddenProp)){
				$arProp["HIDDEN_VIEW"] = $dataValHiddenProp;
			}
			// echo json_encode($arProp);
			// die();
			// echo "<pre>"; print_r($arData); echo "</pre>";
			// echo "<pre>"; print_r($arProp); echo "</pre>";
			// die();
			if(isset($arProp["FIZ_USER_ID"]) && $arProp["FIZ_USER_ID"] != ""){
				$obUserIb = CIBlockElement::GetPropertyValues(7, array('ID' => $arProp["FIZ_USER_ID"]), true, array('ID' => 10));
				$obThisUserIb = CIBlockElement::GetPropertyValues(8, array('ID' => $_REQUEST["PROFILE_ID"]), true, array('ID' => 74));
				if ($arUserIb = $obUserIb->Fetch())
				{
					if ($arThisUserIb = $obThisUserIb->Fetch()){
						$user = new CUser;
						$fields = Array( 
							"EMAIL" => $arUserIb[10], 
						);
						$user->Update(intval($arThisUserIb[74]), $fields);
					}
				}
			}
			if($_REQUEST["PROFILE_IB"] == 7){
				$obUserIb = CIBlockElement::GetPropertyValues(7, array('ID' => $_REQUEST["PROFILE_ID"]), true, array('ID' => 73));
				if ($arUserIb = $obUserIb->Fetch()){
					$user = new CUser;
					$fields = Array( 
						"NAME" => $arProp["FIRST_NAME"], 
						"LAST_NAME" => $arProp["SURNAME"],
						"SECOND_NAME" => $arProp["MIDDLENAME"],
					);
					$user->Update(intval($arUserIb[73]), $fields);
				}
			}
			CIBlockElement::SetPropertyValuesEx($_REQUEST["PROFILE_ID"], $_REQUEST["PROFILE_IB"], $arProp);
			$arResult[] = $propName." изменено";
			if(!empty($arFields)){
				$el = new CIBlockElement;
				$arLoadProductArray = Array(
					"MODIFIED_BY"    => $USER->GetID(),
					"NAME"           => $arProp["SURNAME"].' '.$arProp['FIRST_NAME'].' '.$arProp['MIDDLENAME'],
				);
				if($res = $el->Update($_REQUEST["PROFILE_ID"], $arLoadProductArray)){
					$arResult[] = "Имя изменено";
				}
			}
		}
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>