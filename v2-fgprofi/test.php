<?
//ini_set('mbstring.func_overload' , 0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("support");

$data = $_REQUEST;

$arFilter = array(
	//"SITE_ID"=>"s1"
);
if(isset($data["id"]) && $data["id"] != ""){
	$arFilter["ID"] = $data["id"];
}
$rs = CTicket::GetList(
    $by="ID", 
    $order="desc",
    $arFilter,
    $isFiltered,
    "Y",
    "Y",
    "Y",
    false,
    Array("SELECT" => array("UF_*" ))
);
$arResult = array();
while($ar = $rs->Fetch()) 
{
	$obMessages = GetTicketMessages($ar["ID"], array(), "Y");
	while($arMessage = $obMessages->Fetch()){
		$ar["MESSAGES_TEXT"][] = $arMessage;
	}
	$catSID = 0;
	if($ar["CATEGORY_SID"]){
		$catSID = $ar["CATEGORY_SID"];
	}
	$arResult[$catSID][] = $ar;
	
}
echo "<pre>"; print_r($arResult); echo "</pre>";


?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>