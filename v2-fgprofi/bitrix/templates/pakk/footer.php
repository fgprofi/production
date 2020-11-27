<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);
// $arFNM_F = getFacesNeedModeration(7);
// $arFNM_U = getFacesNeedModeration(8);
?>
<footer class="footer">
    <div class="support-form-popup"></div>
    <div class="containered footer__containered">
        <div class="footer__ministry ministry__list">
            <img class="ministry__item" src="/bitrix/templates/pakk/img/ministry/ministry-1.png" alt="">
            <img class="ministry__item" src="/bitrix/templates/pakk/img/ministry/ministry-2.png" alt="">
        </div>

        <div class="footer__email email">
            <? $APPLICATION->IncludeComponent("bitrix:main.include", "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/mail.php",
                    "EDIT_TEMPLATE" => ""
                )
            ); ?>
        </div>
        <div class="footer__copyright copyright">&copy; 2020</div>
    </div>
    <div id="logout-popup">
        <div class="logout-popup-text">
            Вы действительно хотите выйти?
            <a class="logout-popup-btn"
               href="<? echo $APPLICATION->GetCurPageParam("logout=yes", array("login", "logout", "register", "forgot_password", "change_password")); ?>">
                <div class="button-green">
                    Выход
                </div>
            </a>
        </div>
    </div>
    <div class="modal-wrap-outer" id="form-modal">
        <div class="modal-wrap">
            <div class="modal-wrap-inner">
                <form class="modal__form form-modal" action="">
                    <div class="form-modal__caption">
                        <div class="form-modal__row">
                            <p class="form-modal__name">Обратная связь</p>
                        </div>
                    </div>
                    <div class="form-modal__fields">
                        <div class="form-modal__row required">
                            <input class="form-modal__input" type="text" name="name" data-default-value="<?= $fullName ?>" placeholder="ФИО"
                                   value="<?= $fullName ?>">
                        </div>
                        <div class="form-modal__row">
                            <input class="form-modal__input phone" type="tel" name="phone"
                                   placeholder="+7 (__) ___-__-__">
                        </div>
                        <div class="form-modal__row">
                            <input class="form-modal__input" type="email" name="email" data-default-value="<?= $email ?>" placeholder="Email"
                                   value="<?= $email ?>">
                        </div>
                        <div class="form-modal__row">
                            <textarea class="form-modal__input form-modal__input_textarea" type="text" name="message"
                                      placeholder="Введите сообщение..."></textarea>
                        </div>
                        <!--                        <div class="form-modal__row">-->
                        <!--                            <label class="form-modal__label">-->
                        <!--                                <input class="form-modal__input" type="file" placeholder="Прикрепить файл">-->
                        <!--                                <span class="form-modal__file">Прикрепить файл</span>-->
                        <!--                            </label>-->
                        <!--                        </div>-->
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
    <div class="modal__message">Заявка отправлена</div>
    <div class="modal-wrap-outer" id="form-modal-save-account">
        <div class="modal-wrap" style="width:30%">
            <div class="modal-wrap-inner">
                <form class="modal__form form-modal" action="">
                    <div class="form-modal__caption">
                        <div class="form-modal__row">
                            <p class="form-modal__name">Ваш аккаунт сохранен</p>
                        </div>
                    </div>
                    <?/*<div class="form_button form-modal__button">
                        <div class="form-modal__row">
                            <input class="link link-button form-modal-save-account__submit" type="submit"
                                   value="Закрыть">
                        </div>
                    </div>*/?>
                </form>
                <div class="modal-wrap-close"></div>
            </div>
        </div>
    </div>
</footer>
<?
$arFNM_F = getFacesNeedModeration(7);
$arFNM_U = getFacesNeedModeration(8); ?>
<? if (count($arFNM_F) > 0): ?>
    <script>
        $(document).ready(function () {
            $("ul li.f_need_moderation").append("<div class='count_need_moderation'><?=count($arFNM_F);?><div>")
        });
    </script>
<? endif; ?>
<? if (count($arFNM_U) > 0): ?>
    <script>
        $(document).ready(function () {
            $("ul li.u_need_moderation").append("<div class='count_need_moderation'><?=count($arFNM_U);?><div>")
        });
    </script>
<? endif; ?>
</div>
</body>
</html>