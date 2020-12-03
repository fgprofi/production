<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth_v2('/auth/',$_GET['id']);
$USER_PROP_REAL = needAuth('/auth/', false, true);
global $USER;
// if($USER->IsAdmin()){
// 	echo "<pre>"; print_r($USER_PROP_ADMIN); echo "</pre>";
// }

$APPLICATION->SetTitle("Настройки пользователя");

if(isAdministrator() && $_GET['id'] == ''){
	header('Location: /admin/');
}

?>
<main class="main">

    <div class="content">
            	<?
                $HBL_setting = array(7=>1,8=>2);//настройка для связки с HBL, в которых настраивается форма редактирования
            	$arParamsUser = array(
            		7 => array(
            			"FIELDS_GROOP_CUSTOM" => array(
            				"Данные пользователя" => array(
					            "SURNAME",
					            "FIRST_NAME",
            					"MIDDLENAME",
            					"DATE_OF_BIRTH",
            					"LANGUAGE_SKILLS",
            					"REGION_OF_RESIDENCE",
            					"LOCALITY",
            					"PHONE",
            					"EMAIL",
            					"SOC"
            				),
            				"Образование" => array(
            					"EDUCATION"
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
            					"PERSONAL_DATA",
            					"MEMBER_INFORMATION_SOURCE",
            					//"PROOF_MINFIN"
            				),
            			),
            			"PROPERTY_GROOP"=>array(
							"LANGUAGE_SKILLS"=>"LANGUAGE_SKILLS_CUSTOM",
							"EDUCATION"=>"EDUCATION_CUSTOM",
							"KIND_OF_ACTIVITY"=>"KIND_OF_ACTIVITY_CUSTOM",
							"FINANCIAL_LITERACY_COMPETENCIES"=>"FINANCIAL_LITERACY_COMPETENCIES_CUSTOM",
							"WORK_REGIONS"=>"WORK_REGIONS_CUSTOM",
						),
						"PROPERTY_ONLY_ADMIN"=>array(
							"MEMBER_INFORMATION_SOURCE",
							//"PROOF_MINFIN",
						),
            		),
		            8 => array(
			            "FIELDS_GROOP_CUSTOM" => array(
				            "Данные пользователя" => array(
					            "FIRST_NAME",
					            "NAME_SUBDIVISION",
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
					            "TARGET_AUDIENCE_CUSTOM",
					            "TYPE_ORGANIZATION_CUSTOM",
					            "LOCATION_REGION_CUSTOM",
					            "REGIONS_THE_ORGANIZATION_WORKS_WITH_CUSTOM",
					            "FORM_OF_INCORPORATION_CUSTOM",
				            )
			            ),
			            "PROPERTY_GROOP"=>array(
				            "FIZ_USER_ID"
			            ),
			            "DISABLED_PROPERTY"=>array(
				            "FIZ_USER_ID"
			            )
		            ),
            	);
            	$APPLICATION->IncludeComponent(
					"deus:news.detail",
					"user_profile_edit",
					Array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_ELEMENT_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"PROOF_MINFIN" => $USER_PROP_REAL["PROOF_MINFIN"],
						"BROWSER_TITLE" => "-",
						"CACHE_GROUPS" => "Y",
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
						"HBL_SETTING" => $HBL_setting[$USER_PROP["IBLOCK_ID"]],
						"FIELDS_GROOP_USER"=>$arParamsUser[$USER_PROP["IBLOCK_ID"]],
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
							"PROOF_MINFIN",
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
            </div>
</main>

<?//echo "<pre>"; print_r($USER_PROP); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>