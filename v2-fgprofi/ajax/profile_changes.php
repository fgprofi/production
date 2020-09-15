<?php
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php" );
// echo json_encode( array( 'id'        => $arData['id'],
// 		                         'pass'      => $change_pass,
// 		                         'trash'     => $arData['trash'],
// 		                         'moderator' => $moderator,
// 		                         'user'      => $new_pass,
// 		                         'unlock'    => $unlock,
// 		                         'r'         => $r,
// 		                         'error'     => $strError .= $user->LAST_ERROR,
// 		                         'redirect'  => $redirect_to,
// 		) );
// die();
$event = new reestr\sendMessage();

if ( isset( $_REQUEST ) ) {
	$arData = $_REQUEST;
	// echo "<pre>"; print_r($arData); echo "</pre>";
	// die();
	if ( CModule::IncludeModule( "iblock" ) ) {
		$arData           = $_REQUEST;
//		echo json_encode($arData);
//		die();
		$unlock           = $arData['active'];
		$trash            = $arData['trash'];
		$change_pass      = $arData['change_pass'];
		$moderator        = $arData['moderator'];
		$internal_comment = $arData['internal_comment'];
		$checkmf = $arData["checkmf"];
		$redirect_to = '';
		$arRedirect = array(
			7 => '/admin/queries_u/',
			8 => '/admin/queries_f/',
		);
		$obEl    = new CIBlockElement();
		$arUsers = array();
		if ( ! is_array( $arData['id'] ) ) {
			$buf = $arData['id'];
			unset($arData['id']);
			$arData['id'][] = $buf;
		}
//		echo json_encode($arData['id']);
//		die();
		// перебираем всех пользователей
		foreach ( $arData['id'] as $usr ) {
			$ob     = $obEl->getByID( $usr )->getNextElement();
			$fields = $ob->getFields();
			$props  = $ob->getProperties();

			//блокировка карточки
			if ( $fields['ACTIVE'] == 'Y' && $unlock == 'false' ) {
				$obEl->Update( $usr, array( 'ACTIVE' => 'N' ) );

				$r = $event->sendDeactivateUser( array( 'fields' => $fields, 'props' => $props ) );

			}
			if ( $fields['ACTIVE'] == 'N' && $unlock == 'true' ) {
				$obEl->Update( $usr, array( 'ACTIVE' => 'Y' ) );
				$event->sendActivateUser( array( 'fields' => $fields, 'props' => $props ) );
			}
			if ( $fields['ACTIVE'] == 'Y' && $unlock == 'true'  && $change_pass != 'true') {
				$obEl->Update( $usr, array( 'ACTIVE' => 'N' ) );
				$event->sendActivateUser( array( 'fields' => $fields, 'props' => $props ) );
			}
			if ( $unlock == 'Y' || $unlock == 'N' ) {
				$obEl->Update( $usr, array( 'ACTIVE' => $unlock ) );
				if ( $unlock == 'N' ) {
					$event->sendDeactivateUser( array( 'fields' => $fields, 'props' => $props ) );
				} else {
					$event->sendActivateUser( array( 'fields' => $fields, 'props' => $props ) );
				}
			}

			//разрешение от МинФина
			if ( $checkmf != '') {
				if($checkmf == "0" ){
					$checkmf = '';
				}
				$ar = $obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'PROOF_MINFIN' => $checkmf ) );
				$event->sendCheckMinFinUser( array( 'fields' => $fields, 'props' => $props ),  $checkmf);
			}
			
			//проверка модератором пройдена или нет
			if ( $moderator != '' && $moderator >= 0 ) {
				( $moderator == 0 ) ? $moderator = '' : $moderator;
				$ar = $obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'VERIFICATION_PASSED_BY_MODERATOR' => $moderator ) );
				$sendData = array( 'fields' => $fields, 'props' => $props ,"value"=>$moderator);
				// echo json_encode($sendData);
				// die();
				$event->sendModerateUser( $sendData );

				//echo json_encode(array("1111"));
				$redirect_to = $arRedirect[$fields['IBLOCK_ID']];
			}

			//признак удаления карточки
			$defTrashVal = 3;
			if($arData["user_type"] == "TYPE_U"){
				$defTrashVal = 9;
			}
			if ( $props['SIGN_OF_USER_DATA_DELETION']['VALUE_ENUM_ID'] != $defTrashVal && $trash == 'true' ) {
				$obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'SIGN_OF_USER_DATA_DELETION' => $defTrashVal ) );
				$event->sendDeleteUser( array( 'fields' => $fields, 'props' => $props ) );
			}
			if ( $props['SIGN_OF_USER_DATA_DELETION']['VALUE_ENUM_ID'] == $defTrashVal && $trash == 'true' ) {
				$obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'SIGN_OF_USER_DATA_DELETION' => '' ) );
				$event->sendRefurbUser( array( 'fields' => $fields, 'props' => $props ) );
			}


			if ( isset($arData['trash']) ) {
				if(is_int( $trash ) || ($trash != 'true' && $trash != 'false')){
					$trash = (int) $trash;
					( $trash == 0 ) ? $trash = '' : $trash;

					$ar = $obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'SIGN_OF_USER_DATA_DELETION' => $trash ) );
					if ( $trash ) {
						$event->sendDeleteUser( array( 'fields' => $fields, 'props' => $props ) );
					} else {
						$event->sendRefurbUser( array( 'fields' => $fields, 'props' => $props ) );
					}
				}
			}

			// сбрасываем пароль
			if ( $change_pass == 'true' ) {
				$user_id  = $props['USER_ID']['VALUE'];
				$new_pass = "!1".randString( 8 );
				$user     = new CUser;
				$fields   = Array(
					"PASSWORD"         => $new_pass,
					"CONFIRM_PASSWORD" => $new_pass,
				);
				//$user->Update( $user_id, $fields );
				//if ( ! $user->LAST_ERROR ) {
					$event->sendChangePassUserByAdmin( array( 'fields' => $fields, 'props' => $props ), $new_pass );
				//}
			}

			// добавляем внутренний комментарий
			if ( $internal_comment != '' && $usr ) {
				$ar = $obEl->SetPropertyValuesEx( $usr, $fields['IBLOCK_ID'], array( 'INTERNAL_COMMENTS' => array( "VALUE" => $internal_comment ) ) );
			}
		}

		echo json_encode( array( 'id'        => $arData['id'],
		                         'pass'      => $change_pass,
		                         'trash'     => $arData['trash'],
		                         'moderator' => $moderator,
		                         'user'      => $new_pass,
		                         'unlock'    => $unlock,
		                         'r'         => $r,
		                         'error'     => $strError .= $user->LAST_ERROR,
		                         'redirect'  => $redirect_to,
		) );
	}
}
