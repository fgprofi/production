<?$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/ext_www/v2-fgprofi";

require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php" );

use \Bitrix\Highloadblock\HighloadBlockTable as HLBT;

if ( CModule::IncludeModule( "iblock" ) && CModule::IncludeModule( 'highloadblock' ) ) {
	function GetEntityDataClass( $HlBlockId ) {
		if ( empty( $HlBlockId ) || $HlBlockId < 1 ) {
			return false;
		}
		$hlblock           = HLBT::getById( $HlBlockId )->fetch();
		$entity            = HLBT::compileEntity( $hlblock );
		$entity_data_class = $entity->getDataClass();

		return $entity_data_class;
	}

	function getRubric() {
		$entity_data_class = GetEntityDataClass( 7 );
		$rsData            = $entity_data_class::getList( array(
			'select' => array( '*' )
		) );
		while ( $el = $rsData->fetch() ) {
			$allRubric[ $el["UF_XML_ID"] ] = $el["UF_NAME"];
		}

		return $allRubric;
	}

	$thisTime = time();
	//echo "<pre>"; print_r($thisTime); echo "</pre>";
	$allRubric = getRubric();
	//echo "<pre>"; print_r($allRubric); echo "</pre>";
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"DATE_ACTIVE_FROM",
		"DATE_ACTIVE_TO",
		"CREATED_USER_NAME",
		"PREVIEW_TEXT",
		"DETAIL_TEXT",
		"PROPERTY_*"
	);
	$el       = new CIBlockElement;
	$arFilter = array( "IBLOCK_ID" => 15, "DATE_ACTIVE_TO" => false, "ACTIVE" => "Y", "ACTIVE_DATE" => "Y" );
	$res      = CIBlockElement::GetList( array(), $arFilter, false, false, $arSelect );

	while ( $ob = $res->GetNextElement() ) {
		$result           = array();
		$result["FIELDS"] = $ob->GetFields();
		$result["PROP"]   = $ob->GetProperties();
		$users            = getUsers( $result["PROP"]["USERS"]["VALUE"] );

		// $customEmails = $result["PROP"]["CUSTOM_EMAILS"]["VALUE"]["TEXT"];
		// $customEmails = explode(",", $customEmails);
		// //echo "<pre>"; print_r($customEmails); echo "</pre>";
		// foreach ($customEmails as $email) {
		// 	if($email != ""){
		// 		$email = trim($email);
		// 		$arEventFields = array(
		// 			"EMAIL_TO"=>$email,
		// 			"THEME"=>$result["FIELDS"]["NAME"],
		// 			"RUBRIC"=>$allRubric[$result["PROP"]["RUBRIC"]["VALUE"]],
		// 			"TEXT"=>$result["FIELDS"]["DETAIL_TEXT"]
		// 		);
		// 		if(CEvent::Send("SEND_MAILING", "s1", $arEventFields, "Y", "", array($result["PROP"]["FILE"]["VALUE"]))){
		// 			echo "Отправили рассылку на ".$email."<br>";
		// 		}
		// 	}
		// }
		foreach ( $users as $user ) {
			if ( $user["PROPERTY_EMAIL_VALUE"] != "" ) {
				$arEventFields = array(
					"EMAIL_TO" => $user["PROPERTY_EMAIL_VALUE"],
					"THEME"    => $result["FIELDS"]["NAME"],
					"RUBRIC"   => $allRubric[ $result["PROP"]["RUBRIC"]["VALUE"] ],
					"CATEGORY" => "",
					"ID"       => $result["FIELDS"]["ID"],
					"TEXT"     => $result["FIELDS"]["DETAIL_TEXT"]
				);
				if ( $result["PROP"]["CATEGORY_USERS"]["VALUE"] == "Юридические лица" ) {
					$arEventFields["CATEGORY"] = " (" . $result["PROP"]["CATEGORY_USERS"]["VALUE"] . ")";
				}

				// echo "<pre>"; print_r($arEventFields); echo "</pre>";
				// echo "<pre>"; print_r($result["PROP"]["FILE"]["VALUE"]); echo "</pre>";
				if ( CEvent::Send( "SEND_MAILING", "s1", $arEventFields, "Y", "", array( $result["PROP"]["FILE"]["VALUE"] ) ) ) {
					echo "Отправили рассылку на " . $user["PROPERTY_EMAIL_VALUE"] . "<br>";

				}
			}
		}
		$arLoadProductArray = array(
			"DATE_ACTIVE_TO" => date( $DB->DateFormatToPHP( CSite::GetDateFormat() ), time() ),
		);
		//echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
		if ( $el->Update( $result["FIELDS"]["ID"], $arLoadProductArray ) ) {
			echo "Обновили рассылку<br>";
		}

		$arResult[ $result["FIELDS"]["ID"] ] = $result;
	}
	echo "отправка завершена ".date('d-m-Y H:i:s')."\r\n";
}