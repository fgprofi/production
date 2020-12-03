<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth('/auth/');
$APPLICATION->SetTitle("Настройки пользователя");

if($USER_PROP["ID_USER_INFO"] != "" && $_REQUEST["event"] == "auth_profile" && $_REQUEST["profile_id"] != ""){
	global $USER;
	$authorize = false;
	if($USER_PROP["IBLOCK_ID"] == 7){
		$resRealUser = CIBlockElement::GetProperty(8, $_REQUEST["profile_id"], array("sort" => "asc"), Array("CODE"=>"USER_ID"));
		if($arRealUser = $resRealUser->Fetch()) {
			$res = CIBlockElement::GetProperty($USER_PROP["IBLOCK_ID"], $USER_PROP["ID_USER_INFO"], array("sort" => "asc"), Array("CODE"=>"REPRESENTATIVE_OF_LEGAL_FACES"));
			$arIsLegal = array();
			while ($ob = $res->Fetch()) {
				$arIsLegal[] = $ob["VALUE"];
			}
			if(in_array($_REQUEST["profile_id"], $arIsLegal)){
				$authorize = true;
			}
			
		}
	}
	if($USER_PROP["IBLOCK_ID"] == 8){
		$resRealUser = CIBlockElement::GetProperty(7, $_REQUEST["profile_id"], array("sort" => "asc"), Array("CODE"=>"USER_ID"));
		if($arRealUser = $resRealUser->Fetch()) {
			$res = CIBlockElement::GetProperty($USER_PROP["IBLOCK_ID"], $USER_PROP["ID_USER_INFO"], array("sort" => "asc"), Array("CODE"=>"FIZ_USER_ID"));
			if ($ob = $res->Fetch()) {
				if($ob["VALUE"] == $_REQUEST["profile_id"]){
					$authorize = true;
				}
			}
		}
	}
	if($authorize || isAdministrator()){
		$USER->Authorize($arRealUser["VALUE"]);
		header('Location: /personal/');
	}
}

if(isAdministrator() && $_GET['id'] == ''){
	header('Location: /admin/');
}
$APPLICATION->IncludeComponent(
	"deus:news.detail",
	"user_profile",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"PROOF_MINFIN" => $USER_PROP["PROOF_MINFIN"],
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => $USER_PROP["ID_USER_INFO"],
		"FIELD_CODE" => array("ACTIVE"),
		"IBLOCK_ID" => $USER_PROP["IBLOCK_ID"],
		"IBLOCK_TYPE" => "person",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"ACCOUNT_TABS" => array(
			7 => array(
				"Информация" => array(
					"DATE_OF_BIRTH",
					"LANGUAGE_SKILLS",
					"REGION_OF_RESIDENCE",
					"PHONE",
					"EMAIL",
					"SOC",
				),
				"Образование" => array(
					"EDUCATION",
				),
				"Место работы" => array(
					"PLACE_OF_WORK",
					"POSITION",
					"KIND_OF_ACTIVITY",
					"REPRESENTATIVE_OF_LEGAL_FACES",
				),
				"Область работы" => array(
					"FINANCIAL_LITERACY_COMPETENCIES",
					"TARGET_AUDIENCE",
					"SIFLAS",
					"WORK_REGIONS",
					"AUTHOR_OF_MATERIALS",
				),
				"Дополнительные сведения" => array(
					"BRIEF_MESSAGE",
				),
			),
			8 => array(
				"Информация" => array(
					"FIRST_NAME",
					"FORM_OF_INCORPORATION",
					"INN",
					"KPP",
					"OGRN",
					"FG_UNIT",
					"LOCATION_REGION",
					"LOCALITY",
					"ACTUAL_ADDRESS",
					"PHONE",
					"EMAIL",
					"SITE_PAGE",
					"FINANCIAL_LITERACY_AREAS",
					"TYPE_ORGANIZATION",
					"TARGET_AUDIENCE",
					"REGIONS_THE_ORGANIZATION_WORKS_WITH",
					"CONTRACTOR_FOR_MATERIALS"
				),
				"Дополнительные сведения" => array(
					"ADDITIONAL_INFORMATION",
				),
			),
		),
		"PROPERTY_CODE" => array(
			"SURNAME",
			"MIDDLENAME",
			"PHOTO",
			"DATE_OF_BIRTH",
			"EDUCATION",
			"LANGUAGE_SKILLS",
			"REGION_OF_RESIDENCE",
			"LOCALITY",
			"PHONE",
			"EMAIL",
			"SOC",
			"PLACE_OF_WORK",
			"POSITION",
			"KIND_OF_ACTIVITY",
			"FINANCIAL_LITERACY_COMPETENCIES",
			"TARGET_AUDIENCE",
			"SIFLAS",
			"WORK_REGIONS",
			"AUTHOR_OF_MATERIALS",
			"ADDITIONAL_INFORMATION",
			"PERSONAL_DATA",
			"BRIEF_MESSAGE",
			"MEMBER_INFORMATION_SOURCE",
			"INTERNAL_COMMENTS",
			"EXPERT_RATING",
			"SIGN_OF_USER_DATA_DELETION",
			"VERIFICATION_PASSED_BY_MODERATOR",
			"CUSTOMER_CARD_ACTIVITY",
			"REPRESENTATIVE_OF_LEGAL_FACES",
			"FORM_OF_INCORPORATION",
			"INN",
			"KPP",
			"OGRN",
			"FG_UNIT",
			"LOCATION_REGION",
			"LOCALITY",
			"ACTUAL_ADDRESS",
			"PHONE",
			"EMAIL",
			"SITE_PAGE",
			"FIZ_USER_ID",
			"MARK_FOR_A_TECHNICAL_SPECIALIST",
			"FINANCIAL_LITERACY_AREAS",
			"TYPE_ORGANIZATION",
			"TARGET_AUDIENCE",
			"REGIONS_THE_ORGANIZATION_WORKS_WITH",
			"CONTRACTOR_FOR_MATERIALS",
			"ADDITIONAL_INFORMATION",
			"INTERNAL_COMMENTS",
			"EXPERT_RATING",
			"SIGN_OF_USER_DATA_DELETION",
			"VERIFICATION_PASSED_BY_MODERATOR",
			"CUSTOMER_CARD_ACTIVITY",
			"TARGET_AUDIENCE_CUSTOM",
			"EXPERT_RATING_CUSTOM",
			"TYPE_ORGANIZATION_CUSTOM",
			"LOCATION_REGION_CUSTOM",
			"REGIONS_THE_ORGANIZATION_WORKS_WITH_CUSTOM",
			"FORM_OF_INCORPORATION_CUSTOM",
			"MARGE_ID",
			"USER_ID",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N"
	)
);?>

<?//echo "<pre>"; print_r($USER_PROP); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>