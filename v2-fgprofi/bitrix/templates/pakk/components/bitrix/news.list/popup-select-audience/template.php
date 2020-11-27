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
//die();?>
<div id="audience-popup" class="audience-popup">
    <div class="audience-popup__title">Выбрать из аудитории</div>
    <div class="audience-popup__content">
        <?foreach($arResult['ITEMS'] as $item):?>
            <div class="audience-popup__item" data-id="<?=$item["ID"]?>">
                <div class="audience-popup__item-name"><?=$item["NAME"]?></div>
                <div class="audience-popup__item-text"><?=$item["PREVIEW_TEXT"]?></div>
            </div>
        <?endforeach;?>
    </div>
    <div class="audience-popup__btns">
        <button class="link link-button select-item">Выбрать</button>
        <button class="link link-button link-button--cansel">Отменить<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
    </div>
</div>
<a href="#audience-popup" class="fancybox-popup__link" id="popup-audience" style="display: none;"><span> </span></a>