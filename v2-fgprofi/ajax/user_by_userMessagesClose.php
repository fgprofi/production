<?
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["itemId"]) && $_REQUEST["itemId"]!=""){
	if(CModule::IncludeModule('highloadblock'))
	{
		$hlbl = 4;
		$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch(); 

		$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
		$entity_data_class = $entity->getDataClass(); 


		// Массив полей для обновления
		$data = array(
			"UF_NOTIFICATION"=>1
		);

		$result = $entity_data_class::update($_REQUEST["itemId"], $data);
		//echo "<pre>"; print_r($result); echo "</pre>";
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>