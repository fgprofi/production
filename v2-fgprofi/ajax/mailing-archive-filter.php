<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST)){
	$arData = $_REQUEST;
      $arFilterAjaxArchive["!DATE_ACTIVE_TO"] = false;
      $name = "";
      if( $arData["name-text"] && $arData["name-text"] != ""){
            $name = $arData["name-text"];
      }
	if($arData["mailing-archive-text"] && $arData["mailing-archive-text"] != ""){
            $name = $arData["mailing-archive-text"];
	}
      if($name != ""){
            //$arFilterAjaxArchive["NAME"] = "%".$arData["mailing-archive-text"]."%";
            $arFilterAjaxArchive[] = array(
                "LOGIC" => "OR",
                array("NAME" => "%".$name."%"),
                array("PROPERTY_DATE_SEND" => "%".$name."%"),
            );
      }
      if($arData["category_users"] && $arData["category_users"] != ""){
            $arFilterAjaxArchive["PROPERTY_CATEGORY_USERS_VALUE"] = $arData["category_users"];
      }
      if(isset($arData["list"])){
            if($arData["list"] != ""){
                  $arFilterAjaxArchive["PROPERTY_RUBRIC"] = $arData["list"]; 
            }else{
                  $arFilterAjaxArchive["PROPERTY_RUBRIC"] = false;
            }  
      }
	
	//$GLOBALS['arrFilterAjaxTemplate'] = array('!DATE_ACTIVE_TO' => false);
      $GLOBALS['arrFilterAjaxArchive'] = $arFilterAjaxArchive;
      //echo "<pre>"; print_r($GLOBALS['arrFilterAjaxArchive']); echo "</pre>";
	$APPLICATION->IncludeComponent("deus:news.list","mailing-archive",Array(
              "AJAX_MODE" => "N",
              "IBLOCK_TYPE" => "mailing",
              "IBLOCK_ID" => "15",
              "NEWS_COUNT" => "9999",
              "SORT_BY1" => "ACTIVE_FROM",
              "AR_RUBRICS" => "",
              "CHECK_ACTIVE" => "N",
              "SORT_ORDER1" => "DESC",
              "SORT_BY2" => "SORT",
              "SORT_ORDER2" => "ASC",
              "FILTER_NAME" => "arrFilterAjaxArchive",
              "FIELD_CODE" => Array("ID","DATE_ACTIVE_TO"),
              "PROPERTY_CODE" => Array("RUBRIC", "USERS", "COUNTER", "DATE_SEND"),
              "CHECK_DATES" => "N",
              "DETAIL_URL" => "",
              "ACTIVE_DATE_FORMAT" => "d.m.Y",
              "SET_TITLE" => "N",
              "SET_BROWSER_TITLE" => "N",
              "SET_META_KEYWORDS" => "N",
              "SET_META_DESCRIPTION" => "N",
              "SET_LAST_MODIFIED" => "N",
              "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
              "ADD_SECTIONS_CHAIN" => "N",
              "PARENT_SECTION" => "",
              "PARENT_SECTION_CODE" => "",
              "INCLUDE_SUBSECTIONS" => "Y",
              "CACHE_TYPE" => "N",
              "CACHE_TIME" => "3600",
              "CACHE_FILTER" => "Y",
              "CACHE_GROUPS" => "Y",
              "DISPLAY_TOP_PAGER" => "N",
              "DISPLAY_BOTTOM_PAGER" => "N",
              "PAGER_TITLE" => "",
              "PAGER_SHOW_ALWAYS" => "N",
              "PAGER_TEMPLATE" => "",
              "PAGER_DESC_NUMBERING" => "N",
              "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
              "PAGER_SHOW_ALL" => "N",
              "PAGER_BASE_LINK_ENABLE" => "N",
              "SET_STATUS_404" => "N",
              "SHOW_404" => "N",
          )
      );
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>