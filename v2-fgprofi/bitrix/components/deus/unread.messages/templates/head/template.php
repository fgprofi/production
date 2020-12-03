<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="header-notification">
    <div class="header-notification__icon">
        <? if (isset($arResult["MESSAGE"])) : ?>
            <span class="header-notification__amount"><?=count($arResult["MESSAGE"]);?></span>
        <?endif;?>
    </div>
    <div class="header-notification__content">
        <div class="header-notification__title">Уведомления
            <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg>
        </div>
        <? if (isset($arResult["MESSAGE"])) : ?>
            <? foreach ($arResult["MESSAGE"] as $mess) : ?>
                <a href="/support/message/" class="header-notification__item">
                    <?if(isset($mess["USER_INFO"]["PHOTO"]["src"]) && $mess["USER_INFO"]["PHOTO"]["src"] != ""):?>
                        <img class="img" src="<?=$mess["USER_INFO"]["PHOTO"]["src"]?>" alt="">
                    <?else:?>
                        <div class="notification__item-initials"><?=$mess["USER_INFO"]["ICON_NAME"]?></div>
                    <?endif;?>
                    <div class="header-notification__item-text"><?=$mess["MESS_TITLE"]?></div>
                </a>
            <? endforeach; ?>
        <? endif; ?>
    </div>
</div>