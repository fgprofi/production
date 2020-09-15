<?
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php" );
if ( isset( $_REQUEST ) ) {
	$arData = $_REQUEST;
//	 echo "<pre>"; print_r($arData); echo "</pre>";
//	 die();
	if ( CModule::IncludeModule( "iblock" ) ) {
		$arParams     = array(
			"TYPE_F" => 7,
			"TYPE_U" => 8,
		);
		$arTypeText   = array(
			7 => "физическое лицо",
			8 => "юр. лицо",
		);
		$sectUrl      = array(
			7 => "fiz_faces",
			8 => "legal_faces",
		);
		$arParamsProp = array(
			"SIGN_OF_USER_DATA_DELETION"       => array(
				7 => 3,
				8 => 4
			),
			"PERSONAL_DATA"                    => array(
				7 => 2,
				8 => ""
			),
			"VERIFICATION_PASSED_BY_MODERATOR" => array(
				7 => 4,
				8 => 10
			),
		);
		$ib           = $arParams[ $arData["FACE"] ];
		foreach ($_REQUEST as $key => $value) {
			if(stristr($key, 'REVERS_') !== FALSE) {
				$keyData = str_replace("REVERS_", "", $key);
				if(isset($arData[$keyData])){
					unset( $arData[$key] );
					unset( $arData[$keyData] );
				}
			}
		}
		unset( $arData["FACE"] );
		$arFilter = Array( "IBLOCK_ID" => $ib );
		if (isset($arData["users_id"])) {
            $arUsersId = explode(",", $arData["users_id"]);
            $arFilter["ID"] = $arUsersId;
            unset($arData["users_id"]);
        }
		if ( isset( $arData["NAME"] ) ) {
			$arFilter["NAME"] = $arData["NAME"];
			unset( $arData["NAME"] );
		}
		if(isset($arData["REVERS_ACTIVE"]) && isset($arData["ACTIVE"])){
			unset( $arData["ACTIVE"] );
			unset( $arData["REVERS_ACTIVE"] );
		}else{
			if ( isset( $arData["ACTIVE"] ) ) {
				$arFilter["ACTIVE"] = $arData["ACTIVE"];
				unset( $arData["ACTIVE"] );
			}
			if ( isset( $arData["REVERS_ACTIVE"] ) ) {
				$arFilter["ACTIVE"] = $arData["REVERS_ACTIVE"];
				unset( $arData["REVERS_ACTIVE"] );
			}
		}
		if(isset($arData["EMPTY_PROP"])){
			$arPropEmpty["LOGIC"] = "AND";
			foreach ($arData["EMPTY_PROP"] as $propEmptyCode) {
				$arPropEmpty[] = array("PROPERTY_".$propEmptyCode => false);
			}
			$arFilter[] = $arPropEmpty;
			unset($arData["EMPTY_PROP"]);
		}

		// echo "<pre>"; print_r($arData); echo "</pre>";
		// die();
		$arSelect = Array( "ID", "NAME", "DATE_ACTIVE_FROM", "ACTIVE" );
//		if ( $ib == 7 ) {
			$arSelect[] = "PROPERTY_PHOTO";
			$arSelect[] = "PROPERTY_SURNAME";
			$arSelect[] = "PROPERTY_MIDDLENAME";
			$arSelect[] = "PROPERTY_FIRST_NAME";
			$arSelect[] = "PROPERTY_SIGN_OF_USER_DATA_DELETION";
//		}
		if(isset($arData["SURNAME"]) && strripos($arData["SURNAME"], ",") !== false){
			$arPropValExplode = explode(",", $arData["SURNAME"]);
			foreach ($arPropValExplode as $value) {
				$value = trim($value);
				if($value != ""){
					$arPropExp[] = array("PROPERTY_SURNAME" => $value."%");
				}
			}
			if(count($arPropExp)>1){
				$arPropExp["LOGIC"] = "OR";
				$arFilter[] = $arPropExp;
				unset($arData["SURNAME"]);
			}else{
				trim($arData["SURNAME"], ",");
			}
		}
		if(isset($arData["FIRST_NAME"]) && strripos($arData["FIRST_NAME"], ",") !== false){
			$arPropValExplode = explode(",", $arData["FIRST_NAME"]);
			foreach ($arPropValExplode as $value) {
				$value = trim($value);
				if($value != ""){
					$arPropExp[] = array("PROPERTY_FIRST_NAME" => $value."%");
				}
			}
			if(count($arPropExp)>1){
				$arPropExp["LOGIC"] = "OR";
				$arFilter[] = $arPropExp;
				unset($arData["FIRST_NAME"]);
			}else{
				trim($arData["FIRST_NAME"], ",");
			}
		}
		$countItems = 100;
		if ( isset( $arData["countItems"] ) ) {
			$countItems = $arData["countItems"];
			unset( $arData["countItems"] );
		}
		$numPage = 1;
		if ( isset( $arData["numPage"] ) ) {
			$numPage = $arData["numPage"];
			unset( $arData["numPage"] );
		}
		if ( isset( $arData["PERSONAL_DATA"] ) ) {
			if(count($arData["PERSONAL_DATA"])<=1){
				if(in_array("0", $arData["PERSONAL_DATA"])){
					$arFilter[ "!PROPERTY_PERSONAL_DATA_VALUE"] = "Да";
				}else{
					$arFilter[ "PROPERTY_PERSONAL_DATA_VALUE"] = "Да";
				}
			}
			unset( $arData["PERSONAL_DATA"] );
		}
		if ($arData["LOCALITY"] != "") {
            $arFilter["PROPERTY_LOCALITY"] = "%" . $arData["LOCALITY"] . "%";
            unset($arData["LOCALITY"]);
        }
//		$arFilter["PROPERTY_SIGN_OF_USER_DATA_DELETION"] = false;
		foreach ( $arData as $propName => $propValue ) {
			if(is_array($propValue)){
				if(count($propValue)>1){
					$firstFiltProp = $propValue[0];
					unset($propValue[0]);
					$propValue = array_keys($propValue);
					$propValue[] = $firstFiltProp;
					$arPropFilt["LOGIC"] = "OR";
					foreach ($propValue as $valueId) {
						$arPropFilt[] = array($propName => $valueId);
					}
					$arFilter[] = $arPropFilt;
				}else{
					$arFilter[$propName] = $propValue[0];
				}
			}else{
				if($propValue != "false" && $propValue != false){
					if(stristr($propName, 'REVERS_') !== FALSE) {
						$propName = str_replace("REVERS_", "", $propName);
						$propName = str_replace("PROPERTY_", "", $propName);
						if ( $arParamsProp[ $propName ] ) {
							$propValue = $arParamsProp[ $propName ][ $ib ];
						}
						if ( $propValue != "" ) {
							$arFilter[ "!PROPERTY_" . $propName ] = $propValue;
						}
					}else{
						$propName = str_replace("PROPERTY_", "", $propName);
						if ( $propValue != "" && $propValue != "0") {
							if($propName == "SURNAME" || $propName == "FIRST_NAME"){
								if ( $propValue != "" ) {
									$arFilter[ "PROPERTY_" . $propName ] = $propValue."%";
								}
							}else{
								if ( $arParamsProp[ $propName ] ) {
									$propValue = $arParamsProp[ $propName ][ $ib ];
								}
								if ( $propValue != "" ) {
									$arFilter[ "PROPERTY_" . $propName ] = $propValue;
								}
							}
						}
						if ( $propValue == 0 && $propName == 'PERSONAL_DATA') {
							$arFilter[ "!PROPERTY_" . $propName ] = 2;
						}
					}
				}
			}
		}
		$arResult["ib"] = $arFilter["IBLOCK_ID"];
		$res  = CIBlockElement::GetList( Array(), $arFilter, false, false, $arSelect );

		while ( $ob = $res->Fetch() ) {
			$arResult["id"][] = $ob["ID"];
		}
		echo json_encode($arResult);

	}
}
?>

<?
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php" );
?>