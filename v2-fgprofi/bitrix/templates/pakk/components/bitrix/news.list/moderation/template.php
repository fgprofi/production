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
$arFace = array(7=>"Физическое лицо", 8=>"Юридическое лицо");
if($arParams['IBLOCK_ID'] == 7){
    $active_f = 'active';
    $face = 'fiz_faces';
}else {
    $active_u = 'active';
	$face = 'legal_faces';
}

?>
<main class="main">

    <div class="content">
        <div class="containered">
            <?/*<div class="sidebar">
                <div class="sidebar__name">Модерация</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="/admin/">Пользователи</a>
                    </li>
                    <li class="sidebar__item <?=$active_f?> f_need_moderation">
                        <a class="sidebar__link"
                           href="/admin/queries_f/">Запросы физ.лица</a>
                    </li>
                    <li class="sidebar__item <?=$active_u?> u_need_moderation">
                        <a class="sidebar__link"
                           href="/admin/queries_u/">Запросы юр.лица</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="/admin/report">Отчет</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="/support/">Техподдержка</a>
                    </li>
                    <li class="sidebar__item">
                        <div class="sidebar__link sidebar__link-info">Рассылка</div>
                        <div class="sidebar__tab-content">
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/audience/">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/template/">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/history/">Архив рассылок</a>
                        </div>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link logout_href"
                           href="#">Выход</a>
                    </li>
                </ul>
            </div>*/?>
            <?$USER_PROP["PROOF_MINFIN"] = $arParams["PROOF_MINFIN"];?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
            <div class="main-content">
                <p class="h2 title">Пользователи, ожидающие модерацию</p>
                <div class="profile-moderation__list">
                    <?foreach($arResult['ITEMS'] as $item):
                    $props = $item['PROPERTIES'];
                    $fields = $item['FIELDS'];
	                   $file =  CFile::ResizeImageGet( $props["PHOTO"]['VALUE'], array( 'width'  => 64,
	                                                                               'height' => 64
	                    ), BX_RESIZE_IMAGE_EXACT, true );
                    ?>
                    <div class="profile-filter profile__item">
                        <div class="profile-filter__image">
                            <div class="header-login__img-wrap">
                                <img class="header-login__img" src="<?= $file['src']?>">
                                <span class="header-login__initials"><?= mb_strtoupper(mb_substr($props['SURNAME']['VALUE'],0,1)).' '.mb_strtoupper(mb_substr($props['FIRST_NAME']['VALUE'],0,1))?></span>
                            </div>
                        </div>
                        <div class="profile-filter__info">
                            <p class="profile-filter__name"><?= mb_strtoupper($props['SURNAME']['VALUE']).' '.mb_strtoupper($props['FIRST_NAME']['VALUE']).' '.mb_strtoupper($props['MIDDLENAME']['VALUE']) ?>
                                <?if($props["NAME_SUBDIVISION"]['VALUE']):?>
                                    <br><span><?=$props["NAME_SUBDIVISION"]['VALUE']?></span>
                                <?endif;?>
                            </p>
                            <?
                            $career = "";
                            if(count($props['POSITION']['VALUE'])>0){
                                foreach ($props['POSITION']['VALUE'] as $key => $careerText) {
                                    $career .= $careerText;
                                    if(isset($props['POSITION']['VALUE'][$key+1])){
                                        $career .= " / ";
                                    }
                                }
                            }
                            ?>
                            <p class="profile-filter__career"><?=$career?></p>
                            <p class="profile-filter__identifier">
                                <span class="profile-filter__id">ID: <?= $fields["ID"] ?> | </span>
                                <span class="profile-filter__status"><?=$arFace[$arParams['IBLOCK_ID']]?></span>
                            </p>
                        </div>
                        <div class="profile-filter__go-to">
                            <a class="profile-filter__go-to-link" href="/personal/<?=$face?>/<?=$fields["ID"]?>/">Перейти к карточке</a>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-wrap-outer">
        <div class="modal-wrap">
            <div class="modal-wrap-inner">
                <form class="modal__form form-modal" action="">
                    <div class="form-modal__caption">
                        <div class="form-modal__row">
                            <p class="form-modal__name">Обратная связь</p>
                        </div>
                    </div>
                    <div class="form-modal__fields">
                        <div class="form-modal__row">
                            <input class="form-modal__input" type="text" name="name" placeholder="ФИО">
                        </div>
                        <div class="form-modal__row">
                            <input class="form-modal__input" type="tel" name="phone" placeholder="+7 (9__) ___-__-__">
                        </div>
                        <div class="form-modal__row">
                            <input class="form-modal__input" type="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-modal__row">
                            <textarea class="form-modal__input form-modal__input_textarea" type="text" name="message"
                                      placeholder="Введите сообщение..."></textarea>
                        </div>
                        <div class="form-modal__row">
                            <label class="form-modal__label">
                                <input class="form-modal__input" type="file" placeholder="Прикрепить файл">
                                <span class="form-modal__file">Прикрепить файл</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-modal__button">
                        <div class="form-modal__row">
                            <input class="form-modal__submit" type="submit" value="Отправить">
                        </div>
                    </div>
                </form>
                <div class="modal-wrap-close"></div>
            </div>
        </div>
    </div>
</main>

