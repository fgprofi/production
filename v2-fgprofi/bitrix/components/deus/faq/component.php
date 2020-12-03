<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponent $this
 */

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)
	die();

global $USER;
if(CModule::IncludeModule("iblock"))
{
	$SectList = CIBlockSection::GetList(
		array(), 
		array("IBLOCK_ID"=>IntVal($arParams["IBLOCK_ID"]),"ACTIVE"=>"Y","ACTIVE_DATE"=>"Y"),
		false, 
		array("ID","IBLOCK_ID","IBLOCK_TYPE_ID","IBLOCK_SECTION_ID","CODE","SECTION_ID","NAME","SECTION_PAGE_URL")
	);
    while ($SectListGet = $SectList->GetNext())
    {
        $arResult["SECTION"][$SectListGet["ID"]]=$SectListGet;
    }

	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "DATE_ACTIVE_FROM", "IBLOCK_SECTION_ID");
	$arFilter = Array("IBLOCK_ID"=>IntVal($arParams["IBLOCK_ID"]), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arElement["PROP"] = $ob->GetProperties();
		$arElement["FIELDS"] = $ob->GetFields();
		// if (!$USER->IsAuthorized() && $arElement["PROP"]["REGISTER_USER_ONLY"]["VALUE"] != ""){
		// 	continue;
		// }
		$section_id = 0;
		if($arElement["FIELDS"]["IBLOCK_SECTION_ID"] != ""){
			$section_id = $arElement["FIELDS"]["IBLOCK_SECTION_ID"];
		}
		$arResult["ITEMS"][$section_id][] = $arElement;
	}
	if ($USER->IsAuthorized()){
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "DATE_ACTIVE_FROM", "IBLOCK_SECTION_ID","PROPERTY_SECTION_LINK");
		$arFilter = Array("IBLOCK_ID"=>IntVal($arParams["REGISTER_IBLOCK_ID"]), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arElement["PROP"] = $ob->GetProperties();
			$arElement["FIELDS"] = $ob->GetFields();
			// if (!$USER->IsAuthorized() && $arElement["PROP"]["REGISTER_USER_ONLY"]["VALUE"] != ""){
			// 	continue;
			// }
			$section_id = 0;
			if($arElement["PROP"]["SECTION_LINK"]["VALUE"] != ""){
				$section_id = $arElement["PROP"]["SECTION_LINK"]["VALUE"];
			}
			$arResult["ITEMS"][$section_id][] = $arElement;
		}
	}
}
$this->IncludeComponentTemplate();