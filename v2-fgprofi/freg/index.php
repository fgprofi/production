<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?><?$APPLICATION->IncludeComponent(
	"deus:main.register",
	"freg",
	Array(
		"AUTH" => "N",
		"REQUIRED_FIELDS" => Array(),
		"SEF_FOLDER" => "/freg/",
		"SEF_MODE" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => Array(),
		"SUCCESS_PAGE" => "/auth/?success=Y",
		"USER_PROPERTY" => Array(),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"VARIABLE_ALIASES" => Array()
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>