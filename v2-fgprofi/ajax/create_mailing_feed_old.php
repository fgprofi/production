<?
ob_start();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("support");

$data = $_REQUEST;
if(isset($data["mailing_id"]) && $data["mailing_id"] != ""){
	$arRubric = getMailingRubric();
	$res = CIBlockElement::GetByID($data["mailing_id"]);
	$arHeads = array(
		"PROFILES"=>"Пользователи", 
		"MESSAGES"=>"Переписка"
	);
	
	$row_delimiter = "\n";
	$str = implode(";",$arHeads).$row_delimiter;
	if($obMailing = $res->GetNextElement()){
		$arMailingProps = $obMailing->GetProperties();
		$arMailingFields = $obMailing->GetFields();
		$arUsers = getUsers($arMailingProps["USERS"]["VALUE"]);
		$thisRubric = $arRubric[$arMailingProps["RUBRIC"]["VALUE"]]["UF_NAME"];
		$rowUser = "";
		foreach ($arUsers as $key => $user) {
			
			$arFilter = Array(
				//"TITLE"=> "Re: ".$arMailingFields["NAME"]." (".$thisRubric.")",
				"TITLE"=> "%<".$arMailingFields["ID"].">%",
				// array(
				//        "LOGIC" => "OR",
				//       	array(
				//         "LOGIC" => "AND",
				//         array("TITLE"=> "Re: ".$arMailingFields["NAME"]." (".$thisRubric.")"),
				//         array("!TITLE"=> "%<".$arMailingFields["ID"].">%"),
				//     ),
				//        array("TITLE"=> "%<".$arMailingFields["ID"].">%"),
				//),
				"OWNER"=>$user["PROPERTY_USER_ID_VALUE"],
			);
			$by = "s_id";
			$order = "asc";
			$tickets = CTicket::GetList($by, $order, $arFilter, $is_filtered);
			$strTicket = "";
			while($ar = $tickets->Fetch()) 
			{
				$arTicket = $ar;
				$strTicket = "Тикет: ".$arTicket["TITLE"]." (".$arTicket["ID"].")\r";
				$mess = CTicket::GetMessageList($by, $order, array("TICKET_ID" => $arTicket["ID"]/*, "TICKET_ID_EXACT_MATCH" => "Y"*/,"IS_MESSAGE" => "Y"), $c, $CHECK_RIGHTS);
				while($arMess = $mess->Fetch()) 
				{
					$strMes = $arMess["OWNER_EMAIL"]." (".$arMess["DATE_CREATE"].")\r";
					$strTicket .= $strMes;
					$strTicket .= $arMess["MESSAGE"]."\r\r";
					//echo "<pre>"; print_r($arMess); echo "</pre>";
				}
			}
			if($strTicket != ""){
				$rowUser .= "\"".$user["NAME"]."\";";
				$strTicket = str_replace(chr(38), "", $strTicket);
				$strTicket = htmlspecialchars_decode(str_replace(array('\"',),'',$strTicket));
				$strTicket = str_replace("&amp;amp;quot;","\"",$strTicket);
				$strTicket = str_replace("&amp;quot;","\"",$strTicket);
				$strTicket = str_replace("&quot;", "", $strTicket);
				$strTicket = str_replace('"', "", $strTicket);
				
				$rowUser .= "\"".$strTicket."\"".$row_delimiter;
			}
			
		}
		$str .= $rowUser;
		//echo "<pre>"; print_r($arUsers); echo "</pre>";
	}
}
header("Content-type: csv/plain");
header("Content-Disposition: attachment; filename=users_by_filter_".date("d_m_Y").".csv");
ob_end_clean();
echo $str;
exit;

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>