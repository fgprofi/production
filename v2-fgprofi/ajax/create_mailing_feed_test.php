<?
//ob_start();
//ini_set('mbstring.func_overload' , 0);
// phpinfo();
// die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//include $_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/PHPExcel/IOFactory.php';
CModule::IncludeModule("iblock");
CModule::IncludeModule("support");
$arRubric = getMailingRubric();
$data = $_REQUEST;
$thisDate = date("d-m-Y", time());

$ob = CIBlockElement::getList(array(),array("IBLOCK_ID"=>15, "GLOBAL_ACTIVE"=>"N"),false,false,array("ID", "IBLOCK_ID", "NAME","PROPERTY_USERS","PROPERTY_RUBRIC"));
$numList = 0;
$arHeads = array(
	"A"=>"Пользователи", 
	"B"=>"Переписка"
);
while($resList = $ob->GetNextElement()){
	$arData["PROP"] = $resList->GetProperties();
	$arData["FIELDS"] = $resList->GetFields();
	$arResult[$arData["FIELDS"]["ID"]] = $arData;
}
//echo "<pre>"; print_r($arResult); echo "</pre>";
foreach($arResult as $mailingId => $mailing){	
	$arMailingProps = $mailing["PROP"];
	$arMailingFields = $mailing["FIELDS"];
	echo "<pre>"; print_r($arMailingFields); echo "</pre>";
	$rowNum = 1;
	$arUsers = getUsers($arMailingProps["USERS"]["VALUE"]);
	$thisRubric = $arRubric[$arMailingProps["RUBRIC"]["VALUE"]]["UF_NAME"];
	foreach ($arUsers as $key => $user) {
		$arFilter = Array(
			"TITLE"=> "Re: ".$arMailingFields["NAME"]." (".$thisRubric.")",
			"OWNER"=>$user["PROPERTY_USER_ID_VALUE"],
		);
		echo "<pre>"; print_r($arFilter); echo "</pre>";
		$by = "s_id";
		$order = "asc";
		$tickets = CTicket::GetList($by, $order, $arFilter, $is_filtered);
		$strTicket = "";
		$arTicket = "";
		while($ar = $tickets->Fetch()) 
		{
			$arTicket = $ar;
			$strTicket = "Тикет: ".$arTicket["TITLE"]." (".$arTicket["ID"].")\r";
			$mess = CTicket::GetMessageList($by, $order, array("TICKET_ID" => $arTicket["ID"],"IS_MESSAGE" => "Y"), $c, $CHECK_RIGHTS);
			while($arMess = $mess->Fetch()) 
			{
				$strMes = $arMess["OWNER_EMAIL"]." (".$arMess["DATE_CREATE"].")\r";
				$strTicket .= $strMes;
				$strTicket .= $arMess["MESSAGE"]."\r\r";
				//echo "<pre>"; print_r($arMess); echo "</pre>";
			}
		}
		
	}
}

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>