<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?global $APPLICATION;
$dir = $APPLICATION->GetCurDir();?>
<?//echo "<pre>"; print_r($_SERVER['DOCUMENT_ROOT'].$dir.$arParams["MENU_INCLUDE_FILE"]); echo "</pre>";?>
<div class="sidebar sidebar_sticky_big-indent">
    <?include($_SERVER['DOCUMENT_ROOT'].$dir.$arParams["MENU_INCLUDE_FILE"]);?>
    <div class="sidebar-wrap sidebar--nav">
        <ul class="sidebar__nav">
        	<?foreach($arResult as $arItem):?>
        		<?if($arItem["SELECTED"]):?>
		            <a class="sidebar__nav-link active" href="<?=$arItem["LINK"]?>">
		                <li class="sidebar__nav-item"><?=$arItem["TEXT"]?></li>
		            </a>
	            <?else:?>
					<a class="sidebar__nav-link" href="<?=$arItem["LINK"]?>">
		                <li class="sidebar__nav-item"><?=$arItem["TEXT"]?></li>
		            </a>
				<?endif?>
			<?endforeach?>
        </ul>
    </div>
</div>
<?endif?>