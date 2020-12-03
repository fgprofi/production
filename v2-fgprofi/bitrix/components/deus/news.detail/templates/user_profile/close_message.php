<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["face"]) && strlen($_REQUEST["face"])>0){
	$file = 'close_message.json';
	$data = file_get_contents($file, true);
	$data = json_decode($data, true);
	if(!in_array($_REQUEST["face"], $data)){
		array_push($data, $_REQUEST["face"]);
		$data = json_encode($data);
		file_put_contents($file, $data);
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>