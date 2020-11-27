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
foreach ($arResult['ITEMS'] as $item) {
    $key = FormatDate("d F", MakeTimeStamp($item["DATE_ACTIVE_TO"]));
    $arResult['ITEMS_F'][$key][] = $item;
    // echo"<pre>";
    // print_r($item["DATE_ACTIVE_TO"]);
    // echo"</pre>";
}

?>
<div class="newsletter__content">
    <?foreach($arResult['ITEMS_F'] as $groopKey => $groop):?>
        <div class="newsletter__date">
            <div class="newsletter__date-header"><?=$groopKey?></div>
            <?foreach($groop as $item):?>
                <a id="item-<?=$item["ID"]?>" href="<?=$item["DETAIL_PAGE_URL"]?>" class="newsletter__item">
                    <div class="newsletter__img"></div>
                    <div class="newsletter-text">
                        <div class="newsletter__name"><?=$item["NAME"]?></div>
                        <?$face = "Физические лица";
                        $firstFace = array_shift($arResult['ITEMS'][0]["DISPLAY_PROPERTIES"]["USERS"]["LINK_ELEMENT_VALUE"]);
                        if($firstFace["IBLOCK_ID"] == 8){
                            $face = "Юридические лица";
                        }?>
                        <div class="newsletter__subtitle">№<?=str_pad($item["PROPERTIES"]["COUNTER"]["VALUE"], 3, '0', STR_PAD_LEFT);?> | <?=$item["DISPLAY_PROPERTIES"]["RUBRIC"]["DISPLAY_VALUE"]?> | <?=$face?></div>
                        <div class="newsletter__descr"><?=$item["PREVIEW_TEXT"]?></div>
                    </div>
                </a>
            <?endforeach;?>
        </div>
    <?endforeach;?>
</div>