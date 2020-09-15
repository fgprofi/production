<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$bx_photo = CIBlockElement::GetProperty(
   $_REQUEST["IBLOCK_ID"], 
   $_REQUEST["PROFILE_ID"], 
   'sort', 
   'asc', 
   array('CODE' => 'PHOTO')
);
$ar_photo = $bx_photo->Fetch();

CIBlockElement::SetPropertyValueCode($_REQUEST['PROFILE_ID'], 'PHOTO', array(
   $ar_photo['PROPERTY_VALUE_ID'] => array('del' => 'Y', 'tmp_name' => '')
));
echo '<div class="cabinet-user__load-photo_box no_logo"><img src="/bitrix/components/deus/news.detail/templates/user_profile_edit/images/photo.svg"></div>';
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

// if(CIBlockElement::SetPropertyValueCode( $_REQUEST['PROFILE_ID'], "PHOTO", "" )){
// 	echo "1";
// }