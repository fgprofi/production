<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Аккаунт");
?>

<main class="main">

    <div class="content">
        <div class="containered">
            <div class="sidebar">
                <div class="sidebar__name">Мой профиль</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Настройки</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Выход</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Обратная связь</a>
                    </li>
                </ul>
            </div>
            <div class="main-content">
                <div class="account">
                    <div class="account__info">
                        <p class="account__name">Максимилиан А.Р.</p>
                        <p class="account__identifier">
                            <span class="account__id">ID: 000123</span>
                            <span class="account__status">физическое лицо</span>
                        </p>
                        <button class="account__btn btn">Редактировать профиль</button>
                    </div>
                    <div class="account__image">
                        <div class="account__img-wrap img-wrap">
                            <img class="img"
                                 src="/bitrix/templates/pakk/img/foto2.jpg"
                                 alt="">
                        </div>
                    </div>
                    <div class="account__state state-account">
                        <p class="state-account__name">Сейчас Ваш профиль проверяется модераторами.</p>
                        <p class="state-account__desc">Как правило, это занимает пару минут, но <a
                                    class="state-account__link" href="#">в некоторых случаях</a> нам нужно больше
                            времени на проверку.</p>
                    </div>
                    <div class="account__state state-account state-account_success">
                        <p class="state-account__name">Проверка модератором прошла успешна.</p>
                    </div>
                    <div class="account__state state-account state-account_failed">
                        <p class="state-account__name">Ваша карточка не активна.</p>
                        <p class="state-account__desc">Чтобы узнать причину необходимо <a class="state-account__link"
                                                                                          href="#">связаться с
                                администраторомв.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
