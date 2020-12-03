<? if ( ! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
	die();
}

if ( $arResult["PHONE_REGISTRATION"] ) {
	CJSCore::Init( 'phone_auth' );
}
?>
<div class="login">
    <div class="sign_in">
        <div class="bx-auth">
            <h2>Изменение пароля</h2>
			<?
			ShowMessage( $arParams["~AUTH_RESULT"] );
			?>

			<? if ( $arResult["SHOW_FORM"] ): ?>

                <form method="post" action="<?= $arResult["AUTH_FORM"] ?>" name="bform">
					<? if ( strlen( $arResult["BACKURL"] ) > 0 ): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
					<? endif ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="CHANGE_PWD">
                    <div class="layout-mobile">
                        <div class="form_input">
                            <div><span class="starrequired">*</span><?= GetMessage( "AUTH_LOGIN" ) ?></div>
                            <input type="text" name="USER_LOGIN" maxlength="50"
                                   value="<?= $arResult["LAST_LOGIN"] ?>" class="bx-auth-input"/>
                        </div>
                        <div class="form_input" style="display: none">
                            <div><span class="starrequired">*</span><?= GetMessage( "AUTH_CHECKWORD" ) ?></div>
                            <input type="text" name="USER_CHECKWORD" maxlength="50"
                                   value="<?= $arResult["USER_CHECKWORD"] ?>" class="bx-auth-input"
                                   autocomplete="off"/>

                        </div>
                        <div class="form_input phone">
                            <div><span class="starrequired">*</span><?= GetMessage( "AUTH_NEW_PASSWORD_REQ" ) ?></div>
                            <input type="password" name="USER_PASSWORD" maxlength="255"
                                   value="<?= $arResult["USER_PASSWORD"] ?>" class="bx-auth-input"
                                   autocomplete="off"/>
                            <div class="eye"></div>
                        </div>
                        <div class="form_input phone">
                            <div><span class="starrequired">*</span><?= GetMessage( "AUTH_NEW_PASSWORD_CONFIRM" ) ?>
                            </div>
                            <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255"
                                   value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" class="bx-auth-input"
                                   autocomplete="off"/>
                            <div class="eye"></div>
                        </div>
                        <div class="form_button">
                            <button class="link link-button"
                                    name="change_pwd"><?= GetMessage( "AUTH_CHANGE" ) ?></button>
                            <!--                            <input type="submit" name="change_pwd" value="-->
							<? //= GetMessage( "AUTH_CHANGE" ) ?><!--"/>-->
                        </div>
                    </div>
                </form>

                <p><? echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>
                <p><span class="starrequired">*</span><?= GetMessage( "AUTH_REQ" ) ?></p>

			<? if ( $arResult["PHONE_REGISTRATION"] ): ?>

                <script type="text/javascript">
                    new BX.PhoneAuth ({
                        containerId: 'bx_chpass_resend',
                        errorContainerId: 'bx_chpass_error',
                        interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                        data:
						<?=CUtil::PhpToJSObject( [
							'signedData' => $arResult["SIGNED_DATA"]
						] )?>,
                        onError:
                            function (response) {
                                var errorDiv = BX ('bx_chpass_error');
                                var errorNode = BX.findChildByClassName (errorDiv, 'errortext');
                                errorNode.innerHTML = '';
                                for (var i = 0; i < response.errors.length; i++) {
                                    errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars (response.errors[i].message) + '<br>';
                                }
                                errorDiv.style.display = '';
                            }
                    });
                </script>

                <div id="bx_chpass_error" style="display:none"><? ShowError( "error" ) ?></div>

                <div id="bx_chpass_resend"></div>

			<? endif ?>

			<? endif ?>

            <div class="sign_in_new">
                <div class="form_button">
                    <a class="btn btn-primary link link-button" href="<?= $arResult["AUTH_AUTH_URL"] ?>"><b><?= GetMessage( "AUTH_AUTH" ) ?></a>
                </div>

            </div>

        </div>
    </div>
</div>
