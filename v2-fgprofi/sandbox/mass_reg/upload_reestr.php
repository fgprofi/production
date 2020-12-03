<?

use reestr\sendMessage;

require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php' );
require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/spreadsheet-reader-master/php-excel-reader/excel_reader2.php' );
require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/spreadsheet-reader-master/SpreadsheetReader.php' );
require( $_SERVER['DOCUMENT_ROOT'] . "/sandbox/mass_reg/classes/autoregistration.php" );
// загрузчик файла в папку
?>
    <head>
        <title></title>
    </head>

    <body>
    <form method="GET">
        <div class="download_input" data-input-name="REESTR[]">
			<?
			$APPLICATION->IncludeComponent( "bitrix:main.file.input", "drag_n_drop",
				array(
					"INPUT_NAME"       => "REESTR",
					"MULTIPLE"         => "Y",
					"MODULE_ID"        => "main",
					"MAX_FILE_SIZE"    => "",
					"ALLOW_UPLOAD"     => "A",
					"ALLOW_UPLOAD_EXT" => ""
				),
				false
			); ?>
        </div>
        <div class="btn send-photo nosend">Отправить</div>
    </form>
    <script>
        $ (function () {
            $ (".download_input>a>span").addClass ("btn");
        });
        $(document).ready(function(){
        	$(".send-photo.nosend").click(function(){
        		var data = $(this).parents("form").serializeArray();
	        	$.ajax( {
				    type: "POST",
				    url: "/ajax/uploadFile.php",
				    data: data,
				    dataType: "html",
				    success: function( responseData ) {
				    	console.log(responseData);
				    }
				});
			});
        });
    </script>
    </body>

    </html>

<?
$el = new CIBlockElement;
// получаем даные из файла xlsx и помещаем в csv для дальнейшей работы
//include '../classes/simplexlsx.class.php';
//$xlsx = new SimpleXLSX( 'reestr.xlsx' );
//$fp = fopen( 'reestr.csv', 'w');
//foreach( $xlsx->rows() as $fields ) {
//	fputcsv( $fp, $fields);
//}
//fclose($fp);

// перебираем данные и создаем пользователей
$files  = $_SERVER['DOCUMENT_ROOT'] . "/sandbox/mass_reg/reestr.xlsx";
$Reader = new SpreadsheetReader( $files );
$Sheets = $Reader->Sheets();

// подключаем рассыльщика
$event = new reestr\sendMessage();

//здесь храним массив со всеми данными, которые нужно залить в реестр
$file_as_array = array();
foreach ( $Sheets as $Index => $Name ) {
	$Reader->ChangeSheet( $Index );

	foreach ( $Reader as $ind => $Row ) {
		if ( $ind == 0 ) {
			$file_as_array[ $Name ]['NAMES'] = $Row;
		}
		if ( $ind == 1 ) {
			$file_as_array[ $Name ]['FIELDS'] = $Row;
		}
		if ( $ind > 1 ) {
			$ar = array();
			foreach ( $Row as $i => $line ) {
				$ar[ str_replace( array( '`', ' ' ), '', $file_as_array[ $Name ]['FIELDS'][ $i ] ) ] = $Row[ $i ];
			}
			$file_as_array[ $Name ]['DATA'][] = $ar;
		}
	}
}

// перебираем созданный выше массив согласно условию
$Autoregistration = new Autoregistration();
$arRes            = array();
foreach ( $file_as_array['Физлица']['DATA'] as $person ) {

	//проверяем наличие пользователя
	$ready_user = CUser::GetByLogin( $person['EMAIL'] )->Fetch();

	if ( ! $ready_user ) {
		// создаем пользователя и отправляем письмо пользователю с приглашением к дальнейшему заполнению профиля
		$user_id = $Autoregistration->create_user( $person );
		// создаем элементы в инфоблоке согласно типу пользователя
		if ( $user_id ) {
			$PROP     = array();
			$PROP[1]  = $person['LAST_NAME'];
			$PROP[2]  = $person['SECOND_NAME'];
			$PROP[75] = $person['FIRST_NAME'];
			$PROP[10] = $person['EMAIL'];
			$PROP[12] = $person['WORK_PLACE'];
			$PROP[72] = $person['ID'];
			$PROP[73] = $user_id;
			$PROP[19] = explode( ';', $person['MATERIAL_AUTHOR'] );

			$arLoadProductArray = Array(
				"IBLOCK_ID"       => 7,
				"PROPERTY_VALUES" => $PROP,
				"NAME"            => $person['LAST_NAME'] . ' ' . $person['FIRST_NAME'] . ' ' . $person['SECOND_NAME'],
				"ACTIVE"          => "Y",            // активен
			);
			$PRODUCT_ID         = $el->Add( $arLoadProductArray );
			$user               = new CUser;
			$userInfoField      = "UF_USER_INFO_" . $_POST["FACE"];
			$fields             = Array(
				$userInfoField => $PRODUCT_ID,
			);
			if($user->Update( intval( $user_id ), $fields )){
				$event->sendInviteFiz($person);
            }
		}
	}
}


foreach ( $file_as_array['ЮрЛица']['DATA'] as $person ) {
	//проверяем наличие пользователя
	$ready_user = CUser::GetByLogin( $person['OGRN'] )->Fetch();

	if ( ! $ready_user && $person['OGRN'] ) {

		// создаем пользователя и отправляем письмо пользователю с приглашением к дальнейшему заполнению профиля
		$user_id = $Autoregistration->create_user( $person, true );

		// создаем элементы в инфоблоке согласно типу пользователя
		$resp = CIBlockElement::GetList( array(), array( "IBLOCK_ID"         => 7,
		                                                 "PROPERTY_MARGE_ID" => $person['ID']
		),false,false,array("ID","NAME","PROPERTY_FIRST_NAME","PROPERTY_SURNAME") )->Fetch();

		$PROP     = array();
		$PROP[33] = $person['OGRN'];
		$PROP[31] = $person['INN'];
		$PROP[30] = $person['ORGANIZATION_TYPE'];
		$PROP[34] = $person['FG_DEPARTAMENT'];
		$PROP[37] = $person['ADDRESS'];
		$PROP[38] = $person['PHONE'];
		$PROP[40] = $person['SITE'];
		$PROP[71] = $person['ID'];
		$PROP[76] = $person['NAME'];
		$PROP[74] = $user_id;
		$PROP[47] = explode( ';', $person['MATERIAL_WORKER'] );
		$PROP[41] = array( $resp['ID'] );

		$arLoadProductArray = Array(
			"IBLOCK_ID"       => 8,
			"PROPERTY_VALUES" => $PROP,
			"NAME"            => $person['ORGANIZATION_TYPE'] . ' ' . $person['NAME'],
			"ACTIVE"          => "Y",            // активен
		);
		$PRODUCT_ID         = $el->Add( $arLoadProductArray );
		$user               = new CUser;
		$userInfoField      = "UF_USER_INFO_" . $_POST["FACE"];
		$fields             = Array(
			$userInfoField => $PRODUCT_ID,
		);
		if($user->Update( intval( $user_id ), $fields )){
		    $person['FIRST_NAME'] = $resp["PROPERTY_FIRST_NAME_VALUE"];
		    $person['LAST_NAME'] = $resp["PROPERTY_SURNAME_VALUE"];
			$event->sendInviteUr($person);
        }
	}

}


require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php' );
