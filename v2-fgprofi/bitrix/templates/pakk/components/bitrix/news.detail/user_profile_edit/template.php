<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="result"></div>
<form action="" class="ps_center">
	<input type="hidden" name="PROFILE_ID" value="<?=$arResult["ID"]?>">
	<input type="hidden" name="PROFILE_IB" value="<?=$arResult["IBLOCK_ID"]?>">
	<div class="input_box">
		<div class="label_box">
			<label for="first_name">Имя</label>
		</div>
		<input type="text" name="NAME" value="<?=$arResult["NAME"]?>" placeholder="Имя">
	</div>
	<?
	$arPropHidden = explode(",", $arResult["PROPERTIES"]["HIDDEN_VIEW"]["VALUE"]);
	foreach ($arParams["PROPERTY_CODE_VIEW"] as $prop) {
		$arPropVal = $arResult["DISPLAY_PROPERTIES"][$prop];
		$arProp = $arResult["PROPERTIES"][$prop];?>
		<?$prop_name = "PROPERTY_".$arProp["CODE"];?>
		<?//echo "<pre>"; print_r($arParams["PROPERTY_CODE_VIEW_USER"]); echo "</pre>";?>
		<?if(in_array($prop, $arParams["PROPERTY_CODE_VIEW_USER"])):?>
			<div class="input_box checkbox">
				<?
				$check = "";
				if(in_array($arProp["ID"], $arPropHidden)):?>
					<?$check = ' checked="checked"';?>
					<input type="checkbox"<?=$check?> value="<?=$arProp["ID"];?>" name="PROPERTY_HIDDEN_VIEW[]" id="VIEW_<?=$prop_name?>">
				<?else:?>
					<input type="checkbox" value="<?=$arProp["ID"];?>" name="PROPERTY_HIDDEN_VIEW[]" id="VIEW_<?=$prop_name?>">
				<?endif;?>
				
				<label for="VIEW_<?=$prop_name?>">
					Не показать <?=$arProp["NAME"]?>
				</label>
			</div>
		<?endif;?>
		<?if($arProp["PROPERTY_TYPE"] == "S"):?>
			<?if($arProp["MULTIPLE"] == "N"):?>
				<?if($arProp["ROW_COUNT"]>1):?>
					<?$InpVal = "";
					if($arProp["VALUE"] != ""){
						$InpVal = $arProp["VALUE"];
					}?>
					<div class="input_box">
						<div class="label_box">
							<label for="<?=$arProp["CODE"]?>"><?=$arProp["NAME"]?></label>
						</div>
						<textarea name="<?=$prop_name?>" placeholder="<?=$arProp["NAME"]?>"><?=$InpVal?></textarea>
					</div>
				<?else:?>
					<?$InpVal = "";
					if($arProp["VALUE"] != ""){
						$InpVal = " value='".$arProp["VALUE"]."'";
					}?>
					<div class="input_box">
						<div class="label_box">
							<label for="<?=$arProp["CODE"]?>"><?=$arProp["NAME"]?></label>
						</div>
						<input type="text" name="<?=$prop_name?>"<?=$InpVal?> placeholder="<?=$arProp["NAME"]?>">
					</div>
				<?endif;?>
			<?else:?>
				<div class="input_box multi_field_text">
					<div class="label_box">
						<label for="soc"><?=$arProp["NAME"]?></label>
					</div>
					<div class="multi_field_text_input">
						<input type="text" name="<?=$prop_name?>[]" placeholder="<?=$arProp["NAME"]?>">
						<div class="multi_field_text_plus">+</div>
					</div>
					<?if($arProp["VALUE"] != ""):?>
						<?foreach($arProp["VALUE"] as $val):?>
							<?
							$valText = "";
							if($arProp["USER_TYPE"] == "UserID"){
								$rsUser = CUser::GetByID($val);
								$arUser = $rsUser->Fetch();
								$valText = '<div class="user_desc">'.$arUser["LOGIN"]." [id:".$arUser["ID"]."]".'</div>';
								//echo "<pre>"; print_r($arUser); echo "</pre>";
							}?>
							<div class="multi_field_text_input">
								<input type="text" name="<?=$prop_name?>[]" value="<?=$val?>"><?=$valText?>
								<div class="multi_field_text_minus">-</div>
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
			<?endif;?>
		<?endif;?>
		<?if($arProp["PROPERTY_TYPE"] == "F"):?>
			<div class="input_box">
				<?if(isset($arPropVal['FILE_VALUE']['SRC'])):?>
					<div class="user_photo">
						<img src="<?=$arPropVal['FILE_VALUE']['SRC']?>" alt="<?=$arResult["NAME"]?>">
					</div>
				<?endif;?>
				<?$APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
				   array(
				      "INPUT_NAME"=>$prop_name,
				      "MULTIPLE"=>$arProp["MULTIPLE"],
				      "MODULE_ID"=>"main",
				      "MAX_FILE_SIZE"=>"",
				      "ALLOW_UPLOAD"=>"A", 
				      "ALLOW_UPLOAD_EXT"=>""
				   ),
				   false
				);?>
			</div>
		<?endif;?>
		<?if($arProp["PROPERTY_TYPE"] == "E"):?>
			<?$arOptions = getRubricators($arProp['LINK_IBLOCK_ID']);


			?>
			<?
			$mult = "";
			if($arProp["MULTIPLE"] != "N"){
				 $mult = " class='multi_select' multiple='multiple'";
			}?>
			<?
			$arVal = array();
			if($arProp["VALUE"] != ""){
				foreach ($arPropVal["LINK_ELEMENT_VALUE"] as $value) {
					$arVal[$value["CODE"]] = $value["CODE"];
				}
			}?>
			
			<div class="input_box">
				<div class="label_box">
					<label for="<?=$arProp["CODE"]?>"><?=$arProp["NAME"]?></label>
				</div>
				<select name="<?=$prop_name?>"<?=$mult?>>
					<?foreach($arOptions as $opt):?>
						<?
						if($opt["CODE"] == 0){
							continue;
						}
						$check = "";
						if($arVal[$opt["CODE"]]){
							$check = " selected";
						}
						?>
						<option value="<?=$opt["ID"]?>"<?=$check?>><?=$opt["NAME"]?></option>
					<?endforeach;?>
				</select>
			</div>
			<?if(isset($arParams["PROPERTY_GROOP"][$arProp["CODE"]])):?>
				<?$arPropGroop = $arResult["PROPERTIES"][$arParams["PROPERTY_GROOP"][$arProp["CODE"]]];
				$prop_name_groop = "PROPERTY_".$arPropGroop["CODE"];?>
				<?if($arPropGroop["MULTIPLE"] == "N"):?>
					<?$InpVal = "";
					if($arPropGroop["VALUE"] != ""){
						$InpVal = " value='".$arPropGroop["VALUE"]."'";
					}?>
					<div class="input_box">
						<div class="label_box">
							<label for="<?=$arPropGroop["CODE"]?>"><?=$arPropGroop["NAME"]?></label>
						</div>
						<input type="text" name="<?=$prop_name_groop?>"<?=$InpVal?> placeholder="<?=$arPropGroop["NAME"]?>">
					</div>
				<?else:?>
					<div class="input_box multi_field_text">
						<div class="label_box">
							<label for="<?=$prop_name_groop?>"><?=$arPropGroop["NAME"]?></label>
						</div>
						<div class="multi_field_text_input">
							<input type="text" name="<?=$prop_name_groop?>[]" placeholder="<?=$arPropGroop["NAME"]?>">
							<div class="multi_field_text_plus">+</div>
						</div>
						<?if($arPropGroop["VALUE"] != ""):?>
							<?foreach($arPropGroop["VALUE"] as $val):?>
								<div class="multi_field_text_input">
									<input type="text" name="<?=$prop_name_groop?>[]" value="<?=$val?>">
									<div class="multi_field_text_minus">-</div>
								</div>
							<?endforeach;?>
						<?endif;?>
					</div>
				<?endif;?>
			<?endif;?>
		<?endif;?>
		<?if($arProp["PROPERTY_TYPE"] == "L"):?>
			<?
			$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>$arProp["CODE"]));
			$enum_fields = $property_enums->GetNext()
			?>
			<div class="input_box checkbox">
				<?
				$check = "";
				if($arProp["VALUE"] != ""):?>
					<?$check = ' checked="checked"';?>
				<?else:?>
					<input value='' class='empty_val' type='hidden' name='<?=$prop_name?>'>
				<?endif;?>
				<input type="checkbox"<?=$check?> value="<?=$enum_fields["ID"];?>" name="<?=$prop_name?>" id="<?=$prop_name?>">
				<label for="<?=$prop_name?>">
					<?=$arProp["NAME"]?>
				</label>
			</div>
		<?endif;?>
		<?
	}
	?>
	<div class="btn_form_send">Сохранить</div>
</form>
<?//echo "<pre>"; print_r($arPropHidden); echo "</pre>";?>