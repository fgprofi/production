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
		unset( $arData["FACE"] );
		$arFilter = Array( "IBLOCK_ID" => $ib );
		if ( isset( $arData["NAME"] ) ) {
			$arFilter["NAME"] = $arData["NAME"];
			unset( $arData["NAME"] );
		}
		if ( isset( $arData["ACTIVE"] ) ) {
			$arFilter["ACTIVE"] = $arData["ACTIVE"];
			unset( $arData["ACTIVE"] );
		}
		$arSelect = Array( "ID", "NAME", "DATE_ACTIVE_FROM", "ACTIVE" );
//		if ( $ib == 7 ) {
			$arSelect[] = "PROPERTY_PHOTO";
			$arSelect[] = "PROPERTY_SURNAME";
			$arSelect[] = "PROPERTY_MIDDLENAME";
			$arSelect[] = "PROPERTY_FIRST_NAME";
//		}

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
		if ($arData["LOCALITY"] != "") {
            $arFilter["PROPERTY_LOCALITY"] = "%" . $arData["LOCALITY"] . "%";
            unset($arData["LOCALITY"]);
        }
//		$arFilter["PROPERTY_SIGN_OF_USER_DATA_DELETION"] = false;
		foreach ( $arData as $propName => $propValue ) {
			if ( $propValue != "" && $propValue != "0" ) {
				if ( $arParamsProp[ $propName ] ) {
					$propValue = $arParamsProp[ $propName ][ $ib ];
				}
				if ( $propValue != "" ) {
					$arFilter[ "PROPERTY_" . $propName ] = $propValue;
				}
			}
			if ( $propValue == 0 && $propName == 'PERSONAL_DATA') {
				$arFilter[ "!PROPERTY_" . $propName ] = 2;
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