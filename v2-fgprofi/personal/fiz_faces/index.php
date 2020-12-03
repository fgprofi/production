<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
//echo "<pre>"; print_r($USER_PROP); echo "</pre>";
// if(!isset($USER_PROP["PROFILE_LEGAL_FACES"]) || count($USER_PROP["PROFILE_LEGAL_FACES"])<=0){
// 	LocalRedirect("/personal/");
// }
$APPLICATION->SetTitle("Настройки пользователя");?>
<div class="ps_center">
	Профиль Физ. лица<br><?
if(CModule::IncludeModule("iblock")){
	$arSelect = array(
		"ID",
		"NAME",
		"IBLOCK_ID"
	);
	$arFilter = array(
		"ID"=>$USER_PROP["PROFILE_LEGAL_FACES"]
	);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->Fetch()){?>
		<a href="/personal/fiz_faces/<?=$ob['ID']?>/"><?=$ob['NAME']?></a><br>
	<?}
}
?>
</div>
<?//echo "<pre>"; print_r($arResult); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>