<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");?>
<?if(isset($_GET["confirm_code"])):?>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.confirmation","",Array(
	        "USER_ID" => "confirm_user_id", 
	        "CONFIRM_CODE" => "confirm_code", 
	        "LOGIN" => "login" 
	    )
	);?>
<?elseif($_GET['change_password']):?>
	<?$APPLICATION->IncludeComponent("deus:system.auth.changepasswd","",Array(
			"USER_CHECKWORD" => "USER_CHECKWORD",
			"USER_LOGIN" => "USER_LOGIN",
			'AUTH_RESULT' => $APPLICATION->arAuthResult
		)
	);?>
<?else:?>
	<?redirAfterAuth();?>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
	     "REGISTER_URL" => "/freg/",
	     "FORGOT_PASSWORD_URL" => "/auth/restore_password/",
	     "PROFILE_URL" => "/auth/success/",
	     "SHOW_ERRORS" => "Y" 
	     )
	);?>
<?endif;?>
<?if($_GET["success"] == "Y"):?>
	<script>
		$(document).ready(function(){
			$('#form-modal-save-account').find('.form-modal__name').html("Спасибо за регистрацию!<br> <span style='font-size:14px; font-weight:100'>Вам на почту <b style='color:#1db795'><?=$_GET["email"]?></b> отправлено письмо с ссылкой для подтверждения почтового адреса.<br>Перейдите по указанной ссылке и введите логин и пароль<br>Убедитесь, что письмо не попало в спам.</span>");
	        $.fancybox.open({
				src: '#form-modal-save-account',
				'afterClose': function() {
					window.location.href = '/auth/';
					//console.log("1");
				}
	        });
		});
	</script>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>