<?

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 *
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 *
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<?
$arParamsFace = array(
    "TYPE_F" => 7,
    "TYPE_U" => 8,
);
$face = "TYPE_U";
if ($_GET["face"]) {
    $face = $_GET["face"];
} ?>
<p class="user-search__title">Поиск пользователя</p>
<form class="all_user user-search__form" action="">
    <div class="sign_in_option user-search__row" data-radio-name="FACE">
        <div class="sign_in_option-item user-search__item">
            <div class="sign_in_button active" data-radio-val="TYPE_F">
                <div class="active"></div>
            </div>
            <div class="sign_in_text">
                Физическое лицо
            </div>
        </div>
        <div class="sign_in_option-item user-search__item">
            <div class="sign_in_button" data-radio-val="TYPE_U">
                <div class="active"></div>
            </div>
            <div class="sign_in_text">
                Юридическое лицо
            </div>
        </div>
    </div>
    <div class="filter_face">
        <label><input type="radio" value="TYPE_F" name="FACE" checked>Физическое лицо</label>
        <label><input type="radio" value="TYPE_U" name="FACE">Юридическое лицо</label>
    </div>
    <div class="user-search__row user-search-personal-data">
        <div class="check">
            <input class="input" type="checkbox" value="Y" name="PERSONAL_DATA[]" id="PERSONAL_DATA_TRUE">
            <label class="label" for="PERSONAL_DATA_TRUE">Подтвержденные</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" value="0" name="PERSONAL_DATA[]" id="PERSONAL_DATA_FALSE">
            <label class="label" for="PERSONAL_DATA_FALSE">Не подтвержденные</label>
        </div>
    </div>
    <? /*<div class="sign_in_option user-search__row" data-radio-name="PERSONAL_DATA">
        <div class="sign_in_option-item user-search__item">
            <div class="sign_in_button active" data-radio-val="Y">
                <div class="active"></div>
            </div>
            <div class="sign_in_text">
                Подтвержденные
            </div>
        </div>
        <div class="sign_in_option-item user-search__item">
            <div class="sign_in_button" data-radio-val="0">
                <div class="active"></div>
            </div>
            <div class="sign_in_text">
                Не подтвержденные
            </div>
        </div>
    </div>
    <div style="display: none;">
        <label><input type="radio" value="Y" name="PERSONAL_DATA" checked>Подтвержденные</label>
        <label><input type="radio" value="0" name="PERSONAL_DATA">Не подтвержденные</label>
    </div>*/ ?>
    <div class="user-search__row">
        <div class="check">
            <input class="input" type="checkbox" value="Y" name="VERIFICATION_PASSED_BY_MODERATOR"
                   id="VERIFICATION_PASSED_BY_MODERATOR">
            <label class="label" for="VERIFICATION_PASSED_BY_MODERATOR">Проверен модератором</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="ACTIVE" value="N" name="ACTIVE">
            <label class="label" for="ACTIVE">Заблокирован</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="SIGN_OF_USER_DATA_DELETION" value="Y"
                   name="SIGN_OF_USER_DATA_DELETION">
            <label class="label" for="SIGN_OF_USER_DATA_DELETION">Удаленные</label>
        </div>
    </div>
    <div class="user-search__row">
        <div class="check">
            <input class="input" type="checkbox" value="Y" name="REVERS_VERIFICATION_PASSED_BY_MODERATOR"
                   id="REVERS_VERIFICATION_PASSED_BY_MODERATOR">
            <label class="label" for="REVERS_VERIFICATION_PASSED_BY_MODERATOR">Не проверен модератором</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="REVERS_ACTIVE" value="Y" name="REVERS_ACTIVE">
            <label class="label" for="REVERS_ACTIVE">Не заблокирован</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="REVERS_SIGN_OF_USER_DATA_DELETION" value="Y"
                   name="REVERS_SIGN_OF_USER_DATA_DELETION">
            <label class="label" for="REVERS_SIGN_OF_USER_DATA_DELETION">Не удаленные</label>
        </div>
    </div>
</form>

<div class="full_filter_box">
    <div class="filter_btn">Развернуть фильтр</div>
    <div class="full_filter" style="display:block;">
        <?
        $i = 0;
        $actionForm = " active";
        foreach ($arResult["PROPS"] as $keyFace => $face) : ?>
            <? if ($i > 0) {
                $actionForm = "";
            }
            $i++; ?>
            <form action="" class="form_filter<?= $actionForm ?>" data-face="<?= $keyFace ?>" autocomplete="off">
                <? foreach ($face as $propName => $arProp) : ?>
                    <? if ($arProp["PROPERTY_TYPE"] == "S") : ?>
                        <div class="form_input input_box required">
                            <div class="form__input-name"><?= $arProp["NAME"] ?></div>
                            <input type="text" class="auto_text" autocomplete="off" name="<?= $propName ?>"
                                   placeholder="<?= $arProp["NAME"] ?>">
                        </div>
                        <? /*<div class="input_box">
							<div class="label_box">
								<label for="<?=$propName?>"><?=$arProp["NAME"]?></label>
							</div>
							<input type="text" class="auto_text" autocomplete="off" name="<?=$propName?>" placeholder="<?=$arProp["NAME"]?>">
						</div>*/
                        ?>
                    <? endif; ?>
                    <? if ($arProp["PROPERTY_TYPE"] == "E") : ?>
                        <? $arOptions = getRubricators($arProp["LINK_IBLOCK_ID"]); ?>
                        <? if (in_array($propName, $arParams["MULTI_SELECT"])) : ?>
                            <div class="form_input input_box">
                                <div class="form__input-name"><?= $arProp["NAME"] ?></div>
                                <div class="select input_box form_input">
                                    <select name="PROPERTY_<?= $propName ?>[]" class="jsFilterSelect" data-multi="30"
                                            data-code="<?= $propName ?>">
                                        <option value="">Выберете вариант</option>
                                        <? foreach ($arOptions as $opt) :
                                            $selected = '';
                                            if ($opt['ID'] == $arProp["VALUE"]) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $opt["ID"] ?>" <?= $selected ?>
                                                    data-name="<?= $opt["NAME"] ?>"><?= $opt["NAME"] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                                <div class="<?= $propName ?>_variants"></div>
                            </div>
                        <? else : ?>
                            <div class="form_input">
                                <div class="form__input-name"><?= $arProp["NAME"] ?></div>
                                <div class="form_select">
                                    <select name="<?= $propName ?>" class="jsFilterSelect">
                                        <option value="0">Не выбрано</option>
                                        <? foreach ($arOptions as $opt) : ?>
                                            <option value="<?= $opt["ID"] ?>"><?= $opt["NAME"] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <? endif; ?>
                    <? endif; ?>
                    <? if ($arProp["PROPERTY_TYPE"] == "L") : ?>
                        <? continue;
                        $property_enums = CIBlockPropertyEnum::GetList(array(
                            "DEF" => "DESC",
                            "SORT" => "ASC"
                        ), array("IBLOCK_ID" => $arProp["IBLOCK_ID"], "CODE" => $arProp["CODE"]));
                        $enum_fields = $property_enums->GetNext()
                        ?>
                        <div class="input_box checkbox">
                            <?
                            $check = "";
                            if ($arProp["VALUE"] != "") : ?>
                                <? $check = ' checked="checked"'; ?>
                            <? else : ?>
                                <input value='' class='empty_val' type='hidden' name='<?= $propName ?>'>
                            <? endif; ?>
                            <input type="checkbox" <?= $check ?> value="<?= $enum_fields["ID"]; ?>"
                                   name="<?= $propName ?>" id="<?= $propName ?>">
                            <label for="<?= $propName ?>">
                                <?= $arProp["NAME"] ?>
                            </label>
                        </div>
                    <? endif; ?>
                <? endforeach ?>
                <? ;
                $unsetProp = array(
                    "HIDDEN_VIEW",
                    "USER_ID",
                    "MARGE_ID",
                );
                $arEmptyPropsField = array();
                $properties = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $arParamsFace[$keyFace]));
                while ($prop_fields = $properties->GetNext()) {
                    if ($prop_fields["PROPERTY_TYPE"] == "L" || in_array($prop_fields["CODE"], $unsetProp)) {
                        continue;
                    }
                    $arEmptyPropsField[$prop_fields["CODE"]] = $prop_fields["NAME"];
                } ?>
                <div class="form_input form_input--multi">
                    <div class="form__input-name">Фильтр по не заполненным полям</div>
                    <div class="form_select">
                        <select multiple="multiple" name="EMPTY_PROP[]" placeholder="Выбрать" class="form__input-multi">
                            <? foreach ($arEmptyPropsField as $propCode => $propName) : ?>
                                <option value="<?= $propCode ?>"><?= $propName ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="startFilter"></div>
            </form>
        <? endforeach ?>
        <div class="button-green">
            <button class="clear-form">Сбросить фильтр</button>
        </div>
        <div class="button-green">
            <button class="send-refresh-data-users">Отправить письмо на обновление данных</button>
        </div>
        <div class="filter_btn active">Свернуть фильтр</div>
    </div>
</div>
<div class="list_profiles"></div>
<div class="count_res_filter"><span></span></div>
<div class="filter">
    <div class="filter__head">
        <div class="filter__left">
            <label class="filter__label select_all">
                <input class="filter__input" type="checkbox">
                <span class="filter__check"></span>
                <span class="filter__name">Выбрать всех</span>
            </label>
        </div>
        <div class="filter__right" style="display: none;">
            <div class="filter__label-wrap">
                <label class="filter__label label-filter label-filter_lock">
                    <input class="filter__input lock_all" data-status="block" type="checkbox">
                    <span class="label-filter__icon"></span>
                </label>
                <span class="label-filter__tooltip">Блокировка</span>
            </div>
            <div class="filter__label-wrap">
                <label class="filter__label label-filter label-filter_trash">
                    <input class="filter__trash trash_all" data-status="delete" type="checkbox">
                </label>
                <span class="label-filter__tooltip">Удаление</span>
            </div>
            <div class="filter__label-wrap">
                <label class="filter__label label-filter label-filter_changes">
                    <input class="filter__change-pass change_pass_all" data-status="pass" type="checkbox">
                </label>
                <span class="label-filter__tooltip">Сброс пароля</span>
            </div>
        </div>
    </div>
    <?
    $countItems = 15;
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "ACTIVE",
        "NAME",
        "DATE_ACTIVE_FROM",
        "PROPERTY_*"
    ); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = array(
        "IBLOCK_ID" => 7,
        //		"ACTIVE"                              => "Y",
        "PROPERTY_PERSONAL_DATA_VALUE" => "Да",
        //		"PROPERTY_SIGN_OF_USER_DATA_DELETION" => false
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => $countItems), $arSelect);
    $all = $res->NavRecordCount;
    while ($ob = $res->GetNextElement()) {
        $arItems["FIELDS"] = $ob->GetFields();
        $arItems["PROPS"] = $ob->GetProperties();
        $arResult["ITEMS"][] = $arItems;
    }
    //SIGN_OF_USER_DATA_DELETION
    //    echo "<pre>"; print_r($arResult["ITEMS"]); echo "</pre>";

    ?>
    <div class="filter__body" data-num-page="1" data-count-items="<?= $countItems ?>">
        <? foreach ($arResult["ITEMS"] as $item) : ?>
            <? $surName = "";
            $middleName = "";
            $firstName = "";
            if ($item["PROPS"]["SURNAME"]["VALUE"] != "") {
                $surName = $item["PROPS"]["SURNAME"]["VALUE"];
            }
            if ($item["PROPS"]["MIDDLENAME"]["VALUE"] != "") {
                $middleName = $item["PROPS"]["MIDDLENAME"]["VALUE"];
            }
            if ($item['PROPS']['FIRST_NAME']['VALUE'] != "") {
                $firstName = $item['PROPS']['FIRST_NAME']['VALUE'];
            }
            $fullName = $surName . ' ' . $firstName . ' ' . $middleName;
            $filePhoto["src"] = "";
            if ($item["PROPS"]["PHOTO"]["VALUE"] != "") {
                $filePhoto = CFile::ResizeImageGet($item["PROPS"]["PHOTO"]["VALUE"], array(
                    'width' => 64,
                    'height' => 64
                ), BX_RESIZE_IMAGE_EXACT, true);
            }
            ?>
            <div class="filter__item" data-item-id="<?= $item["FIELDS"]["ID"] ?>">
                <div class="filter__left">
                    <label class="filter__label">
                        <input class="filter__input" name="select[]" value="<?= $item["FIELDS"]["ID"] ?>"
                               type="checkbox">
                        <span class="filter__check"></span>
                    </label>
                </div>
                <a class="filter__middle" href="/personal/fiz_faces/<?= $item["FIELDS"]["ID"] ?>/">
                    <div class="filter__profile profile-filter">
                        <div class="profile-filter__image">
                            <div class="header-login__img-wrap">
                                <img class="header-login__img" src="<?= $filePhoto["src"] ?>">
                                <span class="header-login__initials"><?= mb_strtoupper(mb_substr($surName, 0, 1)) ?><?= mb_strtoupper(mb_substr($firstName, 0, 1)) ?></span>
                            </div>
                        </div>
                        <div class="profile-filter__info">
                            <p class="profile-filter__name"><?= $fullName ?></p>
                            <p class="profile-filter__identifier">
                                <span class="profile-filter__id">ID: <?= $item["FIELDS"]["ID"] ?> | </span>
                                <span class="profile-filter__status">физическое лицо</span>
                            </p>
                        </div>
                    </div>
                </a>
                <div class="filter__right" data-id="<?= $item["FIELDS"]["ID"] ?>">
                    <label class="filter__label label-filter label-filter_lock">
                        <input class="filter__input" type="checkbox" <? if ($item["FIELDS"]["ACTIVE"] == "Y") {
                            echo "checked='checked'";
                        } ?>>
                        <span class="label-filter__icon"></span>
                    </label>
                    <?
                    $delTrash = "";
                    if ($item["PROPS"]["SIGN_OF_USER_DATA_DELETION"]["VALUE"] != "") {
                        $delTrash = " blue_trash";
                    } ?>
                    <label class="filter__label label-filter label-filter_trash<?= $delTrash ?>">
                        <input class="filter__trash" type="checkbox"<? if ($delTrash != "") {echo "checked='checked'";} ?>>
                    </label>
                    <label class="filter__label label-filter label-filter_changes">
                        <input class="filter__change-pass" type="checkbox">
                    </label>
                </div>
            </div>
        <? endforeach; ?>
    </div>
    <div class="filter__bottom">
        <button class="filter__button" <? if ($all < $countItems) {
            echo "style='display:none'";
        } ?>>
            <div>Показать еще</div>
        </button>
    </div>
</div>