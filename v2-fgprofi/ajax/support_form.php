<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//$arThemes = getSupportThemes();

if (isset($_REQUEST)) {
    $arData = $_REQUEST;
    $arDataParamsProp = array(
        "TYPE_F" => array(
            "IBLOCK_ID" => 7,
        ),
        "TYPE_U" => array(
            "IBLOCK_ID" => 8,
        ),
    );
} ?>
<div id="support-message" class="support-message">
    <div class="popup__title">Новое сообщение</div>
    <?$arThemes = getSupportThemes();?>
    <div class="popup__content">
        <form action="#" class="popup__form popup__form--developer">
            
            
            
            <div class="input__group input__group--required"><input type="text" class="popup__theme input__search input__search--border" name="name" placeholder="Ф.И.О:"></div>
            <div class="input__group input__group--required"><input type="text" class="popup__theme input__search input__search--border" name="email" placeholder="Email"></div>
            <div class="input__group"><input type="text" class="popup__theme input__search input__search--border phone_mask" name="phone" placeholder="Телефон"></div>
            <div class="input__group input__group--required input__group--w-label">
                <label for="developer-heading" class="input__group-label">Заголовок:</label>
                <input id="developer-heading" type="text" class="popup__theme input__search" name="theme" placeholder="введите текст">
            </div>

            <? //echo "<pre>"; print_r($arThemes); echo "</pre>";
            ?>
            <div class="input__group input__group--required newsletter__form-group">
                <div class="rubricator-select rubricator-select--overflow">
                    <div class="rubricator-items" style="display: none;">
                        <? foreach ($arThemes as $theme) : ?>
                            <div data-value="<?= $theme["UF_CODE"] ?>" class="rubricator-items__option"><?= $theme["UF_NAME_THEME"] ?></div>
                        <? endforeach; ?>
                    </div>
                    <div class="rubricator-title">Выберите тему письма</div>
                    <input type="hidden" class="rubricator-input" name="list" value="">
                </div>
            </div>
            <div class="input__group input__group--required input__group--w-title">
                <div class="input__group-title">Сообщение</div>
                <textarea class="popup__textarea" name="text_mail" placeholder="Введите текст сообщения"></textarea>
            </div>

            <div class="popup__form-btns">
                <button class="link link-button report-link" type="submit">Отправить</button>
                <button class="link link-button link-button--cansel">Сбросить<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                        <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                    </svg></button>
            </div>
        </form>
    </div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>