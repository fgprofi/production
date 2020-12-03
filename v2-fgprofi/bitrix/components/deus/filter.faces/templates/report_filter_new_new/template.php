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

if ( ! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
	die();
}
?>
<?
$arParamsFace = array(
    "TYPE_F" => 7,
    "TYPE_U" => 8,
);
$face = "TYPE_U";
if ( $_GET["face"] ) {
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
    <div class="user-search__row">
        <div class="check">
            <input class="input" type="checkbox" value="Y" name="VERIFICATION_PASSED_BY_MODERATOR" id="VERIFICATION_PASSED_BY_MODERATOR">
            <label class="label" for="VERIFICATION_PASSED_BY_MODERATOR">Проверен модератором</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="ACTIVE" value="N" name="ACTIVE">
            <label class="label" for="ACTIVE">Заблокирован</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="SIGN_OF_USER_DATA_DELETION" value="Y" name="SIGN_OF_USER_DATA_DELETION">
            <label class="label" for="SIGN_OF_USER_DATA_DELETION">Удаленные</label>
        </div>
    </div>
    <div class="user-search__row">
        <div class="check">
            <input class="input" type="checkbox" value="Y" name="REVERS_VERIFICATION_PASSED_BY_MODERATOR" id="REVERS_VERIFICATION_PASSED_BY_MODERATOR">
            <label class="label" for="REVERS_VERIFICATION_PASSED_BY_MODERATOR">Не проверен модератором</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="REVERS_ACTIVE" value="Y" name="REVERS_ACTIVE">
            <label class="label" for="REVERS_ACTIVE">Не заблокирован</label>
        </div>
        <div class="check">
            <input class="input" type="checkbox" id="REVERS_SIGN_OF_USER_DATA_DELETION" value="Y" name="REVERS_SIGN_OF_USER_DATA_DELETION">
            <label class="label" for="REVERS_SIGN_OF_USER_DATA_DELETION">Не удаленные</label>
        </div>
    </div>
</form>

<div class="full_filter_box">
    <div class="full_filter" style="display:block;">
		<?
        $i          = 0;
        $actionForm = " active";
        foreach ($arResult["PROPS"] as $keyFace => $face) : ?>
            <? if ($i > 0) {
                $actionForm = "";
            }
            $i++; ?>
            <form action="" class="form_filter<?= $actionForm ?> report_filter" data-face="<?= $keyFace ?>">
                <? foreach ($face as $propName => $arProp) : ?>
                    <? if ($arProp["PROPERTY_TYPE"] == "S") : ?>
                        <div class="form_input input_box required">
                            <div class="form__input-name"><?= $arProp["NAME"] ?></div>
                            <input type="text" class="auto_text" autocomplete="off" name="<?= $propName ?>" placeholder="<?= $arProp["NAME"] ?>">
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
                                    <select name="PROPERTY_<?= $propName ?>[]" class="jsFilterSelect" data-multi="30" data-code="<?= $propName ?>">
                                        <option value="">Выберете вариант</option>
                                        <? foreach ($arOptions as $opt) :
                                            $selected = '';
                                            if ($opt['ID'] == $arProp["VALUE"]) {
                                                $selected = 'selected';
                                            }
                                        ?>
                                            <option value="<?= $opt["ID"] ?>" <?= $selected ?> data-name="<?= $opt["NAME"] ?>"><?= $opt["NAME"] ?></option>
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
                            "DEF"  => "DESC",
                            "SORT" => "ASC"
                        ), array("IBLOCK_ID" => $arProp["IBLOCK_ID"], "CODE" => $arProp["CODE"]));
                        $enum_fields    = $property_enums->GetNext()
                        ?>
                        <div class="input_box checkbox">
                            <?
                            $check = "";
                            if ($arProp["VALUE"] != "") : ?>
                                <? $check = ' checked="checked"'; ?>
                            <? else : ?>
                                <input value='' class='empty_val' type='hidden' name='<?= $propName ?>'>
                            <? endif; ?>
                            <input type="checkbox" <?= $check ?> value="<?= $enum_fields["ID"]; ?>" name="<?= $propName ?>" id="<?= $propName ?>">
                            <label for="<?= $propName ?>">
                                <?= $arProp["NAME"] ?>
                            </label>
                        </div>
                    <? endif; ?>
                <? endforeach ?>
                <?;
                $unsetProp = array(
                    "HIDDEN_VIEW",
                    "USER_ID",
                    "MARGE_ID",
                );
                $arEmptyPropsField = array();
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arParamsFace[$keyFace]));
                while ($prop_fields = $properties->GetNext())
                {
                    if($prop_fields["PROPERTY_TYPE"] == "L" || in_array($prop_fields["CODE"], $unsetProp)){
                        continue;
                    }
                    $arEmptyPropsField[$prop_fields["CODE"]] = $prop_fields["NAME"];
                }?>
                <div class="form_input form_input--multi">
                    <div class="form__input-name">Фильтр по не заполненным полям</div>
                    <div class="form_select">
                        <select multiple="multiple" name="EMPTY_PROP[]" placeholder="Выбрать" class="form__input-multi">
                            <? foreach ($arEmptyPropsField as $propCode => $propName) : ?>
                                <option value="<?=$propCode?>"><?=$propName?></option>
                            <? endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="startFilter"></div>
            </form>
        <? endforeach ?>
    </div>
</div>
<div class="button-green">
            <button class="clear-form">Сбросить фильтр</button>
        </div>
<?

$arFilter["IBLOCK_ID"] = 7;
$arResultJson["ib"] = $arFilter["IBLOCK_ID"];
$res  = CIBlockElement::GetList( Array(), $arFilter, false, false, array("ID") );

while ( $ob = $res->Fetch() ) {
    $arResultJson["id"][] = $ob["ID"];
}?>
<div class="total-user">Найдено пользователей: <b class="total-user-val"><?=count($arResultJson['id']) ?></b></div>
<a href="#" class="main-content__report-download" id="create_feed">
    <div class="ajax_data" style="display:none"><?echo json_encode($arResultJson);?></div>
    Скачать отчет
</a>

<div id="popup_progress">
    <p class="main-content__report-title">Отчет готов на <span>0</span>%</p>
    <div class="main-content__report-progress">
        <div class="progress-bg"></div>
    </div>
</div>