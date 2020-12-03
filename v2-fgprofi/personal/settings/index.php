<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth('/auth/');
$APPLICATION->SetTitle("Настройки пользователя");
?>

<main class="main">

    <div class="content">
        <div class="containered">
	        <?/*<div class="sidebar">
                <div class="sidebar__name">Настройки</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item active">
                        <a class="sidebar__link"
                           href="#">Изменить пароль</a>
                    </li>
                    <li class="sidebar__item active">
                        <a class="sidebar__link"
                           href="#">Настройки электронной почты</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Учетная запись</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Безопасность</a>
                    </li>
                </ul>
            </div>*/?>
            <div class="main-content">
                <div class="email-setting">
	                <?$APPLICATION->IncludeComponent(
		                "deus:change.pass",
		                ".default"
	                );?>
                </div>
            </div>
            <?/*<div class="main-content">
                <div class="email-setting">
                    <h1 class="h1 email-setting__title">Настройки электронной почты</h1>
                    <div class="email-setting__list">
                        <div class="email-setting__item">
                            <p class="email-setting__name">Ваш адрес электронной почты</p>
                            <p class="email-setting__desc email-setting__desc_email">ivanov@info.ru</p>
                            <div class="email-setting__buttons">
                                <button class="email-setting__button email-setting__button_changed">Изменить электронную почту</button>
                            </div>
                        </div>
                        <div class="email-setting__item">
                            <p class="email-setting__name">Email рассылка</p>
                            <p class="email-setting__desc">Выберите частоту получении писем на почту</p>
                            <div class="email-setting__buttons">
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="mailing" checked>
                                    <span class="email-setting__button">Включить</span>
                                </label>
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="mailing">
                                    <span class="email-setting__button">отключить</span>
                                </label>
                            </div>
                        </div>
                        <div class="email-setting__item">
                            <p class="email-setting__name">Письма из публикаций</p>
                            <p class="email-setting__desc">Контролируйте, какие электронные письма отправляются вам из
                                публикаций, за которыми вы следите</p>
                            <div class="email-setting__buttons">
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="letters" checked>
                                    <span class="email-setting__button">Включить</span>
                                </label>
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="letters">
                                    <span class="email-setting__button">отключить</span>
                                </label>
                            </div>
                        </div>
                        <div class="email-setting__item">
                            <p class="email-setting__name">Уведомления</p>
                            <p class="email-setting__desc">Уведомления, когда люди упоминают вас в своих историях</p>
                            <div class="email-setting__buttons">
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="notification" checked>
                                    <span class="email-setting__button">Включить</span>
                                </label>
                                <label class="email-setting__label">
                                    <input class="email-setting__input" type="radio" name="notification">
                                    <span class="email-setting__button">отключить</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>*/?>
        </div>
    </div>
</main>
<?//echo "<pre>"; print_r($USER_PROP); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>