<? if ( ! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
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

?>
<div class="login">
    <div class="sign_in">
        <h2>Изменить пароль</h2>
        <div class="change_pass">
			<? if ( $arResult['ERROR'] ) { ?>
                <span class="error"><?= $arResult['ERROR']; ?></span>
			<? } ?>
			<? if ( $arResult['SUCCESS'] == 'Y' ) { ?>
                <span class="success"><?= GetMessage( "SUCCESS" ); ?></span>
                <script>
                    $(document).ready(function(){
                        function startPage() {
                            window.location.replace("/personal/");
                        }
                        setTimeout(startPage, 3000);
                    });
                </script>
			<? } ?>

            <form action="" method="post">
                <div class="layout-mobile">
                    <input type="hidden" name="do" value="send"/>
                    <div class="form_input">

                        <input type="password" value="<?= $_REQUEST['old_password']; ?>" name="old_password"
                               placeholder="<?= GetMessage( "OLD_PASSWORD" ); ?>" required/>

                    </div>

                    <div class="form_input">

                        <input type="password" value="<?= $_REQUEST['password']; ?>" name="password"
                               placeholder="<?= GetMessage( "NEW_PASSWORD" ); ?>" required/>

                    </div>

                    <div class="form_input">
                        <input type="password" value="<?= $_REQUEST['confirm_password']; ?>" name="confirm_password"
                               placeholder="<?= GetMessage( "CONFIRM_NEW_PASSWORD" ); ?>" required/>
                    </div>
                    <div class="form_button">
                        <button class="link link-button"><?= GetMessage( "SEND" ); ?></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>