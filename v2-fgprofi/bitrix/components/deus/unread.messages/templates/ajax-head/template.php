<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if(isset($arResult["MESSAGE"])):?>
    <?foreach($arResult["MESSAGE"] as $mess):?>
        <a href="/support/message/" class="header-notification__item">
            <?/*<img src="/bitrix/templates/pakk/img/avatar.svg" class="header-notification__item-img">*/?>
            <?if(isset($mess["USER_INFO"]["PHOTO"]["src"]) && $mess["USER_INFO"]["PHOTO"]["src"] != ""):?>
                <img class="img" src="<?=$mess["USER_INFO"]["PHOTO"]["src"]?>" alt="">
            <?else:?>
                <div class="notification__item-initials"><?=$mess["USER_INFO"]["ICON_NAME"]?></div>
            <?endif;?>
            <div class="header-notification__item-text"><?=$mess["MESS_TITLE"]?></div>
        </a>
    <?endforeach;?>
<?endif;?>