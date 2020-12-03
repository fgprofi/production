<? if ( ! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
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
$this->setFrameMode( true );
$filePhoto["src"] = "/bitrix/templates/pakk/img/avatar.svg";
if ( isset( $arResult["PROPERTIES"]["PHOTO"]["VALUE"] ) && $arResult["PROPERTIES"]["PHOTO"]["VALUE"] != "" ) {
	$filePhoto = CFile::ResizeImageGet( $arResult["PROPERTIES"]["PHOTO"]["VALUE"], array( 'width'  => 160,
	                                                                                      'height' => 160
	), BX_RESIZE_IMAGE_EXACT, true );
}
$surName    = "";
$middleName = "";
if ( isset( $arResult["PROPERTIES"]["SURNAME"]["VALUE"] ) && $arResult["PROPERTIES"]["SURNAME"]["VALUE"] != "" ) {
	$surName = $arResult["PROPERTIES"]["SURNAME"]["VALUE"];
}
if ( isset( $arResult["PROPERTIES"]["MIDDLENAME"]["VALUE"] ) && $arResult["PROPERTIES"]["MIDDLENAME"]["VALUE"] != "" ) {
	$middleName = $arResult["PROPERTIES"]["MIDDLENAME"]["VALUE"];
}
if ( isset( $arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"] ) && $arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"] != "" ) {
	$first_name = $arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"];
}
$fullName = $surName . ' ' . $first_name . ' ' . $middleName;
$typeFace = "Юридическое лицо";
if ( $arParams["IBLOCK_ID"] == 7 ) {
	$typeFace = "Физическое лицо";
} ?>
    <main class="main">

        <div class="content">
            <div class="containered">
                <?/*if(!isAdministrator()):?>
                <div class="sidebar">
                    <div class="sidebar__name">Мой профиль</div>
                    <ul class="sidebar__list">
                        <li class="sidebar__item">
                            <a class="sidebar__link drop-login__menu-item_feedback"
                               href="#">Обратная связь</a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link"
                               href="/support/">Техподдержка</a>
                        </li>
                        <li class="sidebar__item">
                                <a class="sidebar__link"
                                   href="/personal/communication/">Общение</a>
                            </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link logout_href"
                               href="">Выход</a>
                        </li>
                    </ul>
                </div>
                <?else:?>
                    <div class="sidebar">
                        <div class="sidebar__name">Модерация</div>
                        <ul class="sidebar__list">
                            <li class="sidebar__item">
                                <a class="sidebar__link"
                                   href="/admin/">Пользователи</a>
                            </li>
                            <li class="sidebar__item f_need_moderation">
                                <a class="sidebar__link"
                                   href="/admin/queries_f/">Запросы физ.лица</a>
                            </li>
                            <li class="sidebar__item u_need_moderation">
                                <a class="sidebar__link"
                                   href="/admin/queries_u/">Запросы юр.лица</a>
                            </li>
                            <li class="sidebar__item">
                                <a class="sidebar__link"
                                   href="/support/">Техподдержка</a>
                            </li>
                            
                            <li class="sidebar__item">
                                <a class="sidebar__link"
                                   href="/vote/">Опросы</a>
                            </li>
                            <li class="sidebar__item">
                                <a class="sidebar__link"
                                   href="/admin/subscribe/">Рассылка</a>
                            </li>
                            <li class="sidebar__item">
                                <a class="sidebar__link logout_href" >Выход</a>
                            </li>
                        </ul>
                    </div>
                <?endif;*/?>
                <?$USER_PROP["PROOF_MINFIN"] = $arParams["PROOF_MINFIN"];?>
                <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
                <div class="account">
                    <div class="account__info">
                        <p class="account__name"><?= $fullName ?>
                            <?if($arResult["PROPERTIES"]["NAME_SUBDIVISION"]["VALUE"] != ""):?>
                                <br><span style="font-size: 0.875rem;color: #333333;">Название подразделения: <?=$arResult["PROPERTIES"]["NAME_SUBDIVISION"]["VALUE"]?></span>
                            <? endif; ?>
                        </p>
                        <?$rsUser = CUser::GetByID($arResult["PROPERTIES"]["USER_ID"]["VALUE"]);
                        $arUser = $rsUser->Fetch();?>
                        <p class="profile_login_info">Ваш логин:<span> <?=$arUser["LOGIN"]?></span></p>
                        <p class="account__identifier">
                            <span class="account__id">ID: <?= $arResult["ID"] ?></span>
                            <span class="account__status"><?= $typeFace ?></span>
                        </p>
	                    <? 
                        global $USER;
                        if (($arResult["FIELDS"]['ACTIVE'] == "Y" && $arResult["PROPERTIES"]["USER_ID"]["VALUE"] == $USER->GetID()) || isAdministrator()): ?>
                            <a class="account__btn btn" href="/personal/edit/?id=<?= base64_encode($arResult[PROPERTIES][USER_ID][VALUE]) ?>">Редактировать профиль</a>
	                    <? endif; ?>
                        <?if($arResult["PROPERTIES"]["USER_ID"]["VALUE"] != $USER->GetID() || (isAdministrator() && $arResult["PROPERTIES"]["USER_ID"]["VALUE"] != $USER->GetID())):?>
                            <a class="link link-button link-button--disabled write-message-btn" data-id="<?=$arResult["ID"]?>" data-ib-id="<?=$arResult["IBLOCK_ID"]?>" href="">Написать сообщение</a>
                        <? endif; ?>
                    </div>
                    <div class="account__image">
                        <div class="account__img-wrap img-wrap">
                            <img class="img"
                                 src="<?= $filePhoto["src"] ?>"
                                 alt="">
                        </div>
                    </div>
                    <?if($arResult["PROPERTIES"]["USER_ID"]["VALUE"] == $USER->GetID()):?>
    					<? if ( $arResult["PROPERTIES"]["VERIFICATION_PASSED_BY_MODERATOR"]["VALUE"] == "" ): ?>
                            <div class="account__state state-account">
                                <p class="state-account__name">Ваш профиль проверяется модератором.</p>
                                <p class="state-account__desc">После проведения проверки данная надпись исчезнет.
                                    При возникновении вопросов <a class="state-account__link" href="/support/?ID=0&edit=1">свяжитесь с администратором.</a></p>
                            </div>
    					<? else: ?>
                            <?$file = 'close_message.json';
                            $data = file_get_contents($file, true);
                            $data = json_decode($data, true);
                            if(!in_array($arResult["ID"], $data)):?>
                                <div class="account__state state-account state-account_success">
                                    <div class="close_mess" data-user-id="<?= $arResult["ID"] ?>"></div>
                                    <p class="state-account__name">Проверка Вашего профиля модератором завершена.</p>
                                </div>
                            <?endif;?>
    					<? endif; ?>
    					<? if ( $arResult["FIELDS"]['ACTIVE'] != "Y" ): ?>
                            <div class="account__state state-account state-account_failed">
                                <p class="state-account__name">Ваш профиль не активен.</p>
                                <p class="state-account__desc">Чтобы узнать причину необходимо
                                    <a class="state-account__link" href="/support/?ID=0&edit=1">связаться с администратором.</a>
                                </p>
                            </div>
    					<? endif; ?>
                    <? endif; ?>
                    <?/*if($USER->GetID() == 1){
                        echo "<pre>"; print_r($arResult["DISPLAY_PROPERTIES"]); echo "</pre>";
                    }*/?>
                    <?if(isset($arResult["TABS"]) && count($arResult["TABS"])>0):?>
                        <div class="account__tab">
                            <div class="account__tab-wrap">
                                <?$activeTab = " active";?>
                                <?foreach($arResult["TABS"] as $tab):?>
                                    <div class="account__tab-btn<?=$activeTab?>"><?=$tab["NAME"]?></div>
                                    <?$activeTab = "";?>
                                <?endforeach;?>
                            </div>
                            <?$activeTab = " show";?>
                            <?foreach($arResult["TABS"] as $tab):?>
                                <div class="account__tab-content<?=$activeTab?>">
                                    <div class="account__tab-title"><?=$tab["NAME"]?></div>
                                    <div class="account__tab-text">
                                        <?foreach($tab["PROPS"] as $propName => $prop):?>
                                            <div class="account__tab-item">
                                                <div class="account__tab-item-name"><?=$propName?> </div>
                                                <?if(is_array($prop)):?>
                                                    <div class="account__tab-item-descr">
                                                        <?if($propName == "Владение языками"):?>
                                                            <?$strPropValue = "";?>
                                                            <?foreach($prop as $propValueKey => $propValue):?>
                                                                <?if($propValueKey == 0){
                                                                    $strPropValue .= $propValue."<span>";
                                                                }else{
                                                                    $strPropValue .= " / ".$propValue;
                                                                }?>
                                                            <?endforeach;?>
                                                            <?$strPropValue .= "</span>";?>
                                                            <?echo $strPropValue;?>
                                                        <?else:?>
                                                            <?foreach($prop as $propValueKey => $propValue):?>
                                                                <?echo $propValue."<br>";?>
                                                            <?endforeach;?>
                                                        <?endif;?>
                                                    </div>
                                                <?else:?>
                                                    <div class="account__tab-item-descr"><?=$prop?></div>
                                                <?endif;?>
                                            </div>
                                        <?endforeach;?>
                                    </div>
                                </div>
                                <?$activeTab = "";?>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </main>
    <div class="communication-form-popup">

    </div>
<? //echo "<pre>"; print_r($arResult); echo "</pre>";?>