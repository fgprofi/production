<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
$res_ib = CIBlock::GetByID($arResult["IBLOCK_ID"]);
if ($ar_ib = $res_ib->GetNext()) {
    $arResult["IB_INFO"] = $ar_ib;
}
//получаем все обязательные поля для блока контроля
$arReqProps = array();
foreach ($arResult["PROPERTIES"] as $prop) {
    if ($prop['IS_REQUIRED'] == 'Y') {
        $arReqProps[$prop['SORT']] = $prop;
    }
}
ksort($arReqProps);

//группы проверяемых полей
$aA = 1;
foreach ($arParams["FIELDS_GROOP_USER"]["FIELDS_GROOP_CUSTOM"] as $titleGroup => $group):
    $arProps = implode(' ', $group);
    $class_valid = 'sidebar__item_valid';
    foreach ($group as $prop) {
        if(in_array($prop, $arParams["FIELDS_GROOP_USER"]["PROPERTY_ONLY_ADMIN"]) && !isAdministrator()){
            continue;
        }
        $arProp = $arResult["PROPERTIES"][$prop];
        if ($arProp['VALUE'] == '' && $arProp["CODE"] != "REPRESENTATIVE_OF_LEGAL_FACES"){
            $class_valid = 'sidebar__item_error';
           
        }
    }

    $txt[] = "<li class=\"sidebar__item $class_valid $arProps\">
        <a class=\"sidebar__link\" data-block=\"block_$aA\"href=\"#\">$titleGroup</a>
    </li>";
    $aA++;
endforeach;
$arResult["KOA"] = getRubricators(4);
?>
<div class="containered">
    <?$USER_PROP["PROOF_MINFIN"] = $arParams["PROOF_MINFIN"];?>
    <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
    <?/* if (!isAdministrator()): ?>
        <div class="sidebar">
            <div class="sidebar__name">Мой профиль</div>
            <ul class="sidebar__list required_fields_check">
                <? foreach ($txt as $group):
                    echo $group;
                endforeach; ?>
            </ul>
            <ul class="sidebar__list">
                <li class="sidebar__item">
                    <a class="sidebar__link drop-login__menu-item_feedback"
                       href="#">Обратная связь</a>
                </li>
                <li class="sidebar__item">
                    <a class="sidebar__link"
                       href="/support/">Техподдержка</a>
                </li>
                <li class="sidebar__item">
                    <a class="sidebar__link logout_href"
                       href="">Выход</a>
                </li>
            </ul>
        </div>
    <? else: ?>
        <div class="sidebar">
            <div class="sidebar__name">Модерация</div>
            <ul class="sidebar__list required_fields_check">
                <? foreach ($txt as $group):
                    echo $group;
                endforeach; ?>
            </ul>
            <ul class="sidebar__list ul_border_top">
                <li class="sidebar__item">
                    <a class="sidebar__link"
                       href="/admin/">Пользователи</a>
                </li>
                <li class="sidebar__item f_need_moderation">
                    <a class="sidebar__link"
                       href="/admin/queries_f/">Запросы физ.лица</a>
                </li>
                <li class="sidebar__item u_need_moderation">
                    <a class="sidebar__link"
                       href="/admin/queries_u/">Запросы юр.лица</a>
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
                    </li>
                <li class="sidebar__item">
                    <a class="sidebar__link logout_href"
                       href="">Выход</a>
                </li>
            </ul>
        </div>
    <? endif; */?>
    <div class="main-content">
        <div class="cabinet-user flex">
            <div>
                <div class="cabinet-user__title">
                    <?= $arResult["NAME"] ?>
                </div>
                <div>
                    <?$rsUser = CUser::GetByID($arResult["PROPERTIES"]["USER_ID"]["VALUE"]);
                        $arUser = $rsUser->Fetch();?>
                        <p class="profile_login_info">Ваш логин:<span> <?=$arUser["LOGIN"]?></span></p>
                </div>
                <div class="cabinet-user__text">
                    <span>ID: <?= $arResult["ID"] ?></span> <span>|</span>
                    <span><?= mb_strtolower($arResult["IB_INFO"]["NAME"]); ?></span><br>
                    <?if($arResult["IBLOCK_ID"] == 7):?>
                        <span style="color: rgba(26, 29, 35, 0.6);font-size: 12px;">Используется при регистрации юридического лица при указании представителя юридического лица</span><br><br>
                    <?endif;?>
                    <span style="color: rgba(26, 29, 35, 0.6);font-size: 12px;">Все заполненные поля видны Модератору, а участникам Сообщества - только поля, отмеченные «галочкой».</span>
                </div>
            </div>
            <? $file = CFile::ResizeImageGet($arResult["DISPLAY_PROPERTIES"]["PHOTO"]['FILE_VALUE']['ID'], array(
                'width' => 160,
                'height' => 160
            ), BX_RESIZE_IMAGE_EXACT, true); ?>
            <div class="cabinet-user__load-photo_box">
                <div class="cabinet-user__load-photo<? if (isset($arResult["DISPLAY_PROPERTIES"]["PHOTO"]['FILE_VALUE']['ID'])) {
                    echo ' check_logo';
                } ?>" style="background: url('<?= $file['src'] ?>')">
                    <div class="remove_photo<? if (!$arResult["DISPLAY_PROPERTIES"]["PHOTO"]['FILE_VALUE']['ID']) {
                        echo ' hide';
                    } ?>" data-ib="<?= $arResult["IBLOCK_ID"] ?>"></div>
                    <? if (!$arResult["DISPLAY_PROPERTIES"]["PHOTO"]['FILE_VALUE']['ID']) { ?>
                        <div class="cabinet-user__load-photo_box no_logo">
                            <img src="<?= $templateFolder ?>/images/photo.svg">
                        </div>
                    <? } ?>
                </div>

                <div class="input_box personal_logo">
                    <div class="logo_text add_file">
                        <form action="/ajax/save_photo.php/?<?= $arResult["ID"] ?>" method="get">
                            <input type="hidden" name="PROFILE_ID" value="<?= $arResult["ID"] ?>">
                            <?$fileCaption = "";
                                if (isset($arResult["DISPLAY_PROPERTIES"]["PHOTO"]['FILE_VALUE']['ID'])) {
                                    $fileCaption = "Заменить фото";
                                }
                            ?>
                            <? $APPLICATION->IncludeComponent("bitrix:main.file.input", "",
                                array(
                                    "INPUT_NAME" => "PROPERTY_PHOTO",
                                    "INPUT_CAPTION" => $fileCaption,
                                    "MULTIPLE" => "N",
                                    "MODULE_ID" => "main",
                                    "MAX_FILE_SIZE" => "",
                                    "ALLOW_UPLOAD" => "A",
                                    "ALLOW_UPLOAD_EXT" => "jpg,jpeg,png,bmp"
                                ),
                                false
                            ); ?>
                            <div class="send-photo" style="visibility: hidden">Сохранить
                            </div> <? // кнопка прокликивается в файле reestr/public_html/bitrix/templates/pakk/components/bitrix/main.file.input/.default/script.js 371 строка?>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <form action="" class="ps_center cabinet-block-form-form js-form-validate">
            <div class="cabinet-block-form">
                <input type="hidden" name="PROFILE_ID" value="<?= $arResult["ID"] ?>">
                <input type="hidden" name="PROFILE_IB" value="<?= $arResult["IBLOCK_ID"] ?>">
                <? $a = 1;
                foreach ($arParams["FIELDS_GROOP_USER"]["FIELDS_GROOP_CUSTOM"] as $titleGroop => $groop):?>
                    <div class="groop_field block_<?= $a ?>">
                        <div class="flex">
                            <div class="groop_field_title"><?= $titleGroop ?></div>
                            <div class="help-empty"></div>
                        </div>

                        <div class="groop_field_box">
                            <?
                            $arPropHidden = explode(",", $arResult["PROPERTIES"]["HIDDEN_VIEW"]["VALUE"]);
                            foreach ($groop as $prop): ?>
                                <?
                                if(in_array($prop, $arParams["FIELDS_GROOP_USER"]["PROPERTY_ONLY_ADMIN"]) && !isAdministrator()){
                                    continue;
                                }
                                $arPropVal = $arResult["DISPLAY_PROPERTIES"][$prop];
                                $arProp = $arResult["PROPERTIES"][$prop];
                                $prop_name = "PROPERTY_" . $arProp["CODE"];

                                //декодируем сущности обратно
                                $arProp["VALUE"] = htmlspecialchars_decode($arProp["VALUE"]);
                                ?>
                                <? if ($arProp["PROPERTY_TYPE"] == "S"): ?>
                                    <? if ($arProp["MULTIPLE"] == "N"): ?>
                                        <? if ($arProp["ROW_COUNT"] > 1): ?>
                                            <? $InpVal = "";
                                            if ($arProp["VALUE"] != "") {
                                                $InpVal = $arProp["VALUE"];
                                            } ?>
                                            <?$placeholder = "";
                                            if(isset($arProp["HINT"]) && $arProp["HINT"] !=""){
                                                $placeholder = $arProp["HINT"];
                                            }?>
                                            <div class="flex">
                                                <div class="form_input input_box" id="<?= $prop_name ?>">
                                                    <label for="<?= $prop_name ?>"><?= $arProp["NAME"] ?><? if ($arProp['IS_REQUIRED'] == "Y")
                                                            echo '<sup>*</sup>' ?></label>
                                                    <textarea placeholder="<?=$placeholder?>" name="<?= $prop_name ?>" <? if ($arProp['IS_REQUIRED'] == "Y")
                                                        echo ' required ' ?>><?= $InpVal ?></textarea>
                                                </div>
                                                    <?// echo "<pre>"; print_r($arProp); echo "</pre>";?>
                                                <div class="help-empty"></div>
                                            </div>
                                        <? else: ?>
                                            <? $InpVal = "";
                                            if ($arProp["VALUE"] != "") {
                                                $InpVal = " value='" . $arProp["VALUE"] . "'";
                                            } ?>
                                            <div class="flex">
                                                <div class="form_input input_box" id="<?= $prop_name ?>">
                                                    <label for="<?= $prop_name ?>"><?= $arProp["NAME"] ?><? if ($arProp['IS_REQUIRED'] == "Y")
                                                            echo '<sup>*</sup>' ?></label>
                                                    <input <? if ($arProp['IS_REQUIRED'] == "Y")
                                                        echo ' required ' ?>
                                                            class="<?= $arProp['MASK_CLASS'] ?>"
                                                            type="<?= $arProp['FIELD_TYPE'] ?>" autocomplete="off"
                                                            name="<?= $prop_name ?>" <?= $InpVal ?>/>
                                                </div>

                                                <div class="help">?
                                                    <div class="help-description"><?= $arProp['DESC_FIELD'] ?></div>
                                                </div>
                                            </div>
                                        <? endif; ?>
                                    <? else: ?>
                                        <div class="flex">
                                            <div class="input_box multi_field_text" id="<?= $prop_name ?>">
                                                <div class="label_box">
                                                    <label for="soc"><?= $arProp["NAME"] ?></label>
                                                </div>
                                                <?
                                                if (!$arProp["VALUE"]) {
                                                    $arProp["VALUE"] = $arProp["~VALUE"];
                                                }
                                                if ($arProp["VALUE"] != ""): ?>
                                                    <? foreach ($arProp["VALUE"] as $val): ?>
                                                        <? $valText = "";
                                                        if ($arProp["USER_TYPE"] == "UserID") {
                                                            $rsUser = CUser::GetByID($val);
                                                            $arUser = $rsUser->Fetch();
                                                            $valText = '<div class="user_desc">' . $arUser["LOGIN"] . " [id:" . $arUser["ID"] . "]" . '</div>';
                                                        } ?>
                                                        <div class="multi_field_text_input valid_minus margin-bottom">
                                                            <div class="field-row">
                                                            <input type="text" name="<?= $prop_name ?>[<?= $val ?>]"
                                                                   value="<?= $val ?>"><?= $valText ?>
                                                            <span class="remove-field"></span>
                                                            </div>
                                                        </div>
                                                    <? endforeach; ?>
                                                <? endif; ?>
                                                <div class="multi_field_text_input">
                                                    <div class="field-row">
                                                        <input type="text" name="<?= $prop_name ?>[]">
                                                    </div>
                                                    <div class="multi_field_text_plus">Добавить ещё вариант</div>
                                                </div>
                                            </div>
                                            <div class="help">?
                                                <div class="help-description"><?= $arProp['DESC_FIELD'] ?></div>
                                            </div>
                                        </div>
                                    <? endif; ?>
                                <? endif; ?>
                                <? if ($arProp["PROPERTY_TYPE"] == "E"): ?>
                                    <?if($arProp["CODE"] == "TARGET_AUDIENCE"/* && $arProp["IBLOCK_ID"] == 8*/){
                                        $arProp['LINK_IBLOCK_ID'] = 3;
                                    }?>
                                    <? $arOptions = getRubricators($arProp['LINK_IBLOCK_ID']);
                                    ?>
                                    <? $arVal = array();
                                    if ($arProp["VALUE"] != "") {
                                        foreach ($arPropVal["LINK_ELEMENT_VALUE"] as $value) {
                                            $arVal[$value["CODE"]] = $value["CODE"];
                                        }
                                    } ?>
                                    <?/*if($arProp["CODE"] == "TARGET_AUDIENCE" && $arProp["IBLOCK_ID"] == 8):?>
                                        <?//echo "<pre>"; print_r($arResult["KOA"]); echo "</pre>";?>
                                        <div class="input_box">
                                            <div class="label_box">
                                                <label for="<?=$arProp["CODE"]?>"><?= $arProp["NAME"] ?></label>
                                            </div>
                                            <div class="multi_check" data-name="<?=$arProp["CODE"]?>[]">
                                                <?foreach($arOptions as $key => $target):?>
                                                    <div class="check_select" data-value="<?=$target["CODE"]?>" data-id="<?=$key?>">
                                                        <div class="check_select_title"><?=$target["NAME"]?></div>
                                                        <?if($target["ID"] == 122):?>
                                                            <div class="check_select_content">
                                                                <?foreach($arResult["KOA"] as $key => $koa):?>
                                                                    <input type="checkbox" value="<?=$koa["NAME"]?>" name="target_audience_122[]" id="target_audience_<?=$key?>">
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
                                    <?else:*/?>
                                        <?if($arProp["CODE"] == "REPRESENTATIVE_OF_LEGAL_FACES"):?>
                                            <div class="flex">
                                                <div class="input_box" id="PROPERTY_REPRESENTATIVE_OF_LEGAL_FACES">
                                                    <div class="label_box">
                                                        <label for="REPRESENTATIVE_OF_LEGAL_FACES">Представитель юр. лица </label>
                                                    </div>
                                                    <div class="REPRESENTATIVE_OF_LEGAL_FACES_variants">
                                                        <div class="multi_field_text_input valid_minus">
                                                            <? if ($arProp['SELECTED']) {
                                                                    $arFilterSubDiv = array();
                                                                    $arResSubDiv = array();
                                                                    foreach ($arProp['SELECTED'] as $one_sel) {
                                                                        $arFilterSubDiv[] = $one_sel['ID'];
                                                                    }
                                                                    if(!empty($arFilterSubDiv)){
                                                                        $iterator = CIBlockElement::GetPropertyValues(8, array('ID' => $arFilterSubDiv), true, array('ID' => array(111)));

                                                                        while ($row = $iterator->Fetch())
                                                                        {
                                                                            $arResSubDiv[$row["IBLOCK_ELEMENT_ID"]] = $row[111];
                                                                          //echo "<pre>"; print_r($row); echo "</pre>";
                                                                        }
                                                                    }
                                                                    
                                                                    foreach ($arProp['SELECTED'] as $one_sel) {
                                                                        if ($one_sel['ID'] != 0/* && !in_array($one_sel['ID'],$arResult["KOA_KEYS"])*/):?>
                                                                            <div class="field-row auth_legal_face_box">
                                                                                <div class="select_only_val">
                                                                                    <div class="auth_legal_face_title"><?= $one_sel['NAME'] ?>
                                                                                        <?if($arResSubDiv[$one_sel['ID']] != ""):?>
                                                                                            <br><span>Подразделение: <span class="subdivision_name"><?=$arResSubDiv[$one_sel['ID']]?><span><span>
                                                                                        <?endif;?>
                                                                                    </div>
                                                                                    <a href="/personal/auth_profile/<?=$one_sel['ID']?>/" class="auth_legal_face">Авторизоваться</a>
                                                                                </div>
                                                                            </div>
                                                                        <?endif;
                                                                    }
                                                                } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="help">?
                                                    <div class="help-description">Представитель юр. лица </div>
                                                </div>
                                            </div>
                                            <?continue;?>
                                        <?endif;?>
                                        <?if($arProp["CODE"] == "FIZ_USER_ID"):?>
                                            <?//echo "<pre>"; print_r($arOptions); echo "</pre>";?>
                                            <div class="flex">
                                                <div class="input_box" id="PROPERTY_FIZ_USER_ID">
                                                    <div class="label_box">
                                                        <label for="FIZ_USER_ID">ID представителя юридического лица*</label>
                                                    </div>
                                                    <div class="FIZ_USER_ID_variants">
                                                        <div class="multi_field_text_input valid_minus">
                                                            <div class="field-row auth_fiz_face_box">
                                                                <? if ($arOptions[$arProp['VALUE']]):?>
                                                                    <div class="select_only_val">
                                                                        <div class="auth_fiz_face_title"><?=$arOptions[$arProp['VALUE']]["NAME"]?>[<?=$arProp['VALUE']?>]</div>
                                                                        <a href="/personal/auth_profile/<?=$arProp['VALUE']?>/" class="auth_fiz_face">Авторизоваться</a>
                                                                    </div>
                                                                <?endif;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="help">?
                                                    <div class="help-description">Используется при регистрации юридического лица при указании представителя юридического лица</div>
                                                </div>
                                            </div>
                                            <?continue;?>
                                        <?endif;?>
                                        
                                        <div class="flex">
                                            <?if($arProp["CODE"] == "TARGET_AUDIENCE"/* && $arProp["IBLOCK_ID"] == 8*/):?>
                                                <div class="groop_ta">
                                            <?endif;?>
                                            <div class="input_box" id="<?= $prop_name ?>">
                                                <div class="label_box" data-s="<?=$arProp['REPRESENTATIVE_OF_LEGAL_FACES']?>">
                                                    <label for="<?= $arProp["CODE"] ?>"><?= $arProp["NAME"] ?><? if ($arProp['IS_REQUIRED'] == "Y" || $arProp["CODE"] == "KIND_OF_ACTIVITY")
                                                            echo '<sup>*</sup>' ?></label>
                                                </div>
                                                <?
                                                $noCheckGroup = "";
                                                $inputDisabled = "";
                                                $inputName = $arProp["CODE"].$ml;
                                                if($arProp["CODE"] == "REPRESENTATIVE_OF_LEGAL_FACES"){
                                                    $noCheckGroup = " noCheckGroup";
                                                }?>
                                                <?if(in_array($arProp["CODE"], $arParams["FIELDS_GROOP_USER"]["DISABLED_PROPERTY"]) && !isAdministrator()){
                                                    $inputDisabled = " disabled='disabled'";
                                                    $inputName = "";
                                                }?>
                                                <?// запрещаем для физ лица менять юр лицо?>
<!--                                                --><?//if($prop_name != 'PROPERTY_REPRESENTATIVE_OF_LEGAL_FACES'){?>
                                                    <div class="select input_box form_input">
                                                        <select <? if ($arProp['IS_REQUIRED'] == "Y" || $arProp["CODE"] == "KIND_OF_ACTIVITY")
                                                            echo ' required ' ?>
                                                                name="<?= $inputName?>" class="jsFilterSelect<?=$noCheckGroup?>"
                                                                data-multi="<?= $arProp["MULTI"] ?>"
                                                                data-code="<?= $arProp["CODE"] ?>"
                                                                <?=$inputDisabled?>>
                                                            <option value="">Выберите вариант</option>
                                                            <? foreach ($arOptions as $opt):
                                                                $selected = '';
                                                                if ($opt['ID'] == $arProp["VALUE"]) {
                                                                    $selected = 'selected';
                                                                }
                                                                $ifUser = '';
                                                                if ($arProp['LINK_IBLOCK_ID'] == 7) {
                                                                    $ifUser = "[$opt[ID]]";
                                                                }
                                                                ?>
                                                                <option value="<?= $opt["ID"] ?>" <?= $selected ?>
                                                                        data-name="<?= $opt["NAME"] ?>"><?= $opt["NAME"] ?> <?= $ifUser ?></option>
                                                            <? endforeach; ?>
                                                        </select>
                                                    </div>
<!--                                                --><?//}?>
                                                <div class="<?= $arProp["CODE"] ?>_variants">
                                                    <? if ($arProp['SELECTED']) {
                                                        foreach ($arProp['SELECTED'] as $one_sel) {
                                                            if ($one_sel['ID'] != 0 && !in_array($one_sel['ID'],$arResult["KOA_KEYS"])) {
                                                                ?>
                                                                <div class="multi_field_text_input valid_minus">
                                                                    <div class="field-row">
                                                                        <input name="<?= $prop_name ?>[<?= $one_sel['ID'] ?>]"
                                                                               value="<?= $one_sel['NAME'] ?>">
                                                                        <span class="remove-field"></span>
                                                                    </div>
                                                                </div>
                                                                <?
                                                            }
                                                        }
                                                    } ?>
                                                </div>
                                            </div>
                                            <?if($arProp["CODE"] == "TARGET_AUDIENCE"/* && $arProp["IBLOCK_ID"] == 8*/):?>
                                                <?
                                                $act = "";
                                                if(isset($arProp['SELECTED_CHECK']) && count($arProp['SELECTED_CHECK'])>0){
                                                    $act = " active";
                                                }
                                                //echo "<pre>"; print_r($arProp['SELECTED_CHECK']); echo "</pre>";
                                                ?>
                                                <div class="tg_check_group<?=$act?>">
                                                    <?$arResult["KOA_KEYS"] = array_keys($arResult["KOA"]);
                                                    $arOptions = getRubricators(4);?>
                                                    <?foreach ($arOptions as $key => $opt):?>
                                                        <?$selectCheck = "";
                                                        if(isset($arProp['SELECTED_CHECK'][$opt["ID"]])){
                                                            $selectCheck = "checked='checked'";
                                                        }?>
                                                        <div class="input_box checkbox">
                                                            <input type="checkbox" <?=$selectCheck?> value="<?= $opt["NAME"] ?>" name="PROPERTY_TARGET_AUDIENCE[<?= $opt["ID"] ?>]" id="TARGET_AUDIENCE_check_<?=$key?>">
                                                            <label for="TARGET_AUDIENCE_check_<?=$key?>"><?= $opt["NAME"] ?></label>
                                                        </div>
                                                    <? endforeach; ?>
                                                </div>
                                                <?/*<div class="input_box" id="<?= $prop_name ?>_1">
                                                    <div class="select input_box form_input">
                                                        <select name="<?= $arProp["CODE"] ?>[]" class="jsFilterSelect" data-multi="31" data-code="<?= $arProp["CODE"] ?>">
                                                            <option value="">Выберете вариант</option>
                                                            <? foreach ($arOptions as $opt):
                                                                $selected = '';
                                                                if ($opt['ID'] == $arProp["VALUE"]) {
                                                                    $selected = 'selected';
                                                                }
                                                                ?>
                                                                <option value="<?= $opt["ID"] ?>" <?= $selected ?> data-name="<?= $opt["NAME"] ?>"><?= $opt["NAME"] ?></option>
                                                            <? endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="<?= $arProp["CODE"] ?>_variants">
                                                        <? if ($arProp['SELECTED']) {
                                                            foreach ($arProp['SELECTED'] as $one_sel) {
                                                                if ($one_sel['ID'] != 0 && in_array($one_sel['ID'],$arResult["KOA_KEYS"])) {
                                                                    ?>
                                                                    <div class="multi_field_text_input valid_minus">
                                                                        <div class="field-row">
                                                                            <input name="<?= $prop_name ?>[<?= $one_sel['ID'] ?>]" value="<?= $one_sel['NAME'] ?>">
                                                                            <span class="remove-field"></span>
                                                                        </div>
                                                                    </div>
                                                                    <?
                                                                }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>*/?>
                                            <?endif;?>
                                            <?if($arProp["CODE"] == "TARGET_AUDIENCE"/* && $arProp["IBLOCK_ID"] == 8*/):?>
                                                </div>
                                            <?endif;?>
                                            <div class="help">?
                                                <div class="help-description"><?= $arProp["DESC_FIELD"] ?></div>
                                            </div>
                                        </div>
                                    <?//endif;?>
                                    <? if (isset($arParams["FIELDS_GROOP_USER"]["PROPERTY_GROOP"][$arProp["CODE"]])): ?>
                                        <? $arPropGroop = $arResult["PROPERTIES"][$arParams["FIELDS_GROOP_USER"]["PROPERTY_GROOP"][$arProp["CODE"]]];
                                        $prop_name_groop = "PROPERTY_" . $arPropGroop["CODE"]; ?>
                                        <? if ($arPropGroop["MULTIPLE"] == "N"): ?>
                                            <? $InpVal = "";
                                            if ($arPropGroop["VALUE"] != "") {
                                                $InpVal = " value='" . $arPropGroop["VALUE"] . "'";
                                            } ?>
                                            <div class="input_box" id="<?= $prop_name ?>">
                                                <div class="label_box">
                                                    <label for="<?= $arPropGroop["CODE"] ?>"><?= $arPropGroop["NAME"] ?><? if ($arProp['IS_REQUIRED'] == "Y")
                                                            echo '<sup>*</sup>' ?></label>
                                                </div>
                                                <input <? if ($arProp['IS_REQUIRED'] == "Y")
                                                    echo ' required ' ?> type="text"
                                                                         name="<?= $prop_name_groop ?>"<?= $InpVal ?>
                                                                         placeholder="<?= $arPropGroop["NAME"] ?>">
                                            </div>
                                        <? endif; ?>
                                    <? endif; ?>
                                <? endif; ?>
                                <? if ($arProp["PROPERTY_TYPE"] == "L"): ?>
                                    <?
                                    $property_enums = CIBlockPropertyEnum::GetList(Array(
                                        "DEF" => "DESC",
                                        "SORT" => "ASC"
                                    ), Array("IBLOCK_ID" => $arResult["IBLOCK_ID"], "CODE" => $arProp["CODE"]));
                                    $enum_fields = $property_enums->GetNext()
                                    ?>
                                    <div class="input_box checkbox">
                                        <?
                                        if ($prop_name == 'PROPERTY_PERSONAL_DATA') {
                                            $check = "";
                                            if ($arProp["VALUE"] != "") {
                                                ?>
                                                <div><label>Согласие на обработку получено</label></div><?
                                            } else {
                                                ?><input <? if ($arProp['IS_REQUIRED'] == "Y")
                                                    echo ' required ' ?>
                                                type="checkbox"<?= $check ?> value="<?= $enum_fields["ID"]; ?>"
                                                name="<?= $prop_name ?>" id="<?= $prop_name ?>" >
                                            <label for="<?= $prop_name ?>">
                                                Подтверждаю, что я внимательно ознакомился(-лась) с <a href="/upload/online_site_user_agreement.pdf" target="_blank">«Пользовательским соглашением»</a>, <a href="/upload/personal_data_processing_policy.pdf" target="_blank">«Политикой обработки персональных данных»</a> и выражаю согласие на предоставление и обработку своих персональных данных в соответствии с указанными документами<? if ($arProp['IS_REQUIRED'] == "Y")
                                                    echo '<sup>*</sup>' ?>
                                                </label><?
                                            }
                                        } else {
                                            $check = "";
                                            if ($arProp["VALUE"] != ""):?>
                                                <? $check = ' checked="checked"'; ?>
                                            <? else: ?>
                                                <input value='' class='empty_val' type='hidden'
                                                       name='<?= $prop_name ?>'>
                                            <? endif; ?>

                                            <input <? if ($arProp['IS_REQUIRED'] == "Y")
                                                echo ' required ' ?>
                                                    type="checkbox"<?= $check ?> value="<?= $enum_fields["ID"]; ?>"
                                                    name="<?= $prop_name ?>" id="<?= $prop_name ?>">
                                            <label for="<?= $prop_name ?>">
                                                <?= $arProp["NAME"] ?>
                                            </label>
                                        <? } ?>
                                    </div>
                                <? endif; ?>
                                <? if ($arProp["ID"] && $arProp["ID"] != 21 && $arProp["ID"] != 23 && $arProp["ID"] != 107): ?>
                                    <?
                                    $disabled_check = "";
                                    if($arProp['IS_REQUIRED'] == "Y" || $arProp["CODE"] == "MIDDLENAME"){
                                        $disabled_check = " disabled_check";
                                    }
                                    ?>
                                    <div class="input_box checkbox<?=$disabled_check?>">
                                        <?
                                        $check = "";
                                        if (!in_array($arProp["ID"], $arPropHidden)):?>
                                            <? $check = ' checked="checked"'; ?>
                                            <input type="checkbox"<?= $check ?> value="<?= $arProp["ID"]; ?>"
                                                   name="HIDDEN_VIEW[<?= $arProp["ID"]; ?>]"
                                                   id="VIEW_<?= $prop_name ?>">
                                        <? else: ?>
                                            <input type="checkbox" value="<?= $arProp["ID"]; ?>"
                                                   name="HIDDEN_VIEW[<?= $arProp["ID"]; ?>]"
                                                   id="VIEW_<?= $prop_name ?>">
                                        <? endif; ?>

                                        <label for="VIEW_<?= $prop_name ?>">
                                            Информация блока "<?= $arProp["NAME"] ?>" будет видна всем участникам Сообщества.
                                        </label>
                                    </div>
                                <? endif; ?>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <? $a++;
                endforeach; ?>
                <div class="cabinet-block-form__required">* - это обязательное для заполнения поле</div>
            </div>
            <style>

            </style>
            <div class="edit_profile_btn">
                <div class="button-green">
                    <button type="submit" id="save_button">Сохранить</button>
                </div>
                <?//if (!$USER->IsAdmin()) {?>
                    <div class="button-red">
                        <button type="submit" id="del_profile_button">Удалить запись</button>
                    </div>
                    <div id="form-success-del"></div>
                <?//}?>
                <div class="clear"></div>
            </div>
        </form>
        <? if ($USER->GetID() == 1 || isAdministrator()) {

            $INTERNAL_COMMENTS = $arResult['PROPERTIES']['INTERNAL_COMMENTS'];
            $int_comm = $INTERNAL_COMMENTS['VALUE'];
            // удаление
            $SIGN_OF_USER_DATA_DELETION = $arResult['PROPERTIES']['SIGN_OF_USER_DATA_DELETION'];
            $del = '';
            $del_checked = '';
            if ($SIGN_OF_USER_DATA_DELETION['VALUE']) {
                $del_checked = ' selected';
            }
            //подверждение модератором
            $VERIFICATION_PASSED_BY_MODERATOR = $arResult['PROPERTIES']['VERIFICATION_PASSED_BY_MODERATOR'];
            $mod_pass = '';
            $mod_checked = '';
            if ($VERIFICATION_PASSED_BY_MODERATOR['VALUE']) {
                $mod_checked = ' selected';
            }
            $checkMF = "";
            if($arResult['PROPERTIES']['PROOF_MINFIN']["VALUE"]){
                $checkMF = " checked";
            }
            //активность
            $active = $arResult['ACTIVE'];
            if ($active == "Y") {
                $active_check = ' selected';
            }
            $ib_settings = array(
                7 => array(
                    "VERIFICATION_PASSED_BY_MODERATOR" => 4,
                    "SIGN_OF_USER_DATA_DELETION" => 3,
                ),
                8 => array(
                    "VERIFICATION_PASSED_BY_MODERATOR" => 10,
                    "SIGN_OF_USER_DATA_DELETION" => 9,
                )
            );
            $mod_pass = $ib_settings[$arResult['IBLOCK_ID']]['VERIFICATION_PASSED_BY_MODERATOR'];
            $del = $ib_settings[$arResult['IBLOCK_ID']]['SIGN_OF_USER_DATA_DELETION'];
            ?>

            <div class="moderation cabinet-block-form admin-block" data-id="<?= $arResult['ID'] ?>">
                <div class="moderation-title">Модерация</div>
                <div class="admin_select_change">
                    <div class="moderation-item">
                        <label for="">Проверено модератором</label>
                        <div class="select">
                            <select id="VERIFICATION_PASSED_BY_MODERATOR" name="moderator">
                                <option value="0">Ожидает модерацию</option>
                                <option value="<?= $mod_pass ?>" <?= $mod_checked ?>>Проверено</option>
                            </select>
                        </div>
                    </div>
                    <div class="moderation-item">
                        <label for="">Присвоить статус "Удалено"</label>
                        <div class="select">
                            <select id="SIGN_OF_USER_DATA_DELETION" name="trash">
                                <option value="0">Рабочий аккаунт</option>
                                <option value="<?= $del ?>" <?= $del_checked ?>>Аккаунт удален</option>
                            </select>
                        </div>
                    </div>
                    <div class="moderation-item">
                        <label for="">Заблокирована</label>
                        <div class="select">
                            <select id="ACTIVE" name="active">
                                <option value="N">Заблокирована</option>
                                <option value="Y" <?= $active_check ?> >Разблокирована</option>
                            </select>
                        </div>
                    </div>
                    <?/* if ($USER->GetID() == 1):?>
                        <?//echo "<pre>"; print_r($arResult['PROPERTIES']['PROOF_MINFIN']); echo "</pre>";?>
                        <div class="moderation-item">
                            <div class="input_box checkbox">
                                <input type="checkbox" value="22" <?=$checkMF?> name="PROOF_MINFIN" id="PROOF_MINFIN_CHECK">
                                <label for="PROOF_MINFIN_CHECK">Разрешение от МинФин получено</label>
                            </div>
                        </div>
                    <?//endif;*/?>
                </div>
                <form action="" class="admin_edit_form">
                    <div class="moderation-item">
                        <label for="">Внутренний комментарий</label>
                        <div class="form_input input_box">
                            <label for="INTERNAL_COMMENTS"></label>
                            <textarea id="INTERNAL_COMMENTS" name="INTERNAL_COMMENTS"><?= $int_comm ?></textarea>
                        </div>
                    </div>
                    <div class="button-green">
                        <button class="save_comment" name="<?= $arResult['ID'] ?>">Сохранить комментарий</button>
                    </div>
                </form>
                <div class="button-red" id="change_pass">
                    <button name="<?= $arResult['ID'] ?>">Сбросить пароль пользователю</button>
                </div>
            </div>

            <?
        } ?>
    </div>
</div>
<div class="no_user">
    <div class="help-description" id="no_user">
    </div>
</div>