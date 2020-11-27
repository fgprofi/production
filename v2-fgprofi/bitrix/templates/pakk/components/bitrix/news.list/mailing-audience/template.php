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

// echo"<pre>";
// print_r($arResult['ITEMS']);
// echo"</pre>";
//die();
?>
<div class="newsletter__content">
    <?if(isset($arResult['ITEMS']) && count($arResult['ITEMS'])>0):
        $face = "Физические лица";
        $firstFace = array_shift($arResult['ITEMS'][0]["DISPLAY_PROPERTIES"]["USERS"]["LINK_ELEMENT_VALUE"]);
        if($firstFace["IBLOCK_ID"] == 8){
            $face = "Юридические лица";
        }?>
        <?foreach($arResult['ITEMS'] as $item):?>
            <a id="item-<?=$item["ID"]?>" href="<?=$item["DETAIL_PAGE_URL"]?>" class="newsletter__item newsletter__item--audience item-<?=$item["ID"]?>">
                <div class="newsletter__img newsletter__img--audience"></div>
                <div class="newsletter-text">
                    <div class="newsletter__name"><?=$item["NAME"]?></div>
                    <?/*<div class="newsletter__subtitle">№003 | Преподователи | Жещины, Мужчины | 23 - 48 лет |</div>*/?>
                    <div class="newsletter__subtitle">№<?=str_pad($item["PROPERTIES"]["COUNTER"]["VALUE"], 3, '0', STR_PAD_LEFT);?> | <?=$face?></div>
                    <div class="newsletter__descr"><?=$item["PREVIEW_TEXT"]?></div>
                </div>
                <div class="newsletter__item-delete">
                    <div class="newsletter__form-trash-wrap" data-id="<?=$item["ID"]?>">
                        <div class="newsletter__form-trash"></div>
                    </div>
                </div>
            </a>
        <?endforeach;?>
    <?endif;?>
</div>