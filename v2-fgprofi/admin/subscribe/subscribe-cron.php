<?
// echo"dddd";
// die("sss");
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/ext_www/v2-fgprofi";
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use \Bitrix\Highloadblock\HighloadBlockTable as HLBT;
?>
<main class="main">
	<div class="content">
		<div class="containered">
			<div class="sidebar">
				<div class="sidebar__name">Модерация</div>
				<ul class="sidebar__list">
					<li class="sidebar__item">
						<a class="sidebar__link" href="/admin/">Пользователи</a>
					</li>
					<li class="sidebar__item f_need_moderation">
						<a class="sidebar__link" href="/admin/queries_f/">Запросы физ.лица</a>
					</li>
					<li class="sidebar__item u_need_moderation">
						<a class="sidebar__link" href="/admin/queries_u/">Запросы юр.лица</a>
					</li>
					<li class="sidebar__item active">
						<a class="sidebar__link" href="/admin/report">Отчет</a>
					</li>
					<li class="sidebar__item">
	                    <a class="sidebar__link"
	                       href="/support/">Техподдержка</a>
	                </li>
	                <li class="sidebar__item">
	                    <a class="sidebar__link"
	                       href="/vote/">Опросы</a>
	                </li>
	                <li class="sidebar__item">
	                    <a class="sidebar__link"
	                       href="/admin/subscribe/">Рассылка</a>
					<li class="sidebar__item ">
						<a class="sidebar__link logout_href" href="#">Выход</a>
					</li>
				</ul>
			</div>
			<div class="main-content main-content__report">
				<?if(CModule::IncludeModule("iblock") && CModule::IncludeModule('highloadblock')){
					function GetEntityDataClass($HlBlockId) {
						if (empty($HlBlockId) || $HlBlockId < 1)
						{
							return false;
						}
						$hlblock = HLBT::getById($HlBlockId)->fetch();	
						$entity = HLBT::compileEntity($hlblock);
						$entity_data_class = $entity->getDataClass();
						return $entity_data_class;
					}
					function getRubric(){
						$entity_data_class = GetEntityDataClass(7);
						$rsData = $entity_data_class::getList(array(
						   'select' => array('*')
						));
						while($el = $rsData->fetch()){
						    $allRubric[$el["UF_XML_ID"]] = $el["UF_NAME"];
						}
						return $allRubric;
					}
					$thisTime = time();
					//echo "<pre>"; print_r($thisTime); echo "</pre>";
					$allRubric = getRubric();
					//echo "<pre>"; print_r($allRubric); echo "</pre>";
					$arSelect = Array(
						"ID", 
						"IBLOCK_ID", 
						"NAME", 
						"DATE_ACTIVE_FROM", 
						"DATE_ACTIVE_TO",
						"CREATED_USER_NAME",
						"PREVIEW_TEXT",
						"DETAIL_TEXT",
						"PROPERTY_*"
					);
					$el = new CIBlockElement;
					$arFilter = Array("IBLOCK_ID"=>15, "DATE_ACTIVE_TO" => false, "ACTIVE"=>"Y", "ACTIVE_DATE"=>"Y");
					$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
					while($ob = $res->GetNextElement()){ 
						$result = array();
						$result["FIELDS"] = $ob->GetFields();
						$result["PROP"] = $ob->GetProperties();
						$users = getUsers($result["PROP"]["USERS"]["VALUE"]);
						
						// $customEmails = $result["PROP"]["CUSTOM_EMAILS"]["VALUE"]["TEXT"];
						// $customEmails = explode(",", $customEmails);
						// //echo "<pre>"; print_r($customEmails); echo "</pre>";
						// foreach ($customEmails as $email) {
						// 	if($email != ""){
						// 		$email = trim($email);
						// 		$arEventFields = array(
						// 			"EMAIL_TO"=>$email,
						// 			"THEME"=>$result["FIELDS"]["NAME"],
						// 			"RUBRIC"=>$allRubric[$result["PROP"]["RUBRIC"]["VALUE"]],
						// 			"TEXT"=>$result["FIELDS"]["DETAIL_TEXT"]
						// 		);
						// 		if(CEvent::Send("SEND_MAILING", "s1", $arEventFields, "Y", "", array($result["PROP"]["FILE"]["VALUE"]))){
						// 			echo "Отправили рассылку на ".$email."<br>";
						// 		}
						// 	}
						// }
						foreach ($users as $user) {
							if($user["PROPERTY_EMAIL_VALUE"] != ""){
								$send = true;
								$realUserId = false;
								if($user["PROPERTY_FIZ_USER_ID_VALUE"]){
									$obU = $el->getByID($user["PROPERTY_FIZ_USER_ID_VALUE"])->getNextElement();
									$resU["props"] = $obU->getProperties();
									$realUserId = $resU["props"]["USER_ID"]["VALUE"];
									if($resU["props"]["PROOF_OF_MAILING"]["VALUE"] == ""){
										$send = false;
									}
								}else{
									$realUserId = $user["PROPERTY_USER_ID_VALUE"];
									if($user["PROPERTY_PROOF_OF_MAILING_VALUE"] == ""){
										$send = false;
									}
								}
								if($send){
									$rsUser = CUser::GetByID($realUserId);
									$arUser = $rsUser->Fetch();
									$arEventFields = array(
										"EMAIL_TO"=>$user["PROPERTY_EMAIL_VALUE"],
										"THEME"=>$result["FIELDS"]["NAME"],
										"RUBRIC"=>$allRubric[$result["PROP"]["RUBRIC"]["VALUE"]],
										"CATEGORY"=>"",
										"ID"=>$result["FIELDS"]["ID"],
										"TEXT"=>$result["FIELDS"]["DETAIL_TEXT"],
										"UNSUBSCRIBE"=>"<br><a href='/unsubscribe/".$arUser["CHECKWORD"]."/'>Отписатся от рассылки</a>",
									);
									if($result["PROP"]["CATEGORY_USERS"]["VALUE"] == "Юридические лица"){
										$arEventFields["CATEGORY"] = " (".$result["PROP"]["CATEGORY_USERS"]["VALUE"].")";
									}
									
									// echo "<pre>"; print_r($arEventFields); echo "</pre>";
									// echo "<pre>"; print_r($result["PROP"]["FILE"]["VALUE"]); echo "</pre>";
									if(CEvent::Send("SEND_MAILING", "s1", $arEventFields, "Y", "", array($result["PROP"]["FILE"]["VALUE"]))){
										echo "Отправили рассылку на ".$user["PROPERTY_EMAIL_VALUE"]."<br>";
										
									}
								}
							}
						}
						$arLoadProductArray = Array(
							"DATE_ACTIVE_TO"    => date($DB->DateFormatToPHP(CSite::GetDateFormat()), time()),
						);
						//echo "<pre>"; print_r($arLoadProductArray); echo "</pre>";
						if($el->Update($result["FIELDS"]["ID"], $arLoadProductArray)){
							echo "Обновили рассылку<br>";
						}
						
						$arResult[$result["FIELDS"]["ID"]] = $result;
					}
					//echo "<pre>"; print_r($emails); echo "</pre>";
				}?>
			</div>
		</div>
	</div>
</main>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>