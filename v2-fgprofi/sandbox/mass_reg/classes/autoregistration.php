<?php
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

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)
	die();


class Autoregistration {

	public function __construct() {
	}

	public function create_user($person, $type_ur = false) {
		global $APPLICATION;
		global $DB;
		$arResult = array();
		$arResult['VALUES']["GROUP_ID"] = array( 5, 8 );

		$bConfirmReq = ( $arResult["USE_EMAIL_CONFIRMATION"] === "Y" );
		$active      = ( $bConfirmReq || $arResult["PHONE_REQUIRED"] ? "N" : "Y" );

		$login = $person['EMAIL'];
		$name = $person['FIRST_NAME'];
		$last_name = $person['LAST_NAME'];
		// если прилетело юрлицо
		if($type_ur){
			$login = $person['OGRN'];
			$name = $person['NAME'];
			$last_name = $person['ORGANIZATION_TYPE'];
		}

		$arResult['VALUES']["LOGIN"]            = $login;
		$arResult['VALUES']["NAME"]             = $name;
		$arResult['VALUES']["LAST_NAME"]        = $last_name;
		$arResult['VALUES']["EMAIL"]            = $person['EMAIL'];
		$arResult['VALUES']["PASSWORD"]         = randString( 8 );
		$arResult['VALUES']["CONFIRM_PASSWORD"] = $arResult['VALUES']["PASSWORD"];

		$arResult['VALUES']["CHECKWORD"]       = md5( CMain::GetServerUniqID() . uniqid() );
		$arResult['VALUES']["~CHECKWORD_TIME"] = $DB->CurrentTimeFunction();
		$arResult['VALUES']["ACTIVE"]          = $active;
		$arResult['VALUES']["CONFIRM_CODE"]    = ( $bConfirmReq ? randString( 8 ) : "" );
		$arResult['VALUES']["LID"]             = SITE_ID;
		$arResult['VALUES']["LANGUAGE_ID"]     = LANGUAGE_ID;

		$arResult['VALUES']["USER_IP"]   = $_SERVER["REMOTE_ADDR"];
		$arResult['VALUES']["USER_HOST"] = @gethostbyaddr( $_SERVER["REMOTE_ADDR"] );

		if ( $arResult["VALUES"]["AUTO_TIME_ZONE"] <> "Y" && $arResult["VALUES"]["AUTO_TIME_ZONE"] <> "N" ) {
			$arResult["VALUES"]["AUTO_TIME_ZONE"] = "";
		}

		$bOk = true;

		$events = GetModuleEvents( "main", "OnBeforeUserRegister", true );
		foreach ( $events as $arEvent ) {
			if ( ExecuteModuleEventEx( $arEvent, array( &$arResult['VALUES'] ) ) === false ) {
				if ( $err = $APPLICATION->GetException() ) {
					$arResult['ERRORS'][] = $err->GetString();
				}

				$bOk = false;
				break;
			}
		}


		$ID   = 0;

		$user = new CUser();
		if ( $bOk ) {
			$ID = $user->Add( $arResult["VALUES"] );
		}

		if ( intval( $ID ) > 0 ) {

			$register_done = true;

			$arResult['VALUES']["USER_ID"] = $ID;

			$arEventFields = $arResult['VALUES'];
//			unset( $arEventFields["PASSWORD"] );
			unset( $arEventFields["CONFIRM_PASSWORD"] );
// отправка сообщений
//			$event = new CEvent;
//			$event->SendImmediate( "NEW_USER", SITE_ID, $arEventFields );
//			if ( $bConfirmReq ) {
//				$event->SendImmediate( "NEW_USER_CONFIRM", SITE_ID, $arEventFields );
//			}
		}
		return $ID;
	}
}