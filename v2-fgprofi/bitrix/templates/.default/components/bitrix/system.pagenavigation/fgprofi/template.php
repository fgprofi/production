<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
*/

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
/*                
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">1</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">2</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">3</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">4</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">...</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">149</a>
                        </li>
                        <li class="pagination__item active">
                            <a class="pagination__link" href="#">150</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">151</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">...</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">335</a>
                        </li>
                        <li class="pagination__item">
                            <a class="pagination__link" href="#">336</a>
                        </li>*/

?>
<?if($arResult["NavPageCount"] > 1):?>
	<div class="pagination">
	    <ul class="pagination__list">
			<?
			if($arResult["bDescPageNumbering"] === true):
				$bFirst = true;
				if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
					if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
						$bFirst = false;
						if($arResult["bSavePage"]):
			?>
						<li class="pagination__item">
			                <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
			            </li>
			<?
						else:
			?>
						<li class="pagination__item">
			                <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
			            </li>
			<?
						endif;
						if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
			?>
							<li class="pagination__item">
								<a class="pagination__link" href="#">...</a>
							</li>
			<?
						endif;
					endif;
				endif;
				do
				{
					$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
					
					if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
			?>
					<li class="pagination__item active">
			            <a class="pagination__link" href="#"><?=$NavRecordGroupPrint?></a>
			        </li>
			<?
					elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
			?>
					<li class="pagination__item active">
			            <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
			        </li>
			<?
					else:
			?>
					<li class="pagination__item active">
			            <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
			        </li>

			<?
					endif;
					
					$arResult["nStartPage"]--;
					$bFirst = false;
				} while($arResult["nStartPage"] >= $arResult["nEndPage"]);
				
				if ($arResult["NavPageNomer"] > 1):
					if ($arResult["nEndPage"] > 1):
						if ($arResult["nEndPage"] > 2):
			?>
							<li class="pagination__item">
							    <a class="pagination__link" href="#">...</a>
							</li>
			<?
						endif;
			?>
					<li class="pagination__item">
					    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
					</li>
			<?
					endif;
				endif; 

			else:
				$bFirst = true;

				if ($arResult["NavPageNomer"] > 1):
					if ($arResult["nStartPage"] > 1):
						$bFirst = false;
						if($arResult["bSavePage"]):
			?>
						<li class="pagination__item">
						    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
						</li>
			<?
						else:
			?>
						<li class="pagination__item">
						    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
						</li>
			<?
						endif;
						if ($arResult["nStartPage"] > 2):
			?>
							<li class="pagination__item">
							    <a class="pagination__link" href="#">...</a>
							</li>
			<?
						endif;
					endif;
				endif;

				do
				{
					if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
			?>
					<li class="pagination__item active">
			            <a class="pagination__link" href="#"><?=$arResult["nStartPage"]?></a>
			        </li>
			<?
					elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
			?>
					<li class="pagination__item">
					    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
					</li>
			<?
					else:
			?>
					<li class="pagination__item">
					    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
					</li>
			<?
					endif;
					$arResult["nStartPage"]++;
					$bFirst = false;
				} while($arResult["nStartPage"] <= $arResult["nEndPage"]);
				
				if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
					if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
						if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
			?>
							<li class="pagination__item">
							    <a class="pagination__link" href="#">...</a>
							</li>
			<?
						endif;
			?>
					<li class="pagination__item">
					    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
					</li>
			<?
					endif;
				endif;
			endif;
			?>
		</ul>
	</div>
<?endif;?>