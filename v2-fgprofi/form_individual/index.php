<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
if (!$USER->IsAuthorized()){
	LocalRedirect("/auth/");
}
$arResult["TARGET_AUDIENCE"] = getRubricators(16);
$arResult["COMPETENCIES"] = getRubricators(15);
$arResult["KOA"] = getRubricators(14);
$arResult["LANGUAGE"] = getRubricators(6);
$arResult["REGIONS"] = getRubricators(7);
?>
<form action="" class="ps_center">
	<div class="input_box">
		<div class="label_box">
			<label for="first_name">Имя</label>
		</div>
		<input type="text" name="first_name" placeholder="Имя">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="sur_name">Фамилия</label>
		</div>
		<input type="text" name="sur_name" placeholder="Фамилия">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="middle_name">Отчество</label>
		</div>
		<input type="text" name="middle_name" placeholder="Отчество">
	</div>
	<div class="input_box">
		<?$APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
		   array(
		      "INPUT_NAME"=>"SR_PHOTO",
		      "MULTIPLE"=>"Y",
		      "MODULE_ID"=>"main",
		      "MAX_FILE_SIZE"=>"",
		      "ALLOW_UPLOAD"=>"A", 
		      "ALLOW_UPLOAD_EXT"=>""
		   ),
		   false
		);?>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="date_of_birth">Дата рождения</label>
		</div>
		<input type="date" name="date_of_birth">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="education">Образование</label>
		</div>
		<select name="education">
			<option value="0">не выбрано</option>
			<option value="1">Высшее</option>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="language_skills">Владение языками</label>
		</div>
		<select name="language_skills" class="multi_select" multiple='multiple'>
			<?foreach($arResult["LANGUAGE"] as $lang):?>
				<option value="<?=$lang["CODE"]?>"><?=$lang["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="region_of_residence">Регион проживания</label>
		</div>
		<select name="region_of_residence">
			<?foreach($arResult["REGIONS"] as $region):?>
				<option value="<?=$region["CODE"]?>"><?=$region["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="locality">Населенный пункт</label>
		</div>
		<input type="text" name="locality" placeholder="Населенный пункт">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="phone">Телефон</label>
		</div>
		<input type="text" name="phone" placeholder="Телефон">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="email">Электронная почта (e-mail)</label>
		</div>
		<input type="text" name="email" placeholder="Электронная почта (e-mail)">
	</div>
	<div class="input_box multi_field_text">
		<div class="label_box">
			<label for="soc">Персональная интернет-страница, профили в соц.сетях</label>
		</div>
		<div class="multi_field_text_input">
			<input type="text" name="soc[]" placeholder="Персональная интернет-страница, профили в соц.сетях">
			<div class="multi_field_text_plus">+</div>
		</div>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="place_of_work">Место работы</label>
		</div>
		<input type="text" name="place_of_work" placeholder="Место работы">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="position">Должность</label>
		</div>
		<input type="text" name="position" placeholder="Должность">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="kind_of_activity">Вид деятельности</label>
		</div>
		<select name="kind_of_activity" class="multi_select" multiple='multiple'>
			<?foreach($arResult["KOA"] as $koa):?>
				<option value="<?=$koa["CODE"]?>"><?=$koa["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="financial_literacy_competencies">Компетенции в области финансовой грамотности</label>
		</div>
		<select name="financial_literacy_competencies" class="multi_select" multiple='multiple'>
			<?foreach($arResult["COMPETENCIES"] as $comp):?>
				<option value="<?=$comp["CODE"]?>"><?=$comp["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="target_audience">Целевая аудитория</label>
		</div>
		<div class="multi_check" data-name="target_audience[]">
			<?foreach($arResult["TARGET_AUDIENCE"] as $key => $target):?>
				<div class="check_select" data-value="<?=$target["CODE"]?>" data-id="<?=$key?>">
					<div class="check_select_title"><?=$target["NAME"]?></div>
					<?if($target["ID"] == 122):?>
						<div class="check_select_content">
							<?foreach($arResult["KOA"] as $key => $koa):?>
								<input type="checkbox" checked="checked" value="<?=$koa["NAME"]?>" name="target_audience_122[]" id="target_audience_<?=$key?>">
								<label for="target_audience_<?=$key?>">
									<?=$koa["NAME"]?>
								</label>
							<?endforeach;?>
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>
		</div>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="siflas">Специализация по финансовой грамотности. Специфика деятельности</label>
		</div>
		<input type="text" name="siflas" placeholder="Специализация по финансовой грамотности. Специфика деятельности">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="work_regions">Регионы работы</label>
		</div>
		<select name="work_regions" class="multi_select" multiple='multiple'>
			<?foreach($arResult["REGIONS"] as $region):?>
				<option value="<?=$region["CODE"]?>"><?=$region["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="author_of_materials">Автор материалов/Участие в проектах, связанных с ФГ</label>
		</div>
		<input type="text" name="author_of_materials" placeholder="Автор материалов/Участие в проектах, связанных с ФГ">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="additional_information">Дополнительные сведения</label>
		</div>
		<textarea name="additional_information" placeholder="Дополнительные сведения">text here...</textarea>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="brief_message">Бриф-сообщение</label>
		</div>
		<textarea name="brief_message" placeholder="Дополнительные сведения">text here...</textarea>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="member_information_source">Источник информации об Участнике</label>
		</div>
		<input type="text" name="member_information_source" placeholder="Источник информации об Участнике">
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="internal_comments">Внутренние комментарии</label>
		</div>
		<textarea name="internal_comments" placeholder="Внутренние комментарии">text here...</textarea>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="expert_rating">Экспертный рейтинг</label>
		</div>
		<select name="expert_rating">
			<option value="0">не выбрано</option>
			<option value="1">1</option>
		</select>
	</div>
	<div class="input_box">
		<input type="checkbox" checked="checked" value="Признак удаления данных пользователем" name="sign_of_user_data_deletion" id="sign_of_user_data_deletion">
		<label for="sign_of_user_data_deletion">
			Признак удаления данных пользователем
		</label>
	</div>
	<div class="input_box">
		<input type="checkbox" checked="checked" value="Проверка модератором пройдена" name="verification_passed_by_moderator" id="verification_passed_by_moderator">
		<label for="verification_passed_by_moderator">
			Проверка модератором пройдена
		</label>
	</div>
	<div class="input_box">
		<input type="checkbox" checked="checked" value="Активность карточки клиента" name="customer_card_activity" id="customer_card_activity">
		<label for="customer_card_activity">
			Активность карточки клиента
		</label>
	</div>
	<div class="input_box">
		<div class="label_box">
			<label for="representative_of_legal_faces">Представитель юр. лица </label>
		</div>
		<input type="text" class="filter_field" placeholder="Поиск">
		<select name="representative_of_legal_faces" class="multi_select" multiple='multiple'>
			<option value="0">не выбрано</option>
			<option value="1">Иванов Иван Иваныч</option>
		</select>
	</div>
	<div class="input_box">
		<input class="agreement" type="checkbox" checked="checked" value="Согласие на обработку данных" name="Agreement" id="agreement">
		<label class="agreement-label" for="agreement">
			Я даю свое согласие на обработку персональных данных и соглашаюсь с <a data-fancybox="politica-doc1" data-src="#politica-doc" href="javascript:;">политикой конфиденциальности</a>
		</label>
	</div>

	<div class="btn_send">Сохранить</div>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>