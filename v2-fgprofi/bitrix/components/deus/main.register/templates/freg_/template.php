<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arResult["KOA"] = getRubricators(2);
$arResult["REGIONS"] = getRubricators(4);
//$arResult["FORM_OF_INCORPORATION"] = getRubricators(2);
if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
?>
<div class="bx-auth-reg">

    <? if ($USER->IsAuthorized()): ?>

	    <?redirAfterAuth();?>

    <? else: ?>
        <?
        $fc = " checked=''";
        $fcb = " active";
        $uc = "";
        $ucb = "";
        $fview = "";
        $uview = " hidden_field";
        $activeAlert = "";
        if ($_GET["face"] == "type_u") {
            $activeAlert = " active";
            $uc = " checked=''";
            $ucb = " active";
            $fcb = "";
            $fc = "";
            $fview = " hidden_field";
            $uview = "";
        } ?>

        <div class="login">
            <div class="sign_in">
                <div class="form_title_reg">
                    <h2>Зарегистрироваться в реестре</h2>
                    <div class="help">?
                        <div class="help-description" id="form_title_reg_description">
                            <p>Если Вы регистрируетесь как физическое лицо, то необходимо заполнить следующие обязательные поля: адрес электронной почты, имя, фамилия, регион проживания, вид деятельности, и придумать пароль (не менее 6 символов). После этого вам на указанную электронную почту придёт письмо с подтверждением регистрации. Перейдя по ссылке из письма Вы сможете активировать свой профиль и продолжить работу в личном кабинете. </p>
                            <p>Прежде чем зарегистрировать юридическое лицо, убедитесь, что уже имеется регистрация физического лица, которое будет представителем юридического лица. Его ID необходимо будет указать в соответствующем поле. Также понадобится указать ОГРН организации, название и организационно-правовую форму. На электронную почту представителя юридического лица придет письмо, перейдя по ссылке из которого, Вы активируете профиль юридического лица и сможете продолжить работу в личном кабинете.</p>
                            <p>Обязательным условием регистрации является предоставление согласия на обработку персональных данных, которая осуществляется в соответствии с Политикой конфиденциальности, ссылка на которую приведена внизу формы.</p>
                            </div>
                    </div>
                </div>
                <div class="sign_in_new">
                    <? if (count($arResult["ERRORS"]) > 0):
                        foreach ($arResult["ERRORS"] as $key => $error)
                            if (intval($key) == 0 && $key !== 0)
                                $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

                        ShowError(implode("<br />", $arResult["ERRORS"]));

                    elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
                        ?>
                        Вы уже зарегистрировались?<a href="/auth/">Войти</a>
                    <? endif ?>

                </div>
                <div class="sign_in_alert<?=$activeAlert?>"><span>Внимание!</span>
                    <div id="sign_in_alert_text">Прежде, чем зарегистрировать юридическое лицо, убедитесь что уже имеется регистрация физического лица, который будет представителем юридического лица. Его ID необходимо будет указать в соответствующем поле</div>
                </div>
                <div class="sign_in_option flex layout-mobile" data-radio-name="FACE">
                    <div class="sign_in_option-item flex">
                        <div class="sign_in_button<?= $fcb ?>" data-radio-val="TYPE_F">
                            <div class="active"></div>
                        </div>
                        <div class="sign_in_text">
                            Физическое лицо
                        </div>
                    </div>
                    <div class="sign_in_option-item sign_in_option-item_entity flex">
                        <div class="sign_in_button<?= $ucb ?>" data-radio-val="TYPE_U">
                            <div class="active"></div>
                        </div>
                        <div class="sign_in_text">
                            Юридическое лицо
                        </div>
                    </div>
                </div>

                <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data" autocomplete="off">
                    <div class="layout-mobile">
                        <?
                        if ($arResult["BACKURL"] <> ''):
                            ?>
                            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                        <?
                        endif;
                        ?>
                        
						<input size="30" type="hidden" name="REGISTER[LOGIN]" value="" />
                        <div style="display: none;">
                            <label><input type="radio" value="TYPE_F" name="FACE"<?= $fc ?>>Физическое лицо</label>
                            <label><input type="radio" value="TYPE_U" name="FACE"<?= $uc ?>>Юридическое лицо</label>
                        </div>
                        <div class="form_input email required">
                        	<?if ($_GET["face"] == "type_u"):?>
                            	<input placeholder="ОГРН организации (13 цифр)" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly class="maskogrn" data-min="13" size="30" name="REGISTER[EMAIL]"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;"
                                   type="text" value="<?if($arResult['REQUEST']['REGISTER']['LOGIN'])echo $arResult['REQUEST']['REGISTER']['LOGIN'] ?>">
                            <?else:?>
                            	<input placeholder="Адрес электронной почты" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly size="30" name="REGISTER[EMAIL]"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;"
                                   type="text" value="<?if($arResult['REQUEST']['REGISTER']['EMAIL'])echo $arResult['REQUEST']['REGISTER']['EMAIL'] ?>">
                            <?endif;?>
                        </div>
                        <?
                        $resSubDiv = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>8,"!PROPERTY_SUBDIVISION"=>false), false, false, array("ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_SUBDIVISION","PROPERTY_OGRN"));
                        $arIsRand = array();
                        while($arResSubDiv = $resSubDiv->Fetch()){
                            $arIsRand[$arResSubDiv["PROPERTY_SUBDIVISION_VALUE"]] = $arResSubDiv["PROPERTY_SUBDIVISION_VALUE"];
                        }
                        $rand = randSubdivision($arIsRand);
                        ?>
                        <input type="hidden" name="SUBDIVISION" value="<?=$rand?>">
                        <div class="form_input required face_field<?= $uview ?>">
                            <div class="form_input">
                                <input placeholder="Организационно-правовая форма" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly type="text" name="FORM_OF_INCORPORATION" value="<?if($arResult['REQUEST']['FORM_OF_INCORPORATION'])echo $arResult['REQUEST']['FORM_OF_INCORPORATION'] ?>">
                            </div>
                        </div>
                        <div class="form_input required face_field<?= $uview ?>">
                            <input placeholder="Название юр. лица"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly type="text" name="NAME_TYPE_U"  value="<?if($arResult['REQUEST']['NAME_TYPE_U'])echo $arResult['REQUEST']['NAME_TYPE_U'] ?>">
                        </div>

                        <div class="form_input face_field<?= $uview ?>">
                            <input placeholder="Название подразделения" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly size="30" name="NAME_SUBDIVISION" type="text" value="<?if($arResult['REQUEST']['NAME_SUBDIVISION'])echo $arResult['REQUEST']['NAME_SUBDIVISION'] ?>">
                        </div>
                        <div class="flex layout-mobile face_field<?= $fview ?>">
                            <div class="form_input required">
                                <input placeholder="Имя" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly type="text" name="NAME_TYPE_F" value="<?if($arResult['VALUES']['NAME'])echo $arResult['VALUES']['NAME'] ?>">
                            </div>
                            <div class="form_input required">
                                <input placeholder="Фамилия" autocomplete="off" type="text" name="SURNAME" value="<?if($arResult['VALUES']['LAST_NAME'])echo $arResult['VALUES']['LAST_NAME'] ?>">
                            </div>
                        </div>
                        <div class="form_input required face_field<?= $uview ?>">
                            <input placeholder="ID Представителя"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly name="ID_USER_PR" type="text" value="<?if($arResult['REQUEST']['ID_USER_PR'])echo $arResult['REQUEST']['ID_USER_PR'] ?>">
                            <div class="no_user">
                                <div class="help-description" id="no_user">
                                    <p>Пользователя с указанным ID не существует</p>
                                </div>
                            </div>
                        </div>
                        <div class="form_input phone required">
                            <input size="30" name="REGISTER[PASSWORD]" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly id="password" class="bx-auth-input"
                                   placeholder="Пароль (не менее 6 символов)"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAABKRJREFUWAnNl0tsVGUUxzvTTlslZUaCloZHY6BRFkp9sDBuqgINpaBp02dIDImwKDG6ICQ8jBYlhg0rxUBYEALTpulMgBlqOqHRDSikJkZdGG0CRqAGUuwDovQ1/s7NPTffnTu3zMxGvuT2vP7n8Z3vu+dOi4r+5xUoJH8sFquamZmpTqfTVeIfCARGQ6HQH83NzaP5xsu5gL6+vuVzc3NdJN1Kkhd8Ev1MMYni4uJjra2tt3wwLvUjCxgYGFg8Pj7+MV5dPOUub3/hX0zHIpFId0NDw6Q/jO4tZOzv76+Znp6+AOb5TBw7/YduWC2Hr4J/IhOD/GswGHy7vb39tyw2S+VbAC1/ZXZ29hKoiOE8RrIvaPE5WvyjoS8CX8sRvYPufYpZYtjGS0pKNoD/wdA5bNYCCLaMYMMEWq5IEn8ZDof3P6ql9pF9jp8cma6bFLGeIv5ShdISZUzKzqPIVnISp3l20caTJsaPtwvc3dPTIx06ziZkkyvY0FnoW5l+ng7guAWnpAI5w4MkP6yy0GQy+dTU1JToGm19sqKi4kBjY+PftmwRYn1ErEOq4+i2tLW1DagsNGgKNv+p6tj595nJxUbyOIF38AwipoSfnJyMqZ9SfD8jxlWV5+fnu5VX6iqgt7d3NcFeUiN0n8FbLEOoGkwdgY90dnbu7OjoeE94jG9wd1aZePRp5AOqw+9VMM+qLNRVABXKkLEWzn8S/FtbdAhnuVQE7LdVafBPq04pMYawO0OJ+6XHZkFcBQA0J1xKgyhlB0EChEWGX8RulsgjvOjEBu+5V+icWOSoFawuVwEordluG28oSCmXSs55SGSCHiXhmDzC25ghMHGbdwhJr6sAdpnyQl0FYIyoEX5CeYOuNHg/NhvGiUUxVgfV2VUAxjtqgPecp9oKoE4sNnbX9HcVgMH8nD5nAoWnKM/5ZmKyySRdq3pCmDncR4DxOwVC64eHh0OGLOcur1Vey46xUZ3IcVl5oa4OlJaWXgQwJwZyhUdGRjqE14VtSnk/mokhxnawiwUvsZmsX5u+rgKamprGMDoA5sKhRCLxpDowSpsJ8vpCj2AUPzg4uIiNfKIyNMkH6Z4hF3k+RgTYz6vVAEiKq2bsniZIC0nTtvMVMwBzoBT9tKkTHp8Ak1V8dTrOE+NgJs7VATESTH5WnVAgfHUqlXK6oHpJEI1G9zEZH/Du16leqHyS0UXBNKmeOMf5NvyislJPB8RAFz4g8IuwofLy8k319fUP1EEouw7L7mC3kUTO1nn3sb02MTFxFpsz87FfJuaH4pu5fF+reDz+DEfxkI44Q0ScSbyOpDGe1RqMBN08o+ha0L0JdeKi/6msrGwj98uZMeon1AGaSj+elr9LwK9IkO33n8cN7Hl2vp1N3PcYbUXOBbDz9bwV1/wCmXoS3+B128OPD/l2LLg8l9APXVlZKZfzfDY7ehlQv0PPQDez6zW5JJdYOXdAwHK2dGIv7GH4YtHJIvEOvvunLCHPPzl3QOLKTkl0hPbKaDUvlTU988xtwfMqQBPQ3m/4mf0yBVlDCSr/CRW0CipAMnGzb9XU1NSRvIX7kSgo++Pg9B8wltxxbHKPZgAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;"
                                   type="password">
                            <div class="eye"></div>
                                   <div class="help password_reg_description">?
                                        <div class="help-description" id="password_reg_description">
                                            <p>Пароль должен содержать латинские символы верхнего регистра (A-Z).</p>
                                            <p>Пароль должен содержать латинские символы нижнего регистра (a-z).</p>
                                            <p>Пароль должен содержать цифры (0-9).</p>
                                            <p>Пароль должен содержать знаки пунктуации (,.<>/?;:'"[]{}\|`~!@#$%^&*()-_+=).</p>
                                        </div>
                                    </div>
                                   <span id="pwdMeter" class="neutral" style="display: none;"></span>
                        </div>
                        <div class="form_input phone required">
                            <input size="30" name="REGISTER[CONFIRM_PASSWORD]" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly
                                   placeholder="Подтверждение пароля"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAABKRJREFUWAnNl0tsVGUUxzvTTlslZUaCloZHY6BRFkp9sDBuqgINpaBp02dIDImwKDG6ICQ8jBYlhg0rxUBYEALTpulMgBlqOqHRDSikJkZdGG0CRqAGUuwDovQ1/s7NPTffnTu3zMxGvuT2vP7n8Z3vu+dOi4r+5xUoJH8sFquamZmpTqfTVeIfCARGQ6HQH83NzaP5xsu5gL6+vuVzc3NdJN1Kkhd8Ev1MMYni4uJjra2tt3wwLvUjCxgYGFg8Pj7+MV5dPOUub3/hX0zHIpFId0NDw6Q/jO4tZOzv76+Znp6+AOb5TBw7/YduWC2Hr4J/IhOD/GswGHy7vb39tyw2S+VbAC1/ZXZ29hKoiOE8RrIvaPE5WvyjoS8CX8sRvYPufYpZYtjGS0pKNoD/wdA5bNYCCLaMYMMEWq5IEn8ZDof3P6ql9pF9jp8cma6bFLGeIv5ShdISZUzKzqPIVnISp3l20caTJsaPtwvc3dPTIx06ziZkkyvY0FnoW5l+ng7guAWnpAI5w4MkP6yy0GQy+dTU1JToGm19sqKi4kBjY+PftmwRYn1ErEOq4+i2tLW1DagsNGgKNv+p6tj595nJxUbyOIF38AwipoSfnJyMqZ9SfD8jxlWV5+fnu5VX6iqgt7d3NcFeUiN0n8FbLEOoGkwdgY90dnbu7OjoeE94jG9wd1aZePRp5AOqw+9VMM+qLNRVABXKkLEWzn8S/FtbdAhnuVQE7LdVafBPq04pMYawO0OJ+6XHZkFcBQA0J1xKgyhlB0EChEWGX8RulsgjvOjEBu+5V+icWOSoFawuVwEordluG28oSCmXSs55SGSCHiXhmDzC25ghMHGbdwhJr6sAdpnyQl0FYIyoEX5CeYOuNHg/NhvGiUUxVgfV2VUAxjtqgPecp9oKoE4sNnbX9HcVgMH8nD5nAoWnKM/5ZmKyySRdq3pCmDncR4DxOwVC64eHh0OGLOcur1Vey46xUZ3IcVl5oa4OlJaWXgQwJwZyhUdGRjqE14VtSnk/mokhxnawiwUvsZmsX5u+rgKamprGMDoA5sKhRCLxpDowSpsJ8vpCj2AUPzg4uIiNfKIyNMkH6Z4hF3k+RgTYz6vVAEiKq2bsniZIC0nTtvMVMwBzoBT9tKkTHp8Ak1V8dTrOE+NgJs7VATESTH5WnVAgfHUqlXK6oHpJEI1G9zEZH/Du16leqHyS0UXBNKmeOMf5NvyislJPB8RAFz4g8IuwofLy8k319fUP1EEouw7L7mC3kUTO1nn3sb02MTFxFpsz87FfJuaH4pu5fF+reDz+DEfxkI44Q0ScSbyOpDGe1RqMBN08o+ha0L0JdeKi/6msrGwj98uZMeon1AGaSj+elr9LwK9IkO33n8cN7Hl2vp1N3PcYbUXOBbDz9bwV1/wCmXoS3+B128OPD/l2LLg8l9APXVlZKZfzfDY7ehlQv0PPQDez6zW5JJdYOXdAwHK2dGIv7GH4YtHJIvEOvvunLCHPPzl3QOLKTkl0hPbKaDUvlTU988xtwfMqQBPQ3m/4mf0yBVlDCSr/CRW0CipAMnGzb9XU1NSRvIX7kSgo++Pg9B8wltxxbHKPZgAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;"
                                   type="password">
                            <div class="eye"></div>
                            <div class="password_different">
                                <div class="help-description" id="password_different">
                                    <p>Пароли не совпадают</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form_input required face_field<?= $fview ?>">
                            <div>
                                Регион проживания
                            </div>
                            <div class="form_select">
                                <select name="REGION_OF_RESIDENCE" class="jsFilterSelect">
                                    <option value="">Выберите вариант</option>
                                    <? foreach ($arResult["REGIONS"] as $region): ?>
                                        <option value="<?= $region["ID"] ?>" <?if($arResult['REQUEST']['REGION_OF_RESIDENCE'] == $region["ID"]) echo"selected"?>><?= $region["NAME"] ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?/*<div class="form_input required face_field<?= $fview ?>">
                            <div>
                                Вид деятельности
                            </div>
                            <div class="form_select">
                                <select name="KIND_OF_ACTIVITY" class="jsFilterSelect">
                                    <option value="">Выберите вариант</option>
                                    <? foreach ($arResult["KOA"] as $koa): ?>
                                        <option value="<?= $koa["ID"] ?>" <?if($arResult['REQUEST']['KIND_OF_ACTIVITY'] == $koa["ID"]) echo"selected"?>><?= $koa["NAME"] ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>*/?>
                        <div class="form__privacy-policy  face_field<?= $fview ?>">
                            <div class="checkbox required form_input">
                                <input id="privacy-policy" type="checkbox" name="PRIVATE_POLICY"><label for="privacy-policy">Я даю свое согласие
                                    на обработку персональных данных<?/* и соглашаюсь с <a href="">политикой
                                        конфиденциальности</a>*/?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form_button">
                        <button class="link link-button">Создать учётную запись</button>
                    </div>
                    <input type="submit" style="display:none;" name="register_submit_button" value="Регистрация">
                </form>
            </div>
        </div>
    <? endif ?>
</div>