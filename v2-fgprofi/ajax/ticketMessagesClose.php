<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["itemId"]) && $_REQUEST["itemId"]!=""){
	if(CModule::IncludeModule("iblock") && CModule::IncludeModule('support'))
	{
		global $USER;
		CTicket::UpdateOnline($_REQUEST["itemId"], $USER->GetID());
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>