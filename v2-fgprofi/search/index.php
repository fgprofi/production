<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>
<main class="main">
    <div class="content">
    	<div class="containered">
            <? $APPLICATION->IncludeComponent("bitrix:menu", "sidebar", Array(
                        "ROOT_MENU_TYPE" => "left",  // Тип меню для первого уровня
                        "MENU_CACHE_TYPE" => "N",   // Тип кеширования
                        "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                        "MENU_CACHE_USE_GROUPS" => "Y", // Учитывать права доступа
                        "MENU_CACHE_GET_VARS" => "",    // Значимые переменные запроса
                        "MAX_LEVEL" => "2", // Уровень вложенности меню
                        "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                        "USE_EXT" => "Y",   // Подключать файлы с именами вида .тип_меню.menu_ext.php
                        "MENU_INCLUDE_FILE" => ".left_menu_include.php",
                        "DELAY" => "N", // Откладывать выполнение шаблона меню
                        "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                        "COMPONENT_TEMPLATE" => "sidebar"
                    ),
                    false
                );
                ?>
    		<div class="main-content">
				<?$APPLICATION->IncludeComponent(
					"bitrix:search.page", 
					".default", 
					array(
						"RESTART" => "Y",
						"CHECK_DATES" => "N",
						"USE_TITLE_RANK" => "N",
						"DEFAULT_SORT" => "rank",
						"FILTER_NAME" => "",
						"arrFILTER" => array(
							0 => "iblock_news",
						),
						"arrFILTER_main" => "",
						"arrFILTER_forum" => array(
							0 => "all",
						),
						"arrFILTER_iblock_photos" => array(
							0 => "all",
						),
						"arrFILTER_iblock_news" => array(
							0 => "all",
						),
						"arrFILTER_iblock_services" => array(
							0 => "all",
						),
						"arrFILTER_iblock_job" => array(
							0 => "all",
						),
						"arrFILTER_blog" => array(
							0 => "all",
						),
						"SHOW_WHERE" => "Y",
						"arrWHERE" => array(
							0 => "iblock_news",
						),
						"SHOW_WHEN" => "N",
						"PAGE_RESULT_COUNT" => "10",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_SHADOW" => "Y",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "Результаты поиска",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => "",
						"USE_SUGGEST" => "N",
						"SHOW_ITEM_TAGS" => "Y",
						"TAGS_INHERIT" => "Y",
						"SHOW_ITEM_DATE_CHANGE" => "Y",
						"SHOW_ORDER_BY" => "Y",
						"SHOW_TAGS_CLOUD" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"SHOW_RATING" => "Y",
						"PATH_TO_USER_PROFILE" => "/forum/user/#USER_ID#/",
						"COMPONENT_TEMPLATE" => ".default",
						"NO_WORD_LOGIC" => "Y",
						"USE_LANGUAGE_GUESS" => "Y",
						"RATING_TYPE" => ""
					),
					false
				);?>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>