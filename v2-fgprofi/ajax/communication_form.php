<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;
        $arDataParamsProp = array(
            "TYPE_F" => array(
                "IBLOCK_ID" => 7,
            ),
            "TYPE_U" => array(
                "IBLOCK_ID" => 8,
            ),
        );
        
        $APPLICATION->IncludeComponent("deus:news.detail", "communication-form", Array(
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
                "ELEMENT_ID" => $arData["id"],
                "FIELD_CODE" => array("ACTIVE"),
                "IBLOCK_ID" => $arDataParamsProp[$arData["type_user"]]["IBLOCK_ID"],
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
            )
        );
}?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>