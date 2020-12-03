<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Настройки электронной почты");
$USER_PROP = needAuth('/auth/');
?>
<?
$arrFilter = Array(
"!PROPERTY_VERIFICATION_PASSED_BY_MODERATOR" => 4,
"PROPERTY_SIGN_OF_USER_DATA_DELETION"=>false
);
$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"moderation",
	Array(
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_IMG_WIDTH" => "80",
		"DISPLAY_IMG_HEIGHT" => "56",
		"LINE_NEWS_COUNT" => "2",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "7",
		"PROOF_MINFIN" => $USER_PROP["PROOF_MINFIN"],
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array("ID","NAME"),
		"PROPERTY_CODE" => array("SURNAME","MIDDLENAME","FIRST_NAME","PHOTO"),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"NAME_BLOCK" => "Последние новости",
	)
);?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
