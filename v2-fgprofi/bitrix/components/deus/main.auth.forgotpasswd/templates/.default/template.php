<?php
if ( ! defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true ) {
	die();
}

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages( __FILE__ );

\Bitrix\Main\Page\Asset::getInstance()->addCss(
	'/bitrix/css/main/system.auth/flat/style.css'
);

if ( $arResult['AUTHORIZED'] ) {
	echo Loc::getMessage( 'MAIN_AUTH_PWD_SUCCESS' );

	return;
}
?>

<div class="login">
    <div class="sign_in">
        <h2>Восстановление пароля</h2>

		<? if ( $arResult['ERRORS'] ): ?>
            <div class="alert alert-danger">
				<? foreach ( $arResult['ERRORS'] as $error ) {
					echo $error;
				}
				?>
            </div>
		<? elseif ( $arResult['SUCCESS'] ):?>

            <div class="alert alert-success">
                Ваши регистрационные данные были высланы на email <?=$_REQUEST['USER_EMAIL']?>.
                Пожалуйста, дождитесь письма, так как ссылка для восстановления пароля
                изменяется при каждом запросе.<br>
                <!--        <script>-->
                <!--            setTimeout(function(){-->
                <!--                location.href = '/auth/'-->
                <!--            },2000)-->
                <!--        </script>-->
            </div>
		<? endif; ?>

        <p class="bx-authform-content-container"><?= Loc::getMessage( 'MAIN_AUTH_PWD_NOTE' ); ?></p>

        <form name="bform" method="post" target="_top" action="<?= POST_FORM_ACTION_URI; ?>">

            <div class="layout-mobile">
                <div class="form_input email">
                    <input type="text" name="<?= $arResult['FIELDS']['email'];?>" maxlength="255" value="" />
                </div>
                <div class="">Логин (восстановление пароля юридического лица) или Email (восстановление пароля физического лица)</div>

                <!--                <p>Или</p>-->
<!--                <div class="form_input email">-->
<!--                    <div class="">Email (восстановление физического лица)</div>-->
<!--                    <input type="text" name="--><?//= $arResult['FIELDS']['email'];?><!--" maxlength="255" value="" />-->
<!--                </div>-->
            </div>
			<? if ( $arResult['CAPTCHA_CODE'] ): ?>
                <input type="hidden" name="captcha_sid"
                       value="<?= \htmlspecialcharsbx( $arResult['CAPTCHA_CODE'] ); ?>"/>
                <div class="bx-authform-formgroup-container dbg_captha">
                    <div class="bx-authform-label-container">
						<?= Loc::getMessage( 'MAIN_AUTH_PWD_FIELD_CAPTCHA' ); ?>
                    </div>
                    <div class="bx-captcha"><img
                                src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx( $arResult['CAPTCHA_CODE'] ); ?>"
                                width="180" height="40" alt="CAPTCHA"/></div>
                    <div class="bx-authform-input-container">
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                    </div>
                </div>
			<? endif; ?>
            <div class="form_button">
                <input type="submit" class="btn btn-primary link link-button" name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_SUBMIT');?>" />
            </div>

			<? if ( $arResult['AUTH_AUTH_URL'] || $arResult['AUTH_REGISTER_URL'] ): ?>
                <noindex>
					<? if ( $arResult['AUTH_AUTH_URL'] ): ?>
                        <div class="sign_in_new">
                            <a href="<?= $arResult['AUTH_AUTH_URL']; ?>" rel="nofollow">
								<?= Loc::getMessage( 'MAIN_AUTH_PWD_URL_AUTH_URL' ); ?>
                            </a>
                        </div>
					<? endif; ?>
					<? if ( $arResult['AUTH_REGISTER_URL'] ): ?>
                        <div class="sign_in_new">
                            <a href="<?= $arResult['AUTH_REGISTER_URL']; ?>" rel="nofollow">
								<?= Loc::getMessage( 'MAIN_AUTH_PWD_URL_REGISTER_URL' ); ?>
                            </a>
                        </div>
					<? endif; ?>
                </noindex>
			<? endif; ?>
        </form>
    </div>
</div>

<script type="text/javascript">
    document.bform.<?= $arResult['FIELDS']['login'];?>.focus ();
</script>
