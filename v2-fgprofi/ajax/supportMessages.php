<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$template = "ajax";
	if(isset($_REQUEST["template"]) && $_REQUEST["template"] != ""){
		$template = $_REQUEST["template"];
	}
	$APPLICATION->IncludeComponent("deus:unread.messages", $template, Array(
	    "TITLE_TYPE_MESS" => array(
	        "TICKET" => "Техническая поддержка",
	    ),
	));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>