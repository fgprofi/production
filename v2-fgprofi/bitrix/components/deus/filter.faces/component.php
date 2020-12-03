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



if(CModule::IncludeModule("iblock"))
{
	foreach ($arParams["PROPERTIES"] as $key => $face) {
		$res = CIBlock::GetProperties($face["IBLOCK_ID"], Array("SORT" => "ASC"), Array("CHECK_PERMISSIONS"=>"N"));
		while($res_arr = $res->Fetch()){
			if(in_array($res_arr["CODE"], $arParams["PROPERTIES"][$key]["PROP"])){
				$arResult["PROPS"][$face["NAME"]][$res_arr["CODE"]] = $res_arr;
			}
		}
	}
}
$this->IncludeComponentTemplate();