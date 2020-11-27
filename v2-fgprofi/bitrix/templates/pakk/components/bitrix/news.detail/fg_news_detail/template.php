<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$detail_pic =  CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], array( 'width'  => 600,
                                                                                       'height' => 600
), BX_RESIZE_IMAGE_EXACT, true );

$arDate = explode('.',$arResult['ACTIVE_FROM']);
$month = getRusMonth($arDate[1],true);
$date = $arDate[0].' '.$month.' '.$arDate[2];
?>
<main class="main">
    <div class="main__header header-main">
        <div class="containered">
            <div class="header-main__content">
                <div class="header-main__block-button">
                    <a class="header-main__button" href="/news/">назад</a>
                </div>
                <h1 class="header-main__title"><?=$arResult['NAME']?></h1>
            </div>
        </div>
    </div>

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
                <div class="detail-news">
                    <div class="detail-news__caption">
                        <div class="detail-news__left">
                            <div class="detail-news__img-wrap">
                                <img class="detail-news__img"
                                     src="<?=$detail_pic['src']?>"
                                     alt="">
                            </div>
                        </div>
                        <div class="detail-news__right">
                            <p class="detail-news__title"><?=$arResult['NAME']?></p>
                            <p class="detail-news__date"><?=$date?></p>
                            <p class="detail-news__desc"><?=$arResult["PREVIEW_TEXT"]?></p>
                        </div>
                    </div>
                    <div class="detail-news__content">
                        <?=$arResult["DETAIL_TEXT"];?>
                        <?if($arResult["DISPLAY_PROPERTIES"]["SHOW_PDF"]["VALUE"]):?>
                            <br>
                            <embed src="<?=$arResult["DISPLAY_PROPERTIES"]["PDF"]["FILE_VALUE"]["SRC"]?>" width="100%" height="1100px" />
                            <br>
                        <?endif;?>
                        
                        <?if($arResult["DISPLAY_PROPERTIES"]["PDF"]["FILE_VALUE"]["SRC"]):?>
                            <a href="<?=$arResult["DISPLAY_PROPERTIES"]["PDF"]["FILE_VALUE"]["SRC"]?>" target="_blank"><?=$arResult["DISPLAY_PROPERTIES"]["PDF"]["FILE_VALUE"]["ORIGINAL_NAME"]?></a>
                        <?endif;?>
                        <?/*global $USER;?>
                        <?if($USER->IsAdmin()){
                            echo "<pre>"; print_r($arResult["DISPLAY_PROPERTIES"]["PDF"]); echo "</pre>";
                        }*/?>
                    </div>
                </div>
                <a class="link link-button link-button_orange" href="/news/">назад</a>
            </div>
        </div>
    </div>
</main>