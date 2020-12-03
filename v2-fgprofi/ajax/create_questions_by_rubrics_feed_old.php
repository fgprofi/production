<?
ob_start();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("support");
function textTransform($str){
	$str = str_replace(chr(38), "", $str);
	$str = str_replace('"', "", $str);
	$str = htmlspecialchars_decode(str_replace(array('\"'),'',$str));
	$str = str_replace("&amp;amp;quot;","",$str);
	$str = str_replace("&amp;quot;","",$str);
	$str = str_replace("&quot;", "", $str);
	return $str;
}
$data = $_REQUEST;
if(isset($data["rubric_id"]) && $data["rubric_id"] != ""){
	$arFilter = array(
		'CATEGORY_SID' => $data["rubric_id"],
	);
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
		//echo "<pre>"; print_r($ar); echo "</pre>";
		$obMessages = GetTicketMessages($ar["ID"], array(), "Y");
		$newTicket = true;
		while($arMessage = $obMessages->Fetch()){
			$ar["MESSAGES_TEXT"][] = $arMessage;
		}
		$arResult[] = $ar;
		
	}

	if(!empty($arResult)){
		$arHeads = array(
			"PROFILES"=>"Тикет", 
			"MESSAGES"=>"Переписка"
		);

		$row_delimiter = "\n";
		$str = implode(";",$arHeads).$row_delimiter;
		foreach ($arResult as $ticket) {
			$colTicketTitle = $ticket["TITLE"]."(".$ticket["ID"].")";
			$colTicketTitle = textTransform($colTicketTitle);
			$colMess = "\"";
			foreach ($ticket["MESSAGES_TEXT"] as $mess) {
				//echo "<pre>"; print_r($mess); echo "</pre>";
				if($mess["OWNER_EMAIL"]){
					$colMess .= $mess["OWNER_EMAIL"]."\r".$mess["MESSAGE"]."\r\r";
				}
			}
			$colMess = textTransform($colMess);
			$colMess .= "\"".$row_delimiter;
			$str .= "\"".$colTicketTitle."\";\"".$colMess;
		}

	}
}
header("Content-type: csv/plain");
header("Content-Disposition: attachment; filename=questions_".date("d_m_Y").".csv");
ob_end_clean();
echo $str;
exit;

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>