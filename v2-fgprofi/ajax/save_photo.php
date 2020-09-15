<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$pURL = CFile::GetPath($_REQUEST['PROPERTY_PHOTO']);
$newFileArr = CFile::MakeFileArray( $pURL );
CIBlockElement::SetPropertyValueCode( $_REQUEST['PROFILE_ID'], "PHOTO", array($newFileArr) );