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
?>
<main class="main">
    <div class="main__header header-main">
        <div class="containered">
            <div class="header-main__content">
                <div class="header-main__block-button">
                    <a class="header-main__button" href="/">назад</a>
                </div>
                <h1 class="header-main__title">Пресс-центр</h1>
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
                <div class="news__list">
	                <?foreach($arResult["ITEMS"] as $arItem):
                        $arDate = explode('.',$arItem['ACTIVE_FROM']);
	                    $month = getRusMonth($arDate[1],true);
	                    $date = $arDate[0].' '.$month.' '.$arDate[2];
		                $file =  CFile::ResizeImageGet( $arItem['PREVIEW_PICTURE']['ID'], array( 'width'  => 500,
		                                                                                 'height' => 500
		                ), BX_RESIZE_IMAGE_EXACT, true );
                        ?>
                    <div class="news__item item-news">
                        <div class="item-news__top">
                            <div class="item-news__left">
                                <div class="item-news__img-wrap">
                                    <img class="item-news__img"
                                         src="<?=$file['src']?>"
                                         alt="">
                                </div>
                            </div>
                            <div class="item-news__right">
                                <p class="item-news__title"><a href="/news/<?=$arItem['CODE']?>/"><?=$arItem['NAME']?></a></p>
                                <p class="item-news__date"><?=$date?></p>
                            </div>
                        </div>
                        <div class="item-news__bottom">
                            <p class="item-news__desc"><?=$arItem['PREVIEW_TEXT']?><a class="item-news__read-more" href="/news/<?=$arItem['CODE']?>/">Читать далее »</a>
                            </p>
                        </div>
                    </div>
	                <?endforeach;?>
                </div>
	            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                    <?=$arResult["NAV_STRING"]?>
	            <?endif;?>
            </div>
        </div>
    </div>
</main>

