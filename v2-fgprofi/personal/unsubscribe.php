<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arData = $_REQUEST;
if(CModule::IncludeModule("iblock")){
	$data = CUser::GetList(($by="ID"), ($order="ASC"), array(/*"ID"=>982,*/"CHECKWORD"=>$arData["CHECK"]), array("SELECT"=>array("UF_USER_INFO_TYPE_F","UF_USER_INFO_TYPE_U")));
	$profile = false;
	if($arUser = $data->Fetch()) {
		// echo "<pre>"; print_r($arUser); echo "</pre>";
		// die();
		if($arUser["UF_USER_INFO_TYPE_F"] != ""){
			$profile["fields"]["ID"] = $arUser["UF_USER_INFO_TYPE_F"];
			$profile["fields"]["IBLOCK_ID"] = 7;
			$profile["realProfile"] = $arUser;
		}else{
			$profile = getResponsibleUFace($arUser["UF_USER_INFO_TYPE_U"]);
		}
		if($profile["fields"]["ID"]){
			CIBlockElement::SetPropertyValuesEx(
				$profile["fields"]["ID"],
				$profile["fields"]["IBLOCK_ID"],
				array(
					"PROOF_OF_MAILING" => false
				)
			);
			?>
			<main class="main">
				<div class="content">
					<div class="containered">
						<?=$profile["realProfile"]["NAME"]?> ваш профиль(<?=$profile["realProfile"]["LOGIN"]?>) отписан от рассылки!
					</div>
				</div>
			</main>
			<?
		}
	}else{
		header('/');
	}
}
//echo "<pre>"; print_r($profile); echo "</pre>";
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>