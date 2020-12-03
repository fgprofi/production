<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");

// $APPLICATION->IncludeComponent("bitrix:main.map", ".default", array(
// 	"CACHE_TYPE" => "A",
// 	"CACHE_TIME" => "36000000",
// 	"SET_TITLE" => "Y",
// 	"LEVEL"	=>	"3",
// 	"COL_NUM"	=>	"2",
// 	"SHOW_DESCRIPTION" => "Y"
// 	),
// 	false
// ); 
?>

<section class="section-404">
	<h2 class="section-404__heading">Ошибка 404</h2>
	<p class="section-404__text">Страницы не существует или она была удалена</p>
	<div class="section-404__btns">
		<a href="#" onclick="javascript:history.back(); return false;" class="section-404__back">Вернуться назад</a>
		<a href="/" class="section-404__main">На главную</a>
	</div>
</section>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>