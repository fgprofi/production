<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
	if(CModule::IncludeModule("iblock")){
		$arParams = array(
			"TYPE_F" => 7,
			"TYPE_U" => 8,
		);
		
		$arProps = array(
			"LOCALITY",
			"PLACE_OF_WORK",
			//"TARGET_AUDIENCE",
			"NAME_SUBDIVISION",
			"FIRST_NAME",
			"SURNAME",
			"SIFLAS",
			"EMAIL",
			"POSITION",
			"AUTHOR_OF_MATERIALS",
			"EDUCATION",
		);
		if(in_array($arData["input"], $arProps)){
			$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
			$arFilter = Array("IBLOCK_ID"=>$arParams[$arData["face"]], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
			$filterField = $arData["input"];
			$pr = "";
			if($arData["input"] != "NAME"){
				$filterField = "PROPERTY_".$arData["input"];
				$arSelect[] = $filterField;
				$pr = "_VALUE";
			}
			$arFilter[$filterField] = "%".$arData[$arData["input"]]."%";
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			while($ob = $res->Fetch())
			{
				if(is_array($ob[$filterField.$pr])){

					foreach ($ob[$filterField.$pr] as $key => $propValue) {

						$dataPropValue = strtolower($propValue);
						//echo "<pre>"; print_r(strtolower($arData[$arData["input"]])); echo "</pre>";
						//if($dataPropValue == strtolower($arData[$arData["input"]])){
						if(stristr($dataPropValue, strtolower($arData[$arData["input"]])) !== FALSE){
							$arResult[$dataPropValue] = $dataPropValue;
						}
					}
				}else{
					$arResult[$ob[$filterField.$pr]] = $ob[$filterField.$pr];
				}
				
				//$arResult[] = $ob;
				$arResultFio[] = $ob["NAME"];
			}
			$arFioProp = array("FIRST_NAME", "SURNAME");
			$str = "<div class='selector-input'>";

			if(!empty($arResult)){
				foreach ($arResult as $key => $value) {
					$value = strtolower($value);
					$value = trim($value);
					$value = strtoupper(substr($value, 0, 1)).substr($value, 1);
					$arDataResult[$value] = $value;
				}
				$arResult = $arDataResult;
				foreach ($arResult as $key => $value) {
					$valueText = $value;
					// if(in_array($arData["input"], $arFioProp)){
					// 	$valueText = $arResultFio[$key];
					// }

					$str .= "<div class='selector-value' data-value='".$valueText."'>".$valueText."</div>";
				}
				$str .= "<div class='selector-value' data-value=''>Сбросить</div>";
			}else{
				$str .= "<div class='selector-value disabled'>Нет подходящих значений</div>";
			}
			$str .= "</div>";
			echo $str;
		}
		//echo "<pre>"; print_r($arResult); echo "</pre>";
		//echo "<pre>"; print_r($arFilter); echo "</pre>";
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>