<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["itemId"]) && $_REQUEST["itemId"]!=""){
	if(CModule::IncludeModule("iblock") && CModule::IncludeModule('support'))
	{
		global $USER;
		$USER_PROP = needAuth('/freg/', false, true);
		//$USER_PROP["ID_USER_INFO"] = 511;
		if(isset($USER_PROP["ID_USER_INFO"]) && $USER_PROP["ID_USER_INFO"] != ""){
			$obEl = new CIBlockElement();
			$mailing_id = $_REQUEST["itemId"];
			$propId = 105;
			$ib = 15;
			$thisUserId = $USER_PROP["ID_USER_INFO"];
			$mailing = $obEl->GetPropertyValues($ib, array('ID' => $mailing_id), false, array('ID' => array($propId)));
			$arUsers = array();
			while ($arMailing = $mailing->Fetch())
			{
				$arUsers = $arMailing[$propId];
			}
			if(!in_array($thisUserId, $arUsers)){
				$arUsers[] = $thisUserId;
			}
			
			//echo "<pre>"; print_r($arUsers); echo "</pre>";
			$ar = $obEl->SetPropertyValuesEx( $mailing_id, $ib, array( 'NOTIFIED_USERS' => $arUsers ) );
			// $ar->LAST_ERROR;
			// echo "<pre>"; print_r($ar); echo "</pre>";
		}
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>