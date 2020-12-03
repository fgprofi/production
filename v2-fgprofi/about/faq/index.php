<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Частые вопросы"); 
?>
<main class="main main--snow">
    <div class="content">
        <div class="containered">
            <?global $USER;
            if($USER->IsAuthorized()):?>
                <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
            <?else:?>
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
            <?endif;?>
            <?$APPLICATION->IncludeComponent(
                "deus:faq",
                "",
                Array(
                    "IBLOCK_ID" => 12,
                    "REGISTER_IBLOCK_ID" => 13
                )
            );?>
        </div>
    </div>
</main>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>