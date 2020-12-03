<?
//ini_set('mbstring.func_overload' , 0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("support");
$arThemes = getSupportThemes();
$arThemes[] = array(
	"UF_NAME_THEME" => "Опрос",
    "UF_CODE" => 1300
);
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
header('Content-Disposition: attachment;filename="report_all_questions('.$thisDate.').xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objPHPExcel->getProperties()->setCreator("fgprofi")
                             ->setLastModifiedBy("fgprofi")
                             ->setTitle("Office 2007 XLSX Report Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Report document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Report mailing");


$arFilter = array(
	//"SITE_ID"=>"s1"
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
$arHeads = array(
	"A"=>"Тикет", 
	"B"=>"Переписка"
);
foreach ($arThemes as $theme) {
	if(!$arResult[$theme["UF_CODE"]]){
		continue;
	}
	$objWorkSheet = $objPHPExcel->createSheet($numList);
	$rowNum = 1;
	foreach ($arHeads as $col => $colTitle) {
		//$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		$objWorkSheet->setCellValue($col.$rowNum, $colTitle);
	}
	foreach($arResult[$theme["UF_CODE"]] as $ticket){
		if($ticket["MESSAGES_TEXT"]){
			$strMess = "";
			foreach ($ticket["MESSAGES_TEXT"] as $mess) {
				if($mess["OWNER_EMAIL"]){
					$strMess .= $mess["OWNER_EMAIL"]."\r".textTransform($mess["MESSAGE"])."\r\r";
				}else{
					if($theme["UF_CODE"] == 1300){
						$strExplod = "<support@fgprofi.ru>";
						if(stristr($mess["MESSAGE"], $strExplod) !== FALSE) {
							$messData .= stristr($mess["MESSAGE"], $strExplod, true);
						}
						$strMess .= textTransform($messData);
					}
				}
			}
			$rowNum++;
			$objWorkSheet->setCellValue("A".$rowNum, $ticket["TITLE"]."(".$ticket["ID"].")");
			$objWorkSheet->setCellValue("B".$rowNum, $strMess);
			$objWorkSheet->getStyle("B".$rowNum)->getAlignment()->setWrapText(true);
		}
	}
	if(strlen($theme["UF_NAME_THEME"])>26){
		$objWorkSheet->setTitle(mb_strimwidth($theme["UF_NAME_THEME"], 0, 25, "..."));
	}else{
		$objWorkSheet->setTitle($theme["UF_NAME_THEME"]);
	}

	$objWorkSheet->getColumnDimension("A")->setAutoSize(true);
	$objWorkSheet->getColumnDimension("B")->setAutoSize(true);
	$numList++;
}
$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
$objWriter->save('php://output');



?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>