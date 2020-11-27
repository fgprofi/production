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

//echo"<pre>";
//print_r($arResult['ITEMS'][0]);
//echo"</pre>";
//die();
foreach ($arResult['ITEMS'] as $item) {
    $key = FormatDate("d F", MakeTimeStamp($item["DATE_ACTIVE_TO"]));
    $arResult['ITEMS_F'][$key][] = $item;
}
// echo"<pre>";
// print_r($arResult);
// echo"</pre>";
?>
<div class="newsletter__content">
    <div class="newsletter__date">
        <div class="newsletter__date-header">03 апреля</div>
        <a href="/admin/newsletter/write" class="newsletter__item">
            <div class="newsletter__img"></div>
            <div class="newsletter-text">
                <div class="newsletter__name">Короновирус</div>
                <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
            </div>
        </a>

        <a href="/admin/newsletter/write" class="newsletter__item">
            <div class="newsletter__img"></div>
            <div class="newsletter-text">
                <div class="newsletter__name">Короновирус</div>
                <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
            </div>
        </a>
    </div>

    <div class="newsletter__date">
        <div class="newsletter__date-header">03 апреля</div>
        <a href="/admin/newsletter/write" class="newsletter__item">
            <div class="newsletter__img"></div>
            <div class="newsletter-text">
                <div class="newsletter__name">Короновирус</div>
                <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
            </div>
        </a>
    </div>

    <div class="newsletter__date">
        <div class="newsletter__date-header">03 апреля</div>
        <a href="/admin/newsletter/write" class="newsletter__item">
            <div class="newsletter__img"></div>
            <div class="newsletter-text">
                <div class="newsletter__name">Короновирус</div>
                <div class="newsletter__subtitle">№029 | Опрос | Физические лица</div>
                <div class="newsletter__descr">Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.  Et consectetur et fugiat amet. Enim ut incididunt aute commodo in pariatur id ipsum.</div>
            </div>
        </a>
    </div>
</div>