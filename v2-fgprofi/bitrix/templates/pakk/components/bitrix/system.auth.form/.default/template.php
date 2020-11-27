<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
if ($USER->IsAuthorized() && !isAdministrator()) {
    redirAfterAuth();
}
CJSCore::Init();
?>
<div class="login">
    <div class="sign_in">
        <h2>Войти</h2>
        <div class="sign_in_new">
            Новый пользователь?<a href="/freg/">Зарегистрироваться в реестре</a>
        </div>
        <div class="sign_in_option flex layout-mobile">
            <div class="sign_in_option-item flex">
                <div class="sign_in_button<?if($_GET["face"] == "type_f" || !isset($_GET["face"])){echo " active";}?>"  data-radio-val="TYPE_F">
                    <div class="active"></div>
                </div>
                <div class="sign_in_text">
                    Физическое лицо
                </div>
            </div>
            <div class="sign_in_option-item sign_in_option-item_entity flex">
                <div class="sign_in_button<?if($_GET["face"] == "type_u"){echo " active";}?>" data-radio-val="TYPE_U">
                    <div class="active"></div>
                </div>
                <div class="sign_in_text">
                    Юридическое лицо
                </div>
            </div>
        </div>
        <div class="bx-system-auth-form">

            <?
            if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']):?>
                <div class="error_box"><? ShowMessage($arResult['ERROR_MESSAGE']); ?></div>
            <? endif; ?>

            <? if ($arResult["FORM_TYPE"] == "login"): ?>

                <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
                      action="<?= $arResult["AUTH_URL"] ?>">
                    <? if ($arResult["BACKURL"] <> ''): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                    <? endif ?>
                    <? foreach ($arResult["POST"] as $key => $value): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
                    <? endforeach ?>
                    <input type="hidden" name="AUTH_FORM" value="Y"/>
                    <input type="hidden" name="TYPE" value="AUTH"/>
                    <div class="layout-mobile">
                        <?if ($_GET["face"] == "type_f" || !isset($_GET["face"])):?>
                            <div class="form_input email required error">
                                <input autocomplete="off" placeholder="E-mail" type="text" name="USER_LOGIN" maxlength="50" value="" size="17">
                            </div>
                        <?else:?>
                            <div class="form_input email required error">
                                <input autocomplete="off" placeholder="ОГРН" data-min="13" class="maskogrn" type="text" name="USER_LOGIN" maxlength="50" value="" size="17">
                            </div>
                        <?endif;?>
                        <script>
                            BX.ready(function () {
                                var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                                if (loginCookie) {
                                    var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                                    var loginInput = form.elements["USER_LOGIN"];
                                    loginInput.value = loginCookie;
                                }
                            });
                        </script>
                        <div class="form_input phone required">
                            <input name="USER_PASSWORD" minlength="6" maxlength="255" size="17" autocomplete="off" placeholder="Пароль (не менее 6 символов)" type="password">
                            <div class="eye"></div>
                        </div>
                        <? if ($arResult["SECURE_AUTH"]): ?>
                            <span class="bx-auth-secure" id="bx_auth_secure<?= $arResult["RND"] ?>"
                                  title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
											<div class="bx-auth-secure-icon"></div>
										</span>
                            <noscript>
										<span class="bx-auth-secure"
                                              title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
											<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
										</span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                            </script>
                        <? endif ?>
                    </div>
                    <div class="form_button">
                        <button class="link link-button">Войти</button>
                    </div>
                    <input type="submit" style="display: none;" name="Login"
                           value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                    <a class="form_forgot" href="/auth/restore_password/">Забыли пароль?</a>
                </form>
            <? endif ?>
        </div>
    </div>
<!--    <a class="login_text" href="">Как зарегистрироваться на портале?</a>-->
</div>