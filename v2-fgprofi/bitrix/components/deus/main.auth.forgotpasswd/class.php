<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Application;

\CBitrixComponent::includeComponentClass('bitrix:main.auth.form');

class MainForgotPasswdComponent extends MainAuthFormComponent
{
	/**
	 * Processing request new pass.
	 * @return void
	 */
	protected function actionRequest()
	{
		if (!defined('ADMIN_SECTION') || ADMIN_SECTION !== true)
		{
			$lid = LANG;
		}
		else
		{
			$lid = false;
		}
		$main_config = new reestr\mainConfig();

		//делаем обработку для юрлица
		if(is_numeric($this->requestField('email'))){
			//получаем всех физлиц ответственных за юрлицо по ОГРН юр лица
			$arEmails = $main_config->FindFizByUr($this->requestField('email'));
			$emailStr = implode(',',$arEmails);
			$send_mess = new reestr\sendMessage();
			//$send_mess->sendChangePassUser($this->requestField('email'), $emailStr);
			$rsUser = CUser::GetByLogin($this->requestField('email'));
			$arUser = $rsUser->Fetch();

			$ID = intval($arUser["ID"]);
			$salt = randString(8);
			$checkword = md5(CMain::GetServerUniqID().uniqid());
			$_checkword = $salt.md5($salt.$checkword);
			$arUser["CHECKWORD"] = $_checkword;
			global $DB;
			$strSql = "UPDATE b_user SET CHECKWORD = '".$_checkword."', CHECKWORD_TIME = ".$DB->CurrentTimeFunction().", LID = '".$DB->ForSql($lid, 2)."', TIMESTAMP_X = TIMESTAMP_X WHERE ID = '".$ID."' AND (EXTERNAL_AUTH_ID IS NULL OR EXTERNAL_AUTH_ID='') ";
			$DB->Query($strSql);

			$send_mess->sendChangePassUser($arUser, $emailStr);
			$this->arResult['SUCCESS'] = "На почты всех ответственных было отправлено сообщение с ссылкой на восстановление пароля";
			// $changePasswordRes = CUser::ChangePassword($this->requestField('email'), $arUser["CHECKWORD"], $new_password, $new_password);
			// $new_password = randString(7, array(
			//   "abcdefghijklnmopqrstuvwxyz",
			//   "ABCDEFGHIJKLNMOPQRSTUVWX­YZ",
			//   "0123456789",
			//   ",.<>/?;:\'\"[]{}\|`~!@#$%^&*()-_+=",
			// ));
			// if($changePasswordRes["TYPE"] == "OK"){
			// 	$send_mess->sendChangePassUser($this->requestField('email'), $emailStr);
			// }else{
			// 	echo "<pre>"; print_r($changePasswordRes); echo "</pre>";
			// 	echo "Error";
			// 	die();
			// }
			// $res = \CUser::SendPassword(
			// 	'',
			// 	$emailStr,
			// 	$lid,
			// 	$this->request('captcha_word'),
			// 	$this->request('captcha_sid')
			// );

		}elseif($this->requestField('email')){
			$res = \CUser::SendPassword(
				$this->requestField('email'),
				'',
				$lid,
				$this->request('captcha_word'),
				$this->request('captcha_sid')
			);

		}


		if (
			!$this->processingErrors($res) &&
			isset($res['MESSAGE'])
		)
		{
			$this->arResult['SUCCESS'] = $res['MESSAGE'];
		}
	}

	/**
	 * Base executable method.
	 * @param boolean $applyTemplate Apply template or not.
	 * @return void
	 */
	public function executeComponent($applyTemplate = true)
	{
		// check authorization
		if ($this->isAuthorized())
		{
			$this->arResult['AUTHORIZED'] = true;
			$this->IncludeComponentTemplate();
			return;
		}

		// init vars
		$request = Application::getInstance()->getContext()->getRequest();

		// tpl vars
		$this->arResult['SUCCESS'] = null;
		$this->arResult['FIELDS'] = $this->formFields;
		$this->arResult['LAST_LOGIN'] = $request->getCookie(
			'LOGIN'
		);
		$this->arResult['AUTH_AUTH_URL'] = $this->checkParam(
			'AUTH_AUTH_URL',
			''
		);
		$this->arResult['AUTH_REGISTER_URL'] = $this->checkParam(
			'AUTH_REGISTER_URL',
			''
		);
		if ($this->getOption('captcha_restoring_password', 'N') == 'Y')
		{
			$this->arResult['CAPTCHA_CODE'] = $this->getApplication()->CaptchaGetCode();
		}
		else
		{
			$this->arResult['CAPTCHA_CODE'] = '';
		}

		// processing
		if ($this->requestField('action'))
		{
			$this->actionRequest();
		}

		$this->arResult['ERRORS'] = $this->getErrors();

		if ($applyTemplate)
		{
			$this->IncludeComponentTemplate();
		}
	}
}