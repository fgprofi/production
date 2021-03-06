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

date_default_timezone_set('Europe/London');
require_once $_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/PHPExcel.php";/* подключаем класс */
//PhpOffice\PhpSpreadsheet\Spreadsheet // assuming 
$objPHPExcel = new PHPExcel();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$thisDate = date("d-m-Y", time());
header('Content-Disposition: attachment;filename="report_all_mailing('.$thisDate.').xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objPHPExcel->getProperties()->setCreator("fgprofi")
                             ->setLastModifiedBy("fgprofi")
                             ->setTitle("Office 2007 XLSX Report Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Report document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Report mailing");

$ob = CIBlockElement::getList(array(),array("IBLOCK_ID"=>15, "GLOBAL_ACTIVE"=>"N"),false,false,array("ID", "IBLOCK_ID", "NAME","DETAIL_TEXT","PROPERTY_USERS","PROPERTY_RUBRIC"));
$numList = 0;
$arHeads = array(
	"ID Рассылки", 
	"Рассылка",
	"Дата, время",
	"Тема:",
	"Текст:",
	"Прикрепленые файлы:",
	"Получатели:",
);
$arCol = array(
	"A" => "Получатель",
	"B" => "Ответ",
	"C" => "Дата, время",
	"D" => "Почта получателя",
	"E" => "Прикрепление",
);
$arColProp = array(
	"A" => "OWNER_SID",
	"B" => "MESSAGE",
	"C" => "DATE_CREATE",
	"D" => "OWNER_EMAIL",
	"E" => "FILE",
);
while($resList = $ob->GetNextElement()){
	$arData["PROP"] = $resList->GetProperties();
	$arData["FIELDS"] = $resList->GetFields();
	$arResult["ITEMS"][$arData["FIELDS"]["ID"]] = $arData;
	$arDataHeader = array(
		$arData["FIELDS"]["ID"],
		"№".$arData["PROP"]["COUNTER"]["VALUE"],
		$arData["PROP"]["DATE_SEND"]["VALUE"],
		$arData["FIELDS"]["NAME"],
		$arData["FIELDS"]["DETAIL_TEXT"],
		$arData["PROP"]["FILE"]["VALUE"],
		$arData["PROP"]["USERS"]["VALUE"],
	);
	$arResult["HEADERS"][$arData["FIELDS"]["ID"]] = $arDataHeader;
}
$strExplod = "<support@fgprofi.ru>";
// echo "<pre>"; print_r($arResult["ITEMS"]); echo "</pre>";
// die();
foreach($arResult["ITEMS"] as $mailingId => $mailing){	
	$arMailingProps = $mailing["PROP"];
	$arMailingFields = $mailing["FIELDS"];
	$objWorkSheet = $objPHPExcel->createSheet($numList);
	$colNum = 1;
	foreach ($arHeads as $col => $colTitle) {
		//$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		$objWorkSheet->setCellValue('A'.$colNum, $colTitle);
		if(is_array($arResult["HEADERS"][$mailingId][$col])){
			$arContentCol = array();
			foreach ($arResult["HEADERS"][$mailingId][$col] as $id) {
				$res = CIBlockElement::GetByID($id);
				if($ar_res = $res->GetNext()){
					$arContentCol[] = $ar_res["NAME"];
				}
			}
			$objWorkSheet->setCellValue('B'.$colNum, implode(";", $arContentCol));
		}else{
			$objWorkSheet->setCellValue('B'.$colNum, $arResult["HEADERS"][$mailingId][$col]);
		}
		
		$objWorkSheet->getStyle("A".$colNum)->getAlignment()->setWrapText(true);
		$objWorkSheet->getStyle("B".$colNum)->getAlignment()->setWrapText(true);
		$colNum++;
	}
	foreach ($arCol as $keyCol => $colTitle) {
		$objWorkSheet->setCellValue($keyCol.$colNum, "");
	}
	$colNum++;
	foreach ($arCol as $keyCol => $colTitle) {
		$objWorkSheet->setCellValue($keyCol.$colNum, $colTitle);
	}
	$colNum++;
	$arUsers = getUsers($arMailingProps["USERS"]["VALUE"]);
	$thisRubric = $arRubric[$arMailingProps["RUBRIC"]["VALUE"]]["UF_NAME"];

	foreach ($arUsers as $key => $user) {
		$arFilter = Array(
			"TITLE"=> "%<".$arMailingFields["ID"].">%",
			"OWNER"=>$user["PROPERTY_USER_ID_VALUE"],
		);
		$by = "s_id";
		$order = "asc";


		$tickets = CTicket::GetList($by, $order, $arFilter, $is_filtered);
		$strTicket = "";
		$arTicket = "";
		$arDataMSG = array();
		while($ar = $tickets->Fetch()) 
		{
			$arTicket = $ar;
			$strTicket = "Тикет: ".$arTicket["TITLE"]." (".$arTicket["ID"].")\r";
			$mess = CTicket::GetMessageList($by, $order, array("TICKET_ID" => $arTicket["ID"],"IS_MESSAGE" => "Y"), $c, $CHECK_RIGHTS);
			
			while($arMess = $mess->Fetch())
			{
				$msg_date = date('d.m.Y',strtotime($mailing['PROP']['DATE_SEND']['VALUE']));
				preg_match('|([A-Za-zа-яА-Я0-9][\s\S][A-Za-zа-яА-Я0-9]*?)[\s\S]*?'.$msg_date.'|',$arMess['MESSAGE'],$matches,PREG_UNMATCHED_AS_NULL);
				if(trim(str_replace($msg_date,'',$matches[0]))){
					$msg = trim(str_replace($msg_date,'',$matches[0]));
				}else{
					$msg = $arMess['MESSAGE'];
				}
				if(!$arMess['OWNER_SID']){
					$arMess['OWNER_SID'] = "Администратор";
				}
				$arDataMSG[$arTicket["ID"]][] = array(
					'DATE_CREATE' => $arMess["DATE_CREATE"],
					'OWNER_EMAIL' => $arMess['OWNER_EMAIL'],
					'OWNER_SID' => $arMess['OWNER_SID'],
					'MESSAGE' => $msg,
					'FILE' => "",
				);

			}foreach ($arDataMSG[$arTicket["ID"]] as $keyM => $arDataMSGItem) {
				$indexAr = 0;
				foreach ($arColProp as $keyCol => $colProp) {
					$objWorkSheet->setCellValue($keyCol.$colNum, $arDataMSGItem[$colProp]);
					$indexAr++;
				}
				$colNum++;
			}
			
			
			foreach ($arCol as $keyCol => $colTitle) {
				$objWorkSheet->setCellValue($keyCol.$colNum, "");
			}
			$colNum++;
		}
	}
	if(strlen($arMailingFields["NAME"])>26){
		$objWorkSheet->setTitle(mb_strimwidth($arMailingFields["NAME"], 0, 25, "..."));
	}else{
		$objWorkSheet->setTitle($arMailingFields["NAME"]);
	}


	// $objWorkSheet->getColumnDimension("A")->setAutoSize(true);
	// $objWorkSheet->getColumnDimension("B")->setAutoSize(true);
	// //foreach($objWorkSheet->getRowDimensions() as $rd) { $rd->setRowHeight(-1); }
	$numList++;
}

$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
$objWriter->save('php://output');



?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>