<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 *
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 *
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $USER;
?>
<div class="faq-personal">
    <div class="faq-wrap">

    <h2 class="faq__title">Частые вопросы</h2>
        <?foreach($arResult["ITEMS"] as $section_id => $arElements):?>
            <?//echo "<pre>"; print_r($arResult["SECTION"]); echo "</pre>";?>
            <?if($section_id != 0):?>
                <h3><?=$arResult["SECTION"][$section_id]["NAME"]?></h3>
            <?endif;?>
            <?foreach($arElements as $element):?>
                
                <div class="faq-tab">
                    <div class="faq-tab__info"><?=$element["FIELDS"]["NAME"]?></div>
                    <div class="faq-tab__content">
                        <?=$element["FIELDS"]["~DETAIL_TEXT"]?>
                    </div>
                </div>
            <?endforeach;?>
        <?endforeach;?>
    </div>

    <div class="faq-report">
        <h3>Не нашли ответа на свой вопрос?</h3>
        <h4>Задайте Ваш вопрос через сйат.</h4>
        <div class="faq-report__btn">
            <a class="link link-button report-link <?if (!$USER->IsAuthorized()){echo "unregister-support-popup";}?>" href="/support/?ID=0&edit=1">Задать вопрос</a>
        </div>
    </div>
</div>