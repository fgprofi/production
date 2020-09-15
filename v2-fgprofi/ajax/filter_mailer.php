<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;


    if (CModule::IncludeModule("iblock")) {
        $arParams = array(
            "TYPE_F" => 7,
            "TYPE_U" => 8,
        );
        $arTypeText = array(
            7 => "физическое лицо",
            8 => "юр. лицо",
        );
        $sectUrl = array(
            7 => "fiz_faces",
            8 => "legal_faces",
        );
        $arParamsProp = array(
            "SIGN_OF_USER_DATA_DELETION" => array(
                7 => 3,
                8 => 4
            ),
            "PERSONAL_DATA" => array(
                7 => 2,
                8 => ""
            ),
            "VERIFICATION_PASSED_BY_MODERATOR" => array(
                7 => 4,
                8 => 10
            ),
        );
        $ib = $arParams[$arData["FACE"]];
        foreach ($_REQUEST as $key => $value) {
            if (stristr($key, 'REVERS_') !== FALSE) {
                $keyData = str_replace("REVERS_", "", $key);
                if (isset($arData[$keyData])) {
                    unset($arData[$key]);
                    unset($arData[$keyData]);
                }
            }
        }
        unset($arData["FACE"]);
        $arFilter = Array("IBLOCK_ID" => $ib);
        if (isset($arData["users_id"])) {
            $arUsersId = explode(",", $arData["users_id"]);
            $arFilter["ID"] = $arUsersId;
            unset($arData["users_id"]);
        }
        if (isset($arData["NAME"])) {
            $arFilter["NAME"] = $arData["NAME"];
            unset($arData["NAME"]);
        }
        if (isset($arData["REVERS_ACTIVE"]) && isset($arData["ACTIVE"])) {
            unset($arData["ACTIVE"]);
            unset($arData["REVERS_ACTIVE"]);
        } else {
            if (isset($arData["ACTIVE"])) {
                $arFilter["ACTIVE"] = $arData["ACTIVE"];
                unset($arData["ACTIVE"]);
            }
            if (isset($arData["REVERS_ACTIVE"])) {
                $arFilter["ACTIVE"] = $arData["REVERS_ACTIVE"];
                unset($arData["REVERS_ACTIVE"]);
            }
        }
        if (isset($arData["EMPTY_PROP"])) {
            $arPropEmpty["LOGIC"] = "AND";
            foreach ($arData["EMPTY_PROP"] as $propEmptyCode) {
                $arPropEmpty[] = array("PROPERTY_" . $propEmptyCode => false);
            }
            $arFilter[] = $arPropEmpty;
            unset($arData["EMPTY_PROP"]);
        }

        // echo "<pre>"; print_r($arData); echo "</pre>";
        // die();
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "ACTIVE");
//		if ( $ib == 7 ) {
        $arSelect[] = "PROPERTY_PHOTO";
        $arSelect[] = "PROPERTY_SURNAME";
        $arSelect[] = "PROPERTY_MIDDLENAME";
        $arSelect[] = "PROPERTY_FIRST_NAME";
        $arSelect[] = "PROPERTY_SIGN_OF_USER_DATA_DELETION";
        $arSelect[] = "PROPERTY_NAME_SUBDIVISION";
        
//		}
        if (isset($arData["SURNAME"]) && strripos($arData["SURNAME"], ",") !== false) {
            $arPropValExplode = explode(",", $arData["SURNAME"]);
            foreach ($arPropValExplode as $value) {
                $value = trim($value);
                if ($value != "") {
                    $arPropExp[] = array("PROPERTY_SURNAME" => $value . "%");
                }
            }
            if (count($arPropExp) > 1) {
                $arPropExp["LOGIC"] = "OR";
                $arFilter[] = $arPropExp;
                unset($arData["SURNAME"]);
            } else {
                trim($arData["SURNAME"], ",");
            }
        }
        if (isset($arData["FIRST_NAME"]) && strripos($arData["FIRST_NAME"], ",") !== false) {
            $arPropValExplode = explode(",", $arData["FIRST_NAME"]);
            foreach ($arPropValExplode as $value) {
                $value = trim($value);
                if ($value != "") {
                    $arPropExp[] = array("PROPERTY_FIRST_NAME" => $value . "%");
                }
            }
            if (count($arPropExp) > 1) {
                $arPropExp["LOGIC"] = "OR";
                $arFilter[] = $arPropExp;
                unset($arData["FIRST_NAME"]);
            } else {
                trim($arData["FIRST_NAME"], ",");
            }
        }
        $countItems = 100;
        if (isset($arData["countItems"])) {
            $countItems = $arData["countItems"];
            unset($arData["countItems"]);
        }
        $numPage = 1;
        if (isset($arData["numPage"])) {
            $numPage = $arData["numPage"];
            unset($arData["numPage"]);
        }
        if (isset($arData["PERSONAL_DATA"])) {
            if (count($arData["PERSONAL_DATA"]) <= 1) {
                if (in_array("0", $arData["PERSONAL_DATA"])) {
                    $arFilter["!PROPERTY_PERSONAL_DATA_VALUE"] = "Да";
                } else {
                    $arFilter["PROPERTY_PERSONAL_DATA_VALUE"] = "Да";
                }
            }
            unset($arData["PERSONAL_DATA"]);
        }
        if ($arData["LOCALITY"] != "") {
            $arFilter["PROPERTY_LOCALITY"] = "%" . $arData["LOCALITY"] . "%";
            unset($arData["LOCALITY"]);
        }
//		$arFilter["PROPERTY_SIGN_OF_USER_DATA_DELETION"] = false;
        foreach ($arData as $propName => $propValue) {
            if (is_array($propValue)) {
                if (count($propValue) > 1) {
                    $firstFiltProp = $propValue[0];
                    unset($propValue[0]);
                    $propValue = array_keys($propValue);
                    $propValue[] = $firstFiltProp;
                    $arPropFilt["LOGIC"] = "OR";
                    foreach ($propValue as $valueId) {
                        $arPropFilt[] = array($propName => $valueId);
                    }
                    $arFilter[] = $arPropFilt;
                } else {
                    $arFilter[$propName] = $propValue[0];
                }
            } else {
                if ($propValue != "false" && $propValue != false) {
                    if (stristr($propName, 'REVERS_') !== FALSE) {
                        $propName = str_replace("REVERS_", "", $propName);
                        $propName = str_replace("PROPERTY_", "", $propName);
                        if ($arParamsProp[$propName]) {
                            $propValue = $arParamsProp[$propName][$ib];
                        }
                        if ($propValue != "") {
                            $arFilter["!PROPERTY_" . $propName] = $propValue;
                        }
                    } else {
                        $propName = str_replace("PROPERTY_", "", $propName);
                        if ($propValue != "" && $propValue != "0") {
                            if ($propName == "SURNAME" || $propName == "FIRST_NAME") {
                                if ($propValue != "") {
                                    $arFilter["PROPERTY_" . $propName] = $propValue . "%";
                                }
                            } else {
                                if ($arParamsProp[$propName]) {
                                    $propValue = $arParamsProp[$propName][$ib];
                                }
                                if ($propValue != "") {
                                    $arFilter["PROPERTY_" . $propName] = $propValue;
                                }
                            }
                        }
                        if ($propValue == 0 && $propName == 'PERSONAL_DATA') {
                            $arFilter["!PROPERTY_" . $propName] = 2;
                        }
                    }
                }
            }
        }
        // print_r($arFilter);
        // die();
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(
            "nPageSize" => $countItems,
            "iNumPage" => $numPage
        ), $arSelect);
        $i = 0;
        $all = $res->NavRecordCount;
        $arFilterAll = Array("IBLOCK_ID"=>$arFilter["IBLOCK_ID"]);
        $res_all = CIBlockElement::GetList(Array(), $arFilterAll, Array(), false, Array());

        
        $str = '<div class="res" data-count-res="'.$all.'" data-count-all="'.$res_all.'">';
        
        $next = $all - $countItems * $numPage;
        if ($next > $countItems) {
            $next = $countItems;
        }
        if ($next <= 0) {
            $next = 0;
        }
        while ($ob = $res->Fetch()) {
            $i++;
            $filePhoto["src"] = "";
            $surName = "";
            $middleName = "";
            $firstName = "";
            if ($ob["PROPERTY_PHOTO_VALUE"] != "") {
                $filePhoto = CFile::ResizeImageGet($ob["PROPERTY_PHOTO_VALUE"], array('width' => 64,
                    'height' => 64
                ), BX_RESIZE_IMAGE_EXACT, true);
            }
            if ($ob["PROPERTY_SURNAME_VALUE"] != "") {
                $surName = $ob["PROPERTY_SURNAME_VALUE"];
            }
            if ($ob["PROPERTY_MIDDLENAME_VALUE"] != "") {
                $middleName = $ob["PROPERTY_MIDDLENAME_VALUE"];
            }
            if ($ob["PROPERTY_FIRST_NAME_VALUE"] != "") {
                $firstName = $ob["PROPERTY_FIRST_NAME_VALUE"];
            }
            $iconName = "ЮЛ";
            $fullName = $surName . ' ' . $firstName . ' ' . $middleName;
            if ($ib == 7) {
                $iconName = mb_strtoupper(mb_substr($surName, 0, 1)) . mb_strtoupper(mb_substr($firstName, 0, 1));
            }
            if ($ib == 8 && $ob["PROPERTY_NAME_SUBDIVISION_VALUE"] != "") {
                $fullName = $fullName."<br><span>Подразделение: <span class='subdivision_name'>".$ob["PROPERTY_NAME_SUBDIVISION_VALUE"]."</span></span>";
            }
            $checked = "";
            if ($ob["ACTIVE"] == "Y") {
                $checked = "checked='checked'";
            }
            $delTrash = "";
            $delTrashChecked = "";
            if ($ob["PROPERTY_SIGN_OF_USER_DATA_DELETION_VALUE"] != "") {
                $delTrash = " blue_trash";
                $delTrashChecked = " checked='checked'";
            }
//			echo "<pre>"; print_r($ob); echo "</pre>";
            $str .= '<div class="filter__item" data-item-id="' . $ob["ID"] . '">
                    <div class="filter__left">
                        <label class="filter__label">
                            <input class="filter__input" type="checkbox" name="select[]" value="' . $ob["ID"] . '">
                            <span class="filter__check"></span>
                        </label>
                    </div>
                    <a class="filter__middle" href="/personal/' . $sectUrl[$ib] . '/' . $ob["ID"] . '/">
                        <div class="filter__profile profile-filter">
                            <div class="profile-filter__image">
                                <div class="header-login__img-wrap">
                                    <img class="header-login__img" src="' . $filePhoto["src"] . '">
                                    <span class="header-login__initials">' . $iconName . '</span>
                                </div>
                            </div>
                            <div class="profile-filter__info">
                                <p class="profile-filter__name">' . $fullName . '</p>
                                <p class="profile-filter__identifier">
                                    <span class="profile-filter__id">ID: ' . $ob["ID"] . ' | </span>
                                    <span class="profile-filter__status">' . $arTypeText[$ib] . '</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="filter__right" data-id="' . $ob["ID"] . '">
						<a class="link link-button link-button--disabled">Написать</a>
                    </div>
                </div>';
        }
        $str .= '<div class="NavRecordCount">' . $next . '</div></div>';
        if ($i <= 0) {
            $str = "Нет результата";
        }
        echo $str;
        // echo "<pre>"; print_r($arResult); echo "</pre>";
        // echo "<pre>"; print_r($arFilter); echo "</pre>";
    }
}
?>
<? /*<?
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = Array("IBLOCK_ID"=>7, "PROPERTY_PERSONAL_DATA_VALUE"=>"Да");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>100), $arSelect);
        while($ob = $res->GetNextElement()){ 
            $arItems["FIELDS"] = $ob->GetFields();
            $arItems["PROPS"] = $ob->GetProperties();
            $arResult["ITEMS"][] = $arItems;
        }
        //echo "<pre>"; print_r($arResult["ITEMS"]); echo "</pre>";
        ?>
        <div class="filter__body">
            <?foreach($arResult["ITEMS"] as $item):?>
                <?$surName = "";
                $middleName = "";
                if($item["PROPS"]["SURNAME"]["VALUE"] != ""){
                    $surName = $item["PROPS"]["SURNAME"]["VALUE"];
                }
                if($item["PROPS"]["MIDDLENAME"]["VALUE"] != ""){
                    $middleName = $item["PROPS"]["MIDDLENAME"]["VALUE"];
                }
                $filePhoto["src"] = "";
                if($item["PROPS"]["PHOTO"]["VALUE"] != ""){
                    $filePhoto = CFile::ResizeImageGet($item["PROPS"]["PHOTO"]["VALUE"], array('width'=>64, 'height'=>64), BX_RESIZE_IMAGE_EXACT, true);
                }
                
                ?>
                <div class="filter__item">
                    <div class="filter__left">
                        <label class="filter__label">
                            <input class="filter__input" type="checkbox">
                            <span class="filter__check"></span>
                        </label>
                    </div>
                    <a class="filter__middle" href="/personal/fiz_faces/<?=$item["FIELDS"]["ID"]?>/">
                        <div class="filter__profile profile-filter">
                            <div class="profile-filter__image">
                                <div class="header-login__img-wrap">
                                    <img class="header-login__img" src="<?=$filePhoto["src"]?>">
                                    <span class="header-login__initials"><?=mb_strtoupper(mb_substr($surName, 0, 1))?><?=mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1))?></span>
                                </div>
                            </div>
                            <div class="profile-filter__info">
                                <p class="profile-filter__name"><?=$surName?> <?if($middleName != ""){echo mb_strtoupper(mb_substr($middleName, 0, 1)).".";}?><?=mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1))?>.</p>
                                <p class="profile-filter__identifier">
                                    <span class="profile-filter__id">ID: <?=$item["FIELDS"]["ID"]?> | </span>
                                    <span class="profile-filter__status">физическое лицо</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="filter__right">
                        <label class="filter__label label-filter label-filter_lock">
                            <input class="filter__input" type="checkbox">
                            <span class="label-filter__icon"></span>
                        </label>
                        <label class="filter__label label-filter label-filter_trash"></label>
                        <label class="filter__label label-filter label-filter_changes"></label>
                    </div>
                </div>
            <?endforeach;?>
        </div>*/ ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>