<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
$res_ib = CIBlock::GetByID($arResult["IBLOCK_ID"]);
if ($ar_ib = $res_ib->GetNext()) {
    $arResult["IB_INFO"] = $ar_ib;
}
global $USER;

if (isset($arResult["PROPERTIES"]["PHOTO"]["VALUE"]) && $arResult["PROPERTIES"]["PHOTO"]["VALUE"] != "") {
    $filePhoto = CFile::ResizeImageGet($arResult["PROPERTIES"]["PHOTO"]["VALUE"], array(
        'width' => 64,
        'height' => 64
    ), BX_RESIZE_IMAGE_EXACT, true);
}
//echo "<pre>"; print_r($filePhoto); echo "</pre>";
$surName = $arResult["PROPERTIES"]['SURNAME']['VALUE'];
$firstName = $arResult["PROPERTIES"]['FIRST_NAME']['VALUE'];
$email = $arResult["PROPERTIES"]['EMAIL']['VALUE'];
$iconName = mb_strtoupper(mb_substr($surName, 0, 1)) . mb_strtoupper(mb_substr($firstName, 0, 1));
$fullName = $firstName . ' ' . $surName;
if ($USER->IsAdmin()) {
    $fullName = "Администратор";
    $iconName = "A";
}
?>
<div id="write-message" class="write-message">
    <div class="popup__title">Новое сообщение</div>
    <div class="popup__content">
        <div class="popup__person">

            <div class="popup__img-wrap">
                <img src="<?=$filePhoto["src"]?>"  class="popup__img">
            </div>
            <div class="popup__text">
                <div class="popup__name"><?=$arResult["NAME"]?></div>
                <div class="popup__id-wrap">
                    <span class="popup__id">ID: <?=$arResult["ID"]?> | </span>
                    <span class="popup__status"><?=$arResult["IB_INFO"]["NAME"]?></span>
                </div>
            </div>
        </div>
        <form action="#" class="popup__form" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?=$arResult["ID"]?>">
            <input type="hidden" name="ib_id" value="<?=$arResult["IBLOCK_ID"]?>">
            <input type="text" class="popup__theme input__search" name="theme" placeholder="Тема письма">
            <textarea class="popup__textarea" name="text_mail" placeholder="Введите текст сообщения"></textarea>
            <div class="popup__form-btns">
                <?
                /*$APPLICATION->IncludeComponent( "bitrix:main.file.input", "",
                    array(
                        "INPUT_NAME"       => "FILE_UPLOAD",
                        "MULTIPLE"         => "N",
                        "MODULE_ID"        => "iblock",
                        "MAX_FILE_SIZE"    => 300000,
                        "ALLOW_UPLOAD"     => "F",
                        "ALLOW_UPLOAD_EXT" => "",
                    ),
                    false
                ); */?>
                <?echo CFile::InputFile("file-download", 20, "", false, 300000);?>
                <button class="link link-button report-link" type="submit">Отправить</button>
            </div>
        </form>
    </div>
</div>