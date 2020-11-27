<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
if ($USER->IsAuthorized() && !isAdministrator()) {
    redirAfterAuth();
}
CJSCore::Init();
?>
<div class="login">
    <div class="sign_in">
        <h2>Администратору</h2>
        <div class="bx-system-auth-form">
            <?
            if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']):?>
                <div class="error_box"><? ShowMessage($arResult['ERROR_MESSAGE']); ?></div>
            <? endif; ?>
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
                        <div class="form_input email required error">
                            <div>Логин</div>
                            <input autocomplete="off" placeholder="login"
                                   type="text" name="USER_LOGIN" maxlength="50" value="" size="17">
                        </div>
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
                            <div>Пароль</div>
                            <input name="USER_PASSWORD" maxlength="255" size="17" autocomplete="off"
                                   placeholder="Пароль"
                                   type="password">
                        </div>
                    </div>
                    <div class="form_button">
                        <button class="link link-button">Войти</button>
                    </div>
                    <input type="submit" style="display: none;" name="Login"
                           value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                </form>
        </div>
    </div>
</div>