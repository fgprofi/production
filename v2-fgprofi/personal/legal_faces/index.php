<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
if(!isset($USER_PROP["PROFILE_LEGAL_FACES"]) || count($USER_PROP["PROFILE_LEGAL_FACES"])<=0){
	LocalRedirect("/personal/fiz_faces/");
}
$APPLICATION->SetTitle("Настройки пользователя");?>
<div class="ps_center">
	Профиль юр. лица<br><?
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
		<a href="/personal/legal_faces/<?=$ob['ID']?>/"><?=$ob['NAME']?></a><br>
	<?}
}
?>
</div>
<?//echo "<pre>"; print_r($arResult); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>