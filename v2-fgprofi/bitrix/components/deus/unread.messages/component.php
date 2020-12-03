<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponent $this
 */
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)
	die();

if ($USER->IsAuthorized()){
	if(CModule::IncludeModule("iblock") && CModule::IncludeModule('support') && CModule::IncludeModule("highloadblock"))
	{
		global $USER;

		$arFilter = array(
		    "!LAST_MESSAGE_BY_SUPPORT_TEAM" => "Y",
		);
		if(!isAdministrator()){
			$arFilter["OWNER"] = $USER->getID();
		}else{
			$arFilter["RESPONSIBLE_ID"] = $USER->getID();
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
		if($arParams["DEBUG"] == "Y" && $USER->getID() == 1){
			//echo '<pre>';print_r($arFilter);echo '</pre>';
			//echo '<pre>';print_r($ar["ONLINE"][$USER->getID()]);echo '</pre>';
	    }
		while($ar = $rs->Fetch()) 
		{
		    $rsOnline = GetCustomOnline(intval($ar["ID"]));
		    //$rsOnline = CTicket::GetOnline(intval($ar["ID"]));
		    while ($arOnline = $rsOnline->GetNext())
		    {
		        $arOnline["INT_TIMESTAMP_X"] = MakeTimeStamp($arOnline["TIMESTAMP_X"]);
		        $ar["ONLINE"][$arOnline["USER_ID"]] = $arOnline;
		    }
		    $ar["TYPE"] = "TICKET";
		    $obMessages = GetTicketMessages($ar["ID"], array(), "Y");
		    $newTicket = true;
		    while($arMessage = $obMessages->Fetch()){
		        $arMessage["INT_TIMESTAMP_X"] = MakeTimeStamp($arMessage["TIMESTAMP_X"]);
		        if($arMessage["OWNER_USER_ID"] == $USER->getID()){
		        	$newTicket = false;
		        }
		        $arMessages[] = $arMessage;
		    }
		    $lastMess = array_pop($arMessages);
		    
		    
		    if((!isset($ar["ONLINE"][$USER->getID()])  && $lastMess["OWNER_USER_ID"] != $USER->getID()) || ($ar["ONLINE"][$USER->getID()]["INT_TIMESTAMP_X"] < $lastMess["INT_TIMESTAMP_X"] && $lastMess["OWNER_USER_ID"] != $USER->getID())){
		        $lastMess["MESSAGE"] = str_replace("<li>", ", ", $lastMess["MESSAGE"]);

		        $lastMess["MESSAGE"] = trim($lastMess["MESSAGE"]);
		        $lastMess["MESSAGE"] = trim($lastMess["MESSAGE"], ", ");
		        $stringMess = strip_tags($lastMess["MESSAGE"]);
				// if($arParams["DEBUG"] == "Y"){
				// 	echo '<pre>';print_r($lastMess["MESSAGE"]);echo '</pre>';
				// 	echo '<pre>';print_r($stringMess);echo '</pre>';
				// 	die();
				// }
		        //$stringMess = $lastMess["MESSAGE"];
		        if(strlen($stringMess) > 150){
		            $stringMess = mb_substr($stringMess,0,152,'UTF-8');
		            $stringMess = rtrim($stringMess, "!,.-");

		            $stringMess = substr($stringMess, 0, strrpos($stringMess, ' '));
		            $stringMess = $stringMess."...";
		        }
		        $ar["MESS"] = $stringMess;
		        $ar["MESS_TITLE"] = $arParams["TITLE_TYPE_MESS"][$ar["TYPE"]].", собщение от ".$ar["LAST_MESSAGE_NAME"]." в обращении ".$ar["TITLE"]." (№".$ar["ID"].")";
		        if($newTicket){
		        	$ar["NEW_TICKET"] = "Y";
		        	$ar["MESS_TITLE"] = $arParams["TITLE_TYPE_MESS"][$ar["TYPE"]].", создано новое обращение (№".$ar["ID"].")";
		        }
		        $ar["USER_INFO"] = getInitialsOrPhoto($lastMess["OWNER_USER_ID"]);
		        //$ar["USER_INFO"] = getInitialsOrPhoto(304);
		        $arResult["MESSAGE"][$lastMess["INT_TIMESTAMP_X"]] = $ar;
		    }
		}

		
		$arSelect = array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"ACTIVE_TO",
			"PROPERTY_USERS",
			"PROPERTY_RUBRIC",
			"PROPERTY_NOTIFIED_USERS",
			"PROPERTY_COUNTER"
		);
		$thisDate = ConvertTimeStamp(false, "FULL", "ru");
		$USER_PROP = needAuth('/freg/', false, true);
		// if($arParams["DEBUG"] == "Y" && $USER->getID() == 1){
		// 	$arResult["MESSAGE"] = array();
		// 	$USER_PROP["ID_USER_INFO"] = 511;
		// }
		if(isset($USER_PROP["ID_USER_INFO"]) && $USER_PROP["ID_USER_INFO"] != ""){
			$userID = $USER_PROP["ID_USER_INFO"];

			$arFilter = array(
				"IBLOCK_ID"=>15,
				array(
					"LOGIC"=>"AND",
					array(
						"<DATE_ACTIVE_TO"=>$thisDate,
						"!DATE_ACTIVE_TO"=>false,
					),
				),
				// array(
				// 	"LOGIC"=>"AND",
				// 	array(
				// 		"PROPERTY_USERS"=>array($userID),
				// 		"!PROPERTY_NOTIFIED_USERS"=>array($userID),
				// 	),
				// ),
				
			);
			$arResult["DATA"] = array();
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	        while ($ob = $res->GetNextElement()) {
				$arRes["FIELDS"] = $ob->GetFields();
				$arRes["PROPS"] = $ob->GetProperties();
				if(in_array($userID, $arRes["PROPS"]["NOTIFIED_USERS"]["VALUE"]) || !in_array($userID, $arRes["PROPS"]["USERS"]["VALUE"])){
					continue;
				}
				$arMessMailer["ACTIVE_TO"] = $arRes["FIELDS"]["ACTIVE_TO"];
				$arMessMailer["TYPE"] = "MAILING";
				$arMessMailer["ID"] = $arRes["FIELDS"]["ID"];
				$arMessMailer["MESS_TITLE"] = 'Пожалуйста проверьте ваш почтовый ящик, вам была произведена рассылка "'.$arRes["FIELDS"]["NAME"].'" от '.$arRes["FIELDS"]["ACTIVE_TO"];
				$arMessMailer["USER_INFO"] = getInitialsOrPhoto(1);
				$arMessMailer["PROPS"]["NOTIFIED_USERS"] = $arRes["PROPS"]["NOTIFIED_USERS"];
				$arMessMailer["PROPS"]["USERS"] = $arRes["PROPS"]["USERS"];
	            $arResult["DATA"][$arRes["FIELDS"]["ID"]] = $arMessMailer;
	        }
	        foreach ($arResult["DATA"] as $key => $mess) {
	        	$intActiveTo = MakeTimeStamp($mess["ACTIVE_TO"]);
	        	$arResult["MESSAGE"][$intActiveTo] = $mess;
	        }
	        //if($arParams["DEBUG"] == "Y"){
		        $hlbl = 4; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
				$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch(); 

				$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
				$entity_data_class = $entity->getDataClass(); 

				$rsData = $entity_data_class::getList(array(
				   "select" => array("*"),
				   "order" => array("ID" => "ASC"),
				   "filter" => array("UF_USER_IN"=>$userID,"UF_NOTIFICATION"=>false)  // Задаем параметры фильтра выборки
				));

				while($arData = $rsData->Fetch()){
					$arMessUserByUser["ACTIVE_TO"] = $arData["UF_DATE"]->format($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")));
					$arMessUserByUser["TYPE"] = "USER_BY_USER";
					$arMessUserByUser["ID"] = $arData["ID"];
					
					//echo "<pre>"; print_r($arData); echo "</pre>";
					//$arData["UF_USER_OUT"] = 618;
					if($arData["UF_USER_OUT"] == 1){
						$arMessUserByUser["MESS_TITLE"] = 'Пожалуйста проверьте ваш почтовый ящик, пользователь Администратор отправил вам сообщение, от '.$arMessUserByUser["ACTIVE_TO"];
						$arInitialsOrPhoto = getInitialsOrPhoto(1);
					}else{
						$resUfUserOut = CIBlockElement::GetByID($arData["UF_USER_OUT"]);
						if($ar_resUfUserOut = $resUfUserOut->GetNext()){
							$UfUserOutInfo = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$ar_resUfUserOut["IBLOCK_ID"], "ID"=>$ar_resUfUserOut["ID"]), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FIRST_NAME", "PROPERTY_MIDDLENAME"));
						    if ($obUfUserOutInfo = $UfUserOutInfo->GetNextElement()) {
						        $arUfUserOutInfos["FIELDS"] = $obUfUserOutInfo->GetFields();
						        $arUfUserOutInfo["PROPS"] = $obUfUserOutInfo->GetProperties();
						    }
						    $strUfUserOut = 'пользователь "'.$arUfUserOutInfos["FIELDS"]["NAME"].'"';
						    $arMessUserByUser["MESS_TITLE"] = 'Пожалуйста проверьте ваш почтовый ящик, '.$strUfUserOut.' отправил вам сообщение, от '.$arMessUserByUser["ACTIVE_TO"];
						    //echo "<pre>"; print_r($arUfUserOutInfos["FIELDS"]); echo "</pre>";
							//echo "<pre>"; print_r($ar_resUfUserOut); echo "</pre>";
							// $resRealUserOut = CIBlockElement::GetProperty($ar_resUfUserOut["IBLOCK_ID"], $ar_resUfUserOut["ID"], array("sort" => "asc"), Array("CODE"=>"USER_ID"));
							// if ($obRealUserOut = $resRealUserOut->GetNext()) {
							// 	$propRealUserOut = $obRealUserOut["VALUE"];
							// 	//echo "<pre>"; print_r($propRealUserOut); echo "</pre>";
							// }
							$arInitialsOrPhoto = getInitialsOrPhoto($arUfUserOutInfo["PROPS"]["USER_ID"]["VALUE"]);
						}
					}
					$arMessUserByUser["USER_INFO"] = $arInitialsOrPhoto;
					//$arMessUserByUser["PROPS"]["NOTIFIED_USERS"] = $arRes["PROPS"]["NOTIFIED_USERS"];
					//$arMessUserByUser["PROPS"]["USERS"] = $arRes["PROPS"]["USERS"];
					$arResult["MESSAGE"][$arData["UF_DATE"]->getTimestamp()] = $arMessUserByUser;
					// echo "<pre>"; print_r($arData["UF_DATE"]->getTimestamp()); echo "</pre>";
					// echo "<pre>"; print_r($arData["UF_DATE"]->format($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")))); echo "</pre>";
					// echo "<pre>"; print_r($arData); echo "</pre>";
				}
			//}
        }
        

	    rsort($arResult["MESSAGE"]);
	}
	$this->IncludeComponentTemplate();
}