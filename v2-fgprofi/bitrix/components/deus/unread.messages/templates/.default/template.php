<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<?//echo "<pre>"; print_r($arResult["MESSAGE"]); echo "</pre>";?>
<div class="notification">
    <div class="notification__title">Уведомления</div>
    <div class="notification__content">
        <?if(isset($arResult["MESSAGE"])):?>
            <?foreach($arResult["MESSAGE"] as $mess):?>
                <div class="notification__item notification__item_<?=strtolower($mess["TYPE"])?>">
                    <div class="notification__item-close" data-mess-type="<?=strtolower($mess["TYPE"])?>" data-item-mess-id="<?=$mess["ID"]?>"></div>
                    <?if($mess["TYPE"] == "TICKET"):?>
                        <a href="/support/?ID=<?=$mess["ID"]?>&edit=1">
                    <?elseif($mess["TYPE"] == "USER_BY_USER"):?>
                        <a href="#" onClick="function(e){return false;}">
                    <?else:?>
                        <a href="#" onClick="function(e){return false;}">
                    <?endif;?>
                        <div class="notification__item-image">
                            <?if(isset($mess["USER_INFO"]["PHOTO"]["src"]) && $mess["USER_INFO"]["PHOTO"]["src"] != ""):?>
                                <img class="img" src="<?=$mess["USER_INFO"]["PHOTO"]["src"]?>" alt="">
                            <?else:?>
                                <div class="notification__item-initials"><?=$mess["USER_INFO"]["ICON_NAME"]?></div>
                            <?endif;?>
                        </div>
                        
                        <div class="notification__item-text">
                            <div class="notification__item-name"><?=$mess["MESS_TITLE"]?></div>
                            <div class="notification__item-descr"><?=$mess["MESS"]?></div>
                        </div>
                    </a>
                </div>
            <?endforeach;?>
        <?endif;?>
        <?/*<div class="notification__item">
            <div class="notification__item-close"></div>
            <div class="notification__item-image">
                <img class="img" src="/bitrix/templates/pakk/img/avatar.svg" alt="">
            </div>
            <div class="notification__item-text">
                <div class="notification__item-name">Модератор</div>
                <div class="notification__item-descr">Excepteur anim officia do velit do in labore mollit dolor elit sit. Occaecat officia cillum non ex, anim officia do velit do in labore mollit dolor elit...</div>
            </div>
        </div>*/?>
    </div>
</div>