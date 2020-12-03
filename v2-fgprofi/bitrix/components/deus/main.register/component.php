<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponent $this
 */
if($_REQUEST['REGISTER']['EMAIL'] && !$_REQUEST['REGISTER']['LOGIN'])
	$_REQUEST['REGISTER']['LOGIN'] = $_REQUEST['REGISTER']['EMAIL'];

$arResult['REQUEST'] = $_REQUEST;
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)
	die();

global $USER_FIELD_MANAGER;
$event_ext = new reestr\sendMessage();
// apply default param values
$arDefaultValues = array(
	"SHOW_FIELDS" => array(),
	"REQUIRED_FIELDS" => array(),
	"AUTH" => "Y",
	"USE_BACKURL" => "Y",
	"SUCCESS_PAGE" => "",
);

foreach ($arDefaultValues as $key => $value)
{
	if (!is_set($arParams, $key))
		$arParams[$key] = $value;
}
if(!is_array($arParams["SHOW_FIELDS"]))
	$arParams["SHOW_FIELDS"] = array();
if(!is_array($arParams["REQUIRED_FIELDS"]))
	$arParams["REQUIRED_FIELDS"] = array();

// if user registration blocked - return auth form
if (COption::GetOptionString("main", "new_user_registration", "N") == "N")
	$APPLICATION->AuthForm(array());

$arResult["PHONE_REGISTRATION"] = (COption::GetOptionString("main", "new_user_phone_auth", "N") == "Y");
$arResult["PHONE_REQUIRED"] = ($arResult["PHONE_REGISTRATION"] && COption::GetOptionString("main", "new_user_phone_required", "N") == "Y");
$arResult["EMAIL_REGISTRATION"] = (COption::GetOptionString("main", "new_user_email_auth", "Y") <> "N");
$arResult["EMAIL_REQUIRED"] = ($arResult["EMAIL_REGISTRATION"] && COption::GetOptionString("main", "new_user_email_required", "Y") <> "N");
//$arResult["USE_EMAIL_CONFIRMATION"] = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N") == "Y" && $arResult["EMAIL_REQUIRED"]? "Y" : "N");
$arResult["USE_EMAIL_CONFIRMATION"] = "Y";
$arResult["PHONE_CODE_RESEND_INTERVAL"] = CUser::PHONE_CODE_RESEND_INTERVAL;

// apply core fields to user defined
$arDefaultFields = array(
	"LOGIN",
);
if($arResult["EMAIL_REQUIRED"])
{
	$arDefaultFields[] = "EMAIL";
}
if($arResult["PHONE_REQUIRED"])
{
	$arDefaultFields[] = "PHONE_NUMBER";
}
$arDefaultFields[] = "PASSWORD";
$arDefaultFields[] = "CONFIRM_PASSWORD";

$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
if($def_group <> "")
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(explode(",", $def_group));
else
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(array());

$arResult["SHOW_FIELDS"] = array_unique(array_merge($arDefaultFields, $arParams["SHOW_FIELDS"]));
$arResult["REQUIRED_FIELDS"] = array_unique(array_merge($arDefaultFields, $arParams["REQUIRED_FIELDS"]));

// use captcha?
$arResult["USE_CAPTCHA"] = COption::GetOptionString("main", "captcha_registration", "N") == "Y" ? "Y" : "N";
if($arParams["USE_CAPTCHA"] == "N"){
	$arResult["USE_CAPTCHA"] = "N";
}
// start values
$arResult["VALUES"] = array();
$arResult["ERRORS"] = array();
$arResult["SHOW_SMS_FIELD"] = false;
$register_done = false;
$email = '';

// register user
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["register_submit_button"] <> '' && !$USER->IsAuthorized())
{
	if(COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
	{
		//possible encrypted user password
		$sec = new CRsaSecurity();
		if(($arKeys = $sec->LoadKeys()))
		{
			$sec->SetKeys($arKeys);
			$errno = $sec->AcceptFromForm(array('REGISTER'));
			if($errno == CRsaSecurity::ERROR_SESS_CHECK)
				$arResult["ERRORS"][] = GetMessage("main_register_sess_expired");
			elseif($errno < 0)
				$arResult["ERRORS"][] = GetMessage("main_register_decode_err", array("#ERRCODE#"=>$errno));
		}
	}

	// check emptiness of required fields
	foreach ($arResult["SHOW_FIELDS"] as $key)
	{
		if ($key != "PERSONAL_PHOTO" && $key != "WORK_LOGO")
		{
			$arResult["VALUES"][$key] = $_REQUEST["REGISTER"][$key];
			if (in_array($key, $arResult["REQUIRED_FIELDS"]) && trim($arResult["VALUES"][$key]) == '')
				$arResult["ERRORS"][$key] = GetMessage("REGISTER_FIELD_REQUIRED");
		}
		else
		{
			$_FILES["REGISTER_FILES_".$key]["MODULE_ID"] = "main";
			$arResult["VALUES"][$key] = $_FILES["REGISTER_FILES_".$key];
			if (in_array($key, $arResult["REQUIRED_FIELDS"]) && !is_uploaded_file($_FILES["REGISTER_FILES_".$key]["tmp_name"]))
				$arResult["ERRORS"][$key] = GetMessage("REGISTER_FIELD_REQUIRED");
		}
	}

	//добавляем собственные поля для корректного заведения пользователя
	$arResult["VALUES"]["FACE"] = $_REQUEST['FACE'];
	$arResult["VALUES"]["PRIVATE_POLICY"] = $_REQUEST['PRIVATE_POLICY'];

	if(isset($_REQUEST["REGISTER"]["TIME_ZONE"]))
		$arResult["VALUES"]["TIME_ZONE"] = $_REQUEST["REGISTER"]["TIME_ZONE"];

	$USER_FIELD_MANAGER->EditFormAddFields("USER", $arResult["VALUES"]);

	//this is a part of CheckFields() to show errors about user defined fields
	if (!$USER_FIELD_MANAGER->CheckFields("USER", 0, $arResult["VALUES"]))
	{
		$e = $APPLICATION->GetException();
		$arResult["ERRORS"][] = substr($e->GetString(), 0, -4); //cutting "<br>"
		$APPLICATION->ResetException();
	}

	// check captcha
	if ($arResult["USE_CAPTCHA"] == "Y")
	{
		if (!$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]))
			$arResult["ERRORS"][] = GetMessage("REGISTER_WRONG_CAPTCHA");
	}

	if(count($arResult["ERRORS"]) > 0)
	{
		if(COption::GetOptionString("main", "event_log_register_fail", "N") === "Y")
		{
			$arError = $arResult["ERRORS"];
			foreach($arError as $key => $error)
				if(intval($key) == 0 && $key !== 0) 
					$arError[$key] = str_replace("#FIELD_NAME#", '"'.$key.'"', $error);
			CEventLog::Log("SECURITY", "USER_REGISTER_FAIL", "main", false, implode("<br>", $arError));
		}
	}
	else // if there's no any errors - create user
	{
		$arResult['VALUES']["GROUP_ID"] = array();
		$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
		if($def_group != "")
			$arResult['VALUES']["GROUP_ID"] = explode(",", $def_group);

		$bConfirmReq = ($arResult["USE_EMAIL_CONFIRMATION"] === "Y");
		$active = ($bConfirmReq || $arResult["PHONE_REQUIRED"]? "N": "Y");

		$faces = array(
			'TYPE_U' => array(
				"NAME" => "NAME_TYPE_U",
				"FORM_OF_INCORPORATION" => "FORM_OF_INCORPORATION",
			),
			'TYPE_F' => array(
				"NAME" => "NAME_TYPE_F",
				"LAST_NAME" => "SURNAME",
			),
		);

		//получаем почту из профиля привязанного ответственного
		if($_REQUEST['FACE'] == 'TYPE_F'){
			$email = $_REQUEST['REGISTER']['EMAIL'];
		}else{
			CModule::IncludeModule("iblock");
			$obUserPr = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>7,"ID"=>$_REQUEST['ID_USER_PR']),false,false,array("PROPERTY_EMAIL","PROPERTY_FIRST_NAME","PROPERTY_MIDDLENAME"));
			if($arUserPr = $obUserPr->Fetch()){
				$email = $arUserPr['PROPERTY_EMAIL_VALUE'];
				$userPrName = $arUserPr['PROPERTY_FIRST_NAME_VALUE'];
				$userPrMiddlename = $arUserPr['PROPERTY_MIDDLENAME_VALUE'];
			}
			
		}

		if($_REQUEST['FACE'] == 'TYPE_U' && $arResult['VALUES']["LOGIN"] == "-".$_REQUEST['REGISTER']["SUBDIVISION"]){
			$arResult['VALUES']["LOGIN"] = $_REQUEST['REGISTER']['EMAIL']."-".$_REQUEST['REGISTER']["SUBDIVISION"];
		}
		
		if(!$email){
			$arResult["ERRORS"][] = 'Пользователь с указанным ID не найден';
		}

		$arResult['VALUES']["NAME"]             = $_REQUEST['FORM_OF_INCORPORATION'].' '.$_REQUEST[$faces[$_REQUEST['FACE']]['NAME']];
		$arResult['VALUES']["LAST_NAME"]        = $_REQUEST[$faces[$_REQUEST['FACE']]['LAST_NAME']];
		$arResult['VALUES']["EMAIL"]            = $email;

		if($arResult['VALUES']['FACE'] == 'TYPE_F')
			$arResult['VALUES']["GROUP_ID"][] = 8;
		elseif($arResult['VALUES']['FACE'] == 'TYPE_U')
			$arResult['VALUES']["GROUP_ID"][] = 9;


		$arResult['VALUES']["CHECKWORD"] = md5(CMain::GetServerUniqID().uniqid());
		$arResult['VALUES']["~CHECKWORD_TIME"] = $DB->CurrentTimeFunction();
		$arResult['VALUES']["ACTIVE"] = $active;
		$arResult['VALUES']["CONFIRM_CODE"] = ($bConfirmReq? randString(8): "");
		$arResult['VALUES']["LID"] = SITE_ID;
		$arResult['VALUES']["LANGUAGE_ID"] = LANGUAGE_ID;

		$arResult['VALUES']["USER_IP"] = $_SERVER["REMOTE_ADDR"];
		$arResult['VALUES']["USER_HOST"] = @gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		
		if($arResult["VALUES"]["AUTO_TIME_ZONE"] <> "Y" && $arResult["VALUES"]["AUTO_TIME_ZONE"] <> "N")
			$arResult["VALUES"]["AUTO_TIME_ZONE"] = "";

		$bOk = true;
		// echo "<pre>"; print_r($arResult["VALUES"]); echo "</pre>";
		// echo "<pre>"; print_r($_REQUEST); echo "</pre>";
		// die();
		$events = GetModuleEvents("main", "OnBeforeUserRegister", true);
		foreach($events as $arEvent)
		{
			if(ExecuteModuleEventEx($arEvent, array(&$arResult['VALUES'])) === false)
			{
				if($err = $APPLICATION->GetException())
					$arResult['ERRORS'][] = $err->GetString();

				$bOk = false;
				break;
			}
		}
		$ID = 0;
		$user = new CUser();
		if ($bOk)
		{
			$ID = $user->Add($arResult["VALUES"]);
		}

		if (intval($ID) > 0)
		{
			if($arResult["PHONE_REGISTRATION"] == true && $arResult['VALUES']["PHONE_NUMBER"] <> '')
			{
				//added the phone number for the user, now sending a confirmation SMS
				list($code, $phoneNumber) = CUser::GeneratePhoneCode($ID);

				$sms = new \Bitrix\Main\Sms\Event(
					"SMS_USER_CONFIRM_NUMBER",
					[
						"USER_PHONE" => $phoneNumber,
						"CODE" => $code,
					]
				);
				$smsResult = $sms->send(true);

				if(!$smsResult->isSuccess())
				{
					$arResult["ERRORS"] = array_merge($arResult["ERRORS"], $smsResult->getErrorMessages());
				}

				$arResult["SHOW_SMS_FIELD"] = true;
				$arResult["SIGNED_DATA"] = \Bitrix\Main\Controller\PhoneAuth::signData(['phoneNumber' => $phoneNumber]);
			}
			else
			{
				$register_done = true;

				// authorize user
				if ($arParams["AUTH"] == "Y" && $arResult["VALUES"]["ACTIVE"] == "Y")
				{
					if (!$arAuthResult = $USER->Login($arResult["VALUES"]["LOGIN"], $arResult["VALUES"]["PASSWORD"]))
						$arResult["ERRORS"][] = $arAuthResult;
				}
			}

			$arResult['VALUES']["USER_ID"] = $ID;

			$arEventFields = $arResult['VALUES'];
			unset($arEventFields["PASSWORD"]);
			unset($arEventFields["CONFIRM_PASSWORD"]);

			// отправляем на почту запрос на подтврждение почты
			// в случае, если идет регистрация юр лица, то отправка не проходит
			$event = new CEvent;
			$event->Send("NEW_USER", SITE_ID, $arEventFields);
			if($arResult['VALUES']["EMAIL"]){
				if($arResult['VALUES']['FACE'] == 'TYPE_F'){
					$event_ext->sendNewUser($arEventFields);
				}else{
					$arEventFields["ORGANIZATION_NAME"] = $_REQUEST['NAME_TYPE_U'];
					$arEventFields["NAME"] = $userPrName." ".$userPrMiddlename;
					$arEventFields["SUBDIVISION"] = $_REQUEST['NAME_SUBDIVISION'];
					$arEventFields["LOGIN"] = $arResult['VALUES']['LOGIN'];
					$event_ext->sendNewUserLegalFace($arEventFields);
				}
			}
		}
		else
		{
			$arResult["ERRORS"][] = $user->LAST_ERROR;
		}

		if(count($arResult["ERRORS"]) <= 0)
		{
			if(COption::GetOptionString("main", "event_log_register", "N") === "Y")
				CEventLog::Log("SECURITY", "USER_REGISTER", "main", $ID);
		}
		else
		{
			if(COption::GetOptionString("main", "event_log_register_fail", "N") === "Y")
				CEventLog::Log("SECURITY", "USER_REGISTER_FAIL", "main", $ID, implode("<br>", $arResult["ERRORS"]));
		}

		$events = GetModuleEvents("main", "OnAfterUserRegister", true);
		foreach ($events as $arEvent)
			ExecuteModuleEventEx($arEvent, array(&$arResult['VALUES']));
	}
}

// verify phone code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["code_submit_button"] <> '' && !$USER->IsAuthorized())
{
	if($_REQUEST["SIGNED_DATA"] <> '')
	{
		if(($params = \Bitrix\Main\Controller\PhoneAuth::extractData($_REQUEST["SIGNED_DATA"])) !== false)
		{
			if(($userId = CUser::VerifyPhoneCode($params['phoneNumber'], $_REQUEST["SMS_CODE"])))
			{
				$register_done = true;

				if($arResult["PHONE_REQUIRED"])
				{
					//the user was added as inactive, now phone number is confirmed, activate them
					$user = new CUser();
					$user->Update($userId, ["ACTIVE" => "Y"]);
				}

				// authorize user
				if ($arParams["AUTH"] == "Y")
				{
					//here should be login
					$USER->Authorize($userId);
				}
			}
			else
			{
				$arResult["ERRORS"][] = GetMessage("main_register_error_sms");
				$arResult["SHOW_SMS_FIELD"] = true;
				$arResult["SMS_CODE"] = $_REQUEST["SMS_CODE"];
				$arResult["SIGNED_DATA"] = $_REQUEST["SIGNED_DATA"];
			}
		}
	}
}
// if user is registered - redirect him to backurl or to success_page; currently added users too
if($register_done)
{
	if($arParams["USE_BACKURL"] == "Y" && $_REQUEST["backurl"] <> '')
		LocalRedirect($_REQUEST["backurl"]);
	elseif($arParams["SUCCESS_PAGE"] <> '')
		LocalRedirect($arParams["SUCCESS_PAGE"].'&email='.$email);
}

$arResult["VALUES"] = htmlspecialcharsEx($arResult["VALUES"]);

// redefine required list - for better use in template
$arResult["REQUIRED_FIELDS_FLAGS"] = array();
foreach ($arResult["REQUIRED_FIELDS"] as $field)
	$arResult["REQUIRED_FIELDS_FLAGS"][$field] = "Y";

// check backurl existance
$arResult["BACKURL"] = htmlspecialcharsbx($_REQUEST["backurl"]);

// get countries list
if (in_array("PERSONAL_COUNTRY", $arResult["SHOW_FIELDS"]) || in_array("WORK_COUNTRY", $arResult["SHOW_FIELDS"])) 
	$arResult["COUNTRIES"] = GetCountryArray();

// get date format
if (in_array("PERSONAL_BIRTHDAY", $arResult["SHOW_FIELDS"])) 
	$arResult["DATE_FORMAT"] = CLang::GetDateFormat("SHORT");

// ********************* User properties ***************************************************
$arResult["USER_PROPERTIES"] = array("SHOW" => "N");
$arUserFields = $USER_FIELD_MANAGER->GetUserFields("USER", 0, LANGUAGE_ID);
if (is_array($arUserFields) && count($arUserFields) > 0)
{
	if (!is_array($arParams["USER_PROPERTY"]))
		$arParams["USER_PROPERTY"] = array($arParams["USER_PROPERTY"]);

	foreach ($arUserFields as $FIELD_NAME => $arUserField)
	{
		if (!in_array($FIELD_NAME, $arParams["USER_PROPERTY"]) && $arUserField["MANDATORY"] != "Y")
			continue;

		$arUserField["EDIT_FORM_LABEL"] = strLen($arUserField["EDIT_FORM_LABEL"]) > 0 ? $arUserField["EDIT_FORM_LABEL"] : $arUserField["FIELD_NAME"];
		$arUserField["EDIT_FORM_LABEL"] = htmlspecialcharsEx($arUserField["EDIT_FORM_LABEL"]);
		$arUserField["~EDIT_FORM_LABEL"] = $arUserField["EDIT_FORM_LABEL"];
		$arResult["USER_PROPERTIES"]["DATA"][$FIELD_NAME] = $arUserField;
	}
}
if (!empty($arResult["USER_PROPERTIES"]["DATA"]))
{
	$arResult["USER_PROPERTIES"]["SHOW"] = "Y";
	$arResult["bVarsFromForm"] = (count($arResult['ERRORS']) <= 0) ? false : true;
}
// ******************** /User properties ***************************************************

// initialize captcha
if ($arResult["USE_CAPTCHA"] == "Y")
	$arResult["CAPTCHA_CODE"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

// set title
if ($arParams["SET_TITLE"] == "Y") 
	$APPLICATION->SetTitle(GetMessage("REGISTER_DEFAULT_TITLE"));

//time zones
$arResult["TIME_ZONE_ENABLED"] = CTimeZone::Enabled();
if($arResult["TIME_ZONE_ENABLED"])
	$arResult["TIME_ZONE_LIST"] = CTimeZone::GetZones();

$arResult["SECURE_AUTH"] = false;
if(!CMain::IsHTTPS() && COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
{
	$sec = new CRsaSecurity();
	if(($arKeys = $sec->LoadKeys()))
	{
		$sec->SetKeys($arKeys);
		$sec->AddToForm('regform', array('REGISTER[PASSWORD]', 'REGISTER[CONFIRM_PASSWORD]'));
		$arResult["SECURE_AUTH"] = true;
	}
}

// all done
$this->IncludeComponentTemplate();
