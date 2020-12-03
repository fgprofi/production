<?
//ini_set('mbstring.func_overload' , 0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("support");
$arThemes = getSupportThemes();
// $arThemes[] = array(
// 	"UF_NAME_THEME" => "Опрос",
//     "UF_CODE" => 1300
// );
$arThemes[] = array(
	"UF_NAME_THEME" => "Без категории",
    "UF_CODE" => 0
);
$data = $_REQUEST;
function textTransform($str){
	$str = str_replace(chr(38), "", $str);
	$str = str_replace("&quot;", "", $str);
	$str = str_replace("quot;", "", $str);
	$str = str_replace('"', "", $str);
	$str = htmlspecialchars_decode(str_replace(array('\"'),'',$str));
	return $str;
}
date_default_timezone_set('Europe/London');
require_once $_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/PHPExcel.php";
$objPHPExcel = new PHPExcel();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$thisDate = date("d-m-Y", time());
header('Content-Disposition: attachment;filename="report_questions_'.$data["rubric_id"].'('.$thisDate.').xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objPHPExcel->getProperties()->setCreator("fgprofi")
                             ->setLastModifiedBy("fgprofi")
                             ->setTitle("Office 2007 XLSX Report Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Report document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Report mailing");
$arCol = array(
	array("KEY"=>"A", "TITLE"=>"ID обращения", "CODE"=>"TICKET_ID"),
	array("KEY"=>"B", "TITLE"=>"Заголовок (тикет)", "CODE"=>"TICKET_TITLE"),
	array("KEY"=>"C", "TITLE"=>"ФИО", "CODE"=>"OWNER_NAME"),
	array("KEY"=>"D", "TITLE"=>"Почта", "CODE"=>"OWNER_EMAIL"),
	array("KEY"=>"E", "TITLE"=>"Вопрос", "CODE"=>"MESSAGE", "CODE_FIELD"=>"MESSAGE", "TYPE_MESS"=>"QUESTION"),
	array("KEY"=>"F", "TITLE"=>"Прикрепление", "CODE"=>"MESSAGE", "CODE_FIELD"=>"FILE", "TYPE_MESS"=>"QUESTION"),
	array("KEY"=>"G", "TITLE"=>"Дата вопроса", "CODE"=>"MESSAGE", "CODE_FIELD"=>"DATE_CREATE", "TYPE_MESS"=>"QUESTION"),
	array("KEY"=>"H", "TITLE"=>"Ответ", "CODE"=>"MESSAGE", "CODE_FIELD"=>"MESSAGE", "TYPE_MESS"=>"ANSWER"),
	array("KEY"=>"I", "TITLE"=>"Дата ответа", "CODE"=>"MESSAGE", "CODE_FIELD"=>"DATE_CREATE", "TYPE_MESS"=>"ANSWER"),
	array("KEY"=>"J", "TITLE"=>"ФИО Консультанта", "CODE"=>"MESSAGE", "CODE_FIELD"=>"NAME", "TYPE_MESS"=>"ANSWER"),
);
$arFilter = array(
	//"SITE_ID"=>"s1"
);
if(isset($data["rubric_id"]) && $data["rubric_id"] != ""){
	$arFilter["CATEGORY_SID"] = $data["rubric_id"];
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
//echo "<pre>"; print_r($arThemes); echo "</pre>";
//echo "<pre>"; print_r($arResult); echo "</pre>";
//die();
$numList = 0;
$data = $_REQUEST;
foreach ($arThemes as $theme) {
	if(!$arResult[$theme["UF_CODE"]]){
		continue;
	}
	$objWorkSheet = $objPHPExcel->createSheet($numList);
	$rowNum = 1;
	foreach ($arCol as $key => $col) {
		$objWorkSheet->setCellValue($col["KEY"].$rowNum, $col["TITLE"]);
		$objWorkSheet->getColumnDimension($col["KEY"])->setAutoSize(true);
	}
	$rowNum++;
	foreach($arResult[$theme["UF_CODE"]] as $ticket){
		
		if($ticket["MESSAGES_TEXT"]){
			
			$arThemesTicket = array(
				"TICKET_ID" => $ticket["ID"],
				"TICKET_TITLE" => $ticket["TITLE"],
			);

			$arThemesTicket["OWNER_NAME"] = $ticket["OWNER_NAME"];
			//echo "<pre>"; print_r($ticket["OWNER_NAME"]); echo "</pre>";
			if(trim($ticket["OWNER_NAME"]) == ""){
				if($ticket["UF_AUTOR_FIO"]){
					$arThemesTicket["OWNER_NAME"] = $ticket["UF_AUTOR_FIO"];
				}else{
					$arThemesTicket["OWNER_NAME"] = $ticket["OWNER_SID"];
				}
			}
			$arThemesTicket["OWNER_EMAIL"] = $ticket["OWNER_EMAIL"];
			if(trim($ticket["OWNER_EMAIL"]) == ""){
				$arThemesTicket["OWNER_EMAIL"] = $ticket["OWNER_SID"];
			}
			$arThemesTicket["MESSAGE"] = $ticket["MESSAGES_TEXT"];
			$arResult["DATA"][$theme["UF_CODE"]][] = $arThemesTicket;
		}
	}
	//echo "<pre>"; print_r($arResult["DATA"][$theme["UF_CODE"]]); echo "</pre>";
	foreach ($arResult["DATA"][$theme["UF_CODE"]] as $ticket) {
		foreach ($arCol as $col) {
			if(!is_array($ticket[$col["CODE"]])){
				if($col["CODE"] == "OWNER_EMAIL" && trim($ticket[$col["CODE"]]) == ""){
					$ticket[$col["CODE"]] = $ticket["OWNER_SID"];
				}
				$objWorkSheet->setCellValue($col["KEY"].$rowNum, $ticket[$col["CODE"]]);
			}else{
				if($col["TYPE_MESS"] == "ANSWER"){
					$objWorkSheet->setCellValue($col["KEY"].$rowNum, "");
				}else{
					$objWorkSheet->setCellValue($col["KEY"].$rowNum, $ticket[$col["CODE"]][0][$col["CODE_FIELD"]]);
				}
			}
		}
		$rowNum++;
		unset($ticket["MESSAGE"][0]);
		foreach ($ticket["MESSAGE"] as $arMes) {
			$arMes["FILE"] = "";
			if($arMes["IS_LOG"] == "Y"){
				continue;
			}
			foreach ($arCol as $col) {
				if($col["CODE"] != "MESSAGE"){
					$objWorkSheet->setCellValue($col["KEY"].$rowNum, "");
				}else{
					if($col["CODE"] == "OWNER_EMAIL" && trim($arMes[$col["CODE"]]) == ""){
						$arMes[$col["CODE"]] = $arMes["OWNER_SID"];
					}
					if($ticket["OWNER_EMAIL"] != $arMes["OWNER_EMAIL"]){
						if($col["TYPE_MESS"] == "QUESTION"){
							$objWorkSheet->setCellValue($col["KEY"].$rowNum, "");
						}else{
							$objWorkSheet->setCellValue($col["KEY"].$rowNum, $arMes[$col["CODE_FIELD"]]);
						}
					}else{
						if($col["TYPE_MESS"] == "QUESTION"){
							$objWorkSheet->setCellValue($col["KEY"].$rowNum, $arMes[$col["CODE_FIELD"]]);
						}else{
							$objWorkSheet->setCellValue($col["KEY"].$rowNum, "");
						}
					}
					
				}
			}
			$rowNum++;
		}
		$rowNum++;
	}
	if(strlen($theme["UF_NAME_THEME"])>26){
		$objWorkSheet->setTitle(mb_strimwidth($theme["UF_NAME_THEME"], 0, 25, "..."));
	}else{
		$objWorkSheet->setTitle($theme["UF_NAME_THEME"]);
	}
	$numList++;
}
$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
$objWriter->save('php://output');



?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>