<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">

<head>
    <!--[if lte IE 11]>
    <script src="http://phpbbex.com/oldies/oldies.js" charset="utf-8"></script><![endif]-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta charset="utf-8">
    <meta name="yandex-verification" content="17f5435fbacc410e" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="yandex-verification" content="17f5435fbacc410e" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;display=swap&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond:400,500,600,700&amp;display=swap&amp;subset=cyrillic" rel="stylesheet">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery-3.3.1.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.browser.min.js"); ?>
    <? // $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.multi-select.js"); 
    ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/multiple-select.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.maskedinput.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.inputmask.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/select2/js/select2.full.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.fancybox.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.pwdMeter.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.timepicker.min.js"); ?>

    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/custom.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/main.js"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/js/jquery-ui-1.12.1.custom/jquery-ui.css"); ?>
    
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/reset.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/multiple-select.min.css", true); ?>
    <? //$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/js/jquery-ui-1.12.1.custom/jquery-ui.min.css", true);
    ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/plugins.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/main.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/main.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/select2.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.fancybox.min.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/media.css", true); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.timepicker.min.css", true); ?>
    <? //$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/style.css", true);
    ?>
    <? $APPLICATION->ShowHead(); ?>
    <? global $USER; ?>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</head>
<?
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

$ua = getBrowser();
$yourbrowser = "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] . " reports: <br >" . $ua['userAgent'];
//echo "<pre>"; print_r($yourbrowser); echo "</pre>";
/*$browserInfo = getInfoBrowser();
echo "<pre>"; print_r($_SERVER['HTTP_USER_AGENT']); echo "</pre>";
echo "<pre>"; print_r($browserInfo); echo "</pre>";
*/
$oldBrowserClass = "";
function detectOldBrowser($yourbrowser)
{
    $yourbrowser['version'] = explode(".", $yourbrowser['version']);
    $res = false;
    if ($yourbrowser['name'] == "Google Chrome" && (int) $yourbrowser['version'][0] < 75) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Internet Explorer" && (int) $yourbrowser['version'][0] < 11) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Mozilla Firefox" && (int) $yourbrowser['version'][0] < 68) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Apple Safari" && (int) $yourbrowser['version'][0] < 8) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Opera" && (int) $yourbrowser['version'][0] < 61) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Netscape" && (int) $yourbrowser['version'][0] < 4) {
        $res = true;
    }
    if ($yourbrowser['name'] == "Unknown") {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false) {
            //echo "<pre>"; print_r($_SERVER['HTTP_USER_AGENT']); echo "</pre>";
            $res = true;
        }
    }
    //echo "<pre>"; print_r($yourbrowser['name']." ".$yourbrowser['version'][0]); echo "</pre>";
    return $res;
}

if (detectOldBrowser($ua)) : ?>
    <? $oldBrowserClass = ' class="old_browser"'; ?>
    <script>
        $(document).ready(function() {
            $(".modern-version").show();
            $('body').addClass('overflow')
        });
    </script>
<? endif; ?>
<? if ($USER->getID() == 1) { ?>
    <div id="panel"><? $APPLICATION->ShowPanel(); ?></div><?
                                                        } ?>

<body>
    <div id="root" style="width: 100%; min-height: 100vh">
        <div role="group" style="outline: none;" tabindex="-1">

            <div class="wrapper">

                <div role="group" style="outline: none;" tabindex="-1" <?= $oldBrowserClass ?>>
                    <header class="header">
                        <div class="modern-version">
                            <div class="containered">
                                <div class="modern-version__attention">
                                    <img src="/bitrix/templates/pakk/img/popup-download_version/warning.png" alt="Внимание!" class="modern-version__attention-img">
                                    <p class="modern-version__text">Для корректной работы сайта, пожалуйста скачайте
                                        современную версию браузера </p>
                                </div>
                                <div class="modern-version__browser">
                                    <img class="modern-version__browser-img" src="/bitrix/templates/pakk/img/popup-download_version/chrome.png">
                                    <a href="https://www.google.ru/chrome/" class="modern-version__link">Скачать</a>
                                </div>
                                <div class="modern-version__browser">
                                    <img class="modern-version__browser-img" src="/bitrix/templates/pakk/img/popup-download_version/ie.png">
                                    <a href="https://www.microsoft.com/en-us/edge" class="modern-version__link">Скачать</a>
                                </div>
                                <div class="modern-version__browser">
                                    <img class="modern-version__browser-img" src="/bitrix/templates/pakk/img/popup-download_version/opera.png">
                                    <a href="https://www.opera.com/ru" class="modern-version__link">Скачать</a>
                                </div>
                                <div class="modern-version__close"></div>
                            </div>
                        </div>
                        <div class="containered">
                            <div class="header-block" style="opacity: 1;">
                                <? if ($APPLICATION->GetCurPage(false) === '/') : ?>
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/logo_f.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    ); ?>
                                <? else : ?>
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/logo.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    ); ?>
                                <? endif; ?>


                                <div class="header-search">
                                    <div class="header-search__btn"></div>


                                </div>

                                <div class="header-email-phone flex hidden-mobile">

                                    <div class="header-email <?if (!$USER->IsAuthorized()){echo "unregister-support-popup";}?>">
                                        <div class="header-email__img"></div>
                                        <a href="/support/?ID=0&edit=1">Написать разработчику</a>
                                        <?/* $APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            array(
                                                "AREA_FILE_SHOW" => "file",
                                                "PATH" => "/include/mail.php",
                                                "EDIT_TEMPLATE" => ""
                                            )
                                        ); */?>
                                    </div>
                                </div>

                                <? global $USER;
                                if (!$USER->IsAuthorized()) : ?>
                                    <div class="header-login">
                                        <a href="/auth/">
                                            <div class="header-login__img"></div>
                                        </a><a class="header-login__text" href="/auth/">Личный кабинет</a>
                                    </div>
                                <? else : ?>

                                    <? $arDataParamsProp = array(
                                        "TYPE_F" => array(
                                            "IBLOCK_ID" => 7,
                                        ),
                                        "TYPE_U" => array(
                                            "IBLOCK_ID" => 8,
                                        ),
                                    );
                                    $rsUser = CUser::GetList(($by = "ID"), ($order = "desc"), array("ID" => $USER->getID()), array("SELECT" => array("UF_*")));
                                    $arDataUserFields = $rsUser->Fetch();
                                    foreach ($arDataParamsProp as $face => $params) {
                                        if ($arDataUserFields["UF_USER_INFO_" . $face] != "") {
                                            $arUserFields = $params;

                                            break;
                                        }
                                    }
                                    if (CModule::IncludeModule("iblock")) {
                                        $fullName = "";
                                        $filePhoto["src"] = "";
                                        $arSelect = array(
                                            "ID",
                                            "IBLOCK_ID",
                                            "NAME",
                                            "DATE_ACTIVE_FROM",
                                            "PROPERTY_*"
                                        );
                                        $arFilter = array(
                                            "IBLOCK_ID" => $params["IBLOCK_ID"],
                                            "ID" => $arDataUserFields["UF_USER_INFO_" . $face]
                                        );
                                        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                                        if ($ob = $res->GetNextElement()) {
                                            $arUserFields["FIELDS"] = $ob->GetFields();
                                            $arUserFields["PROPS"] = $ob->GetProperties();
                                        }
                                        if (isset($arUserFields["PROPS"]["PHOTO"]["VALUE"]) && $arUserFields["PROPS"]["PHOTO"]["VALUE"] != "") {
                                            $filePhoto = CFile::ResizeImageGet($arUserFields["PROPS"]["PHOTO"]["VALUE"], array(
                                                'width' => 64,
                                                'height' => 64
                                            ), BX_RESIZE_IMAGE_EXACT, true);
                                        }

                                        $surName = $arUserFields["PROPS"]['SURNAME']['VALUE'];
                                        $firstName = $arUserFields["PROPS"]['FIRST_NAME']['VALUE'];
                                        $email = $arUserFields["PROPS"]['EMAIL']['VALUE'];
                                        $iconName = mb_strtoupper(mb_substr($surName, 0, 1)) . mb_strtoupper(mb_substr($firstName, 0, 1));
                                        $fullName = $firstName . ' ' . $surName;
                                        if ($USER->GetID() == 1) {
                                            $fullName = "Администратор";
                                            $iconName = "A";
                                        }
                                        (isAdministrator()) ? $loader = 'loader' : $loader = '';
                                    ?>
                                        <? if (isset($arUserFields["PROPS"]['PHONE']['VALUE']) && $arUserFields["PROPS"]['PHONE']['VALUE'] != '') : ?>
                                            <div class="header-hidden-phone" style="display: none"><?= $arUserFields["PROPS"]['PHONE']['VALUE']; ?></div>
                                        <? endif; ?>
                                        <div class="header-login authorized">
                                            <?
                                            $APPLICATION->IncludeComponent("deus:unread.messages", "head", Array(
                                                "TITLE_TYPE_MESS" => array(
                                                    "TICKET" => "Техническая поддержка",
                                                    "MAILING" => "Рассылка",
                                                ),
                                            ));
                                            ?>
                                            <a class="show-header-min-box" href="/personal/">
                                                <div class="header-login__img-wrap">
                                                    <img class="header-login__img" src="<?= $filePhoto["src"] ?>" width="100%">
                                                    <span class="header-login__initials"><?= $iconName ?></span>
                                                </div>
                                            </a>
                                            <?
                                            $statusClass = " authorized";
                                            if ($arUserFields["PROPS"]["VERIFICATION_PASSED_BY_MODERATOR"]["VALUE"] == "") {
                                                $statusClass = "";
                                            } ?>
                                            <div class="header-login__drop drop-login <?= $statusClass ?>">
                                                <div class="drop-login__info">
                                                    <div class="sign_in_new">
                                                        <p class="drop-login__name <?= $loader ?>"><a href="/personal/"><?= $fullName ?></a></p>
                                                    </div>
                                                    <? if ($arUserFields["PROPS"]["VERIFICATION_PASSED_BY_MODERATOR"]["VALUE"] != "" && !$ad_mod) : ?>
                                                        <p class="drop-login__note">проверяется модератором</p>
                                                    <? endif; ?>
                                                    <?/* if ($arUserFields["PROPS"]["EMAIL"]["VALUE"] != "") : ?>
                                                <a class="drop-login__email"
                                                   href="mailto:<?= $arUserFields["PROPS"]["EMAIL"]["VALUE"] ?>"><?= $arUserFields["PROPS"]["EMAIL"]["VALUE"] ?></a>
                                            <? endif; */ ?>
                                                </div>
                                                <div class="drop-login__menu">
                                                    <ul class="drop-login__menu-list">
                                                        <li class="drop-login__menu-item drop-login__menu-item_setting">
                                                            <a class="drop-login__menu-link" href="/personal/settings/">Изменить
                                                                пароль</a>
                                                        </li>
                                                        <? if (isAdministrator()) : ?>
                                                            <li class="drop-login__menu-item drop-login__menu-item_setting">
                                                                <a class="drop-login__menu-link" href="/admin/">Админ</a>
                                                            </li>
                                                        <? endif; ?>
                                                        <li class="drop-login__menu-item drop-login__menu-item_out">
                                                            <a class="drop-login__menu-link logout_href" href="">Выход</a>
                                                        </li>
                                                        <?/*<li class="drop-login__menu-item drop-login__menu-item_feedback">
                                                            <a class="drop-login__menu-link" href="">Обратная связь</a>
                                                        </li>*/?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><?
                                                if ($USER->getID() == 104) {
                                                    //echo "<pre>"; print_r($arUserFields); echo "</pre>";
                                                }
                                            } ?>

                                <? endif; ?>

                            </div>
                        </div>
                    </header>
                    <div class="header-search__wrap">
                        <div class="header-search__content">
                            <form action="/search/" class="header-search__form">
                                <div class="header-search__input-wrap"> <input type="text" name="q" class="header-search__input" placeholder="Поиск" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')"><div class="header-search-btn">НАЙТИ</div></div>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 24 24">
                                    <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                                </svg>
                                <div class="header-search__prompt">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="center">