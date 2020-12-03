<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Настройки электронной почты");
?>

<main class="main">

    <div class="content">
        <div class="containered">
            <div class="sidebar">
                <div class="sidebar__name">Модерация</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item active">
                        <a class="sidebar__link"
                           href="#">Пользователи</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Запросы</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Отчеты</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Настройки</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link"
                           href="#">Выход</a>
                    </li>
                </ul>
            </div>
            <div class="main-content">
                <p class="h2 title">Пользователи, ожидающие модерацию</p>
                <div class="profile__list">
                    <div class="profile-filter profile__item">
                        <div class="profile-filter__image">
                            <div class="header-login__img-wrap">
                                <img class="header-login__img" src="<?= $filePhoto["src"] ?>">
                                <span class="header-login__initials"><?= mb_strtoupper(mb_substr($surName, 0, 1)) ?><?= mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1)) ?></span>
                            </div>
                        </div>
                        <div class="profile-filter__info">
                            <p class="profile-filter__name"><?= $surName ?> <? if ($middleName != "") {
                                    echo mb_strtoupper(mb_substr($middleName, 0, 1)) . ".";
                                } ?><?= mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1)) ?>.</p>
                            <p class="profile-filter__career">Доктор филологических наук‎</p>
                            <p class="profile-filter__identifier">
                                <span class="profile-filter__id">ID: <?= $item["FIELDS"]["ID"] ?> | </span>
                                <span class="profile-filter__status">физическое лицо</span>
                            </p>
                        </div>
                        <div class="profile-filter__go-to">
                            <a class="profile-filter__go-to-link" href="#">Перейти к карточке</a>
                        </div>
                    </div>
                    <div class="profile-filter profile__item">
                        <div class="profile-filter__image">
                            <div class="header-login__img-wrap">
                                <img class="header-login__img" src="<?= $filePhoto["src"] ?>">
                                <span class="header-login__initials"><?= mb_strtoupper(mb_substr($surName, 0, 1)) ?><?= mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1)) ?></span>
                            </div>
                        </div>
                        <div class="profile-filter__info">
                            <p class="profile-filter__name"><?= $surName ?> <? if ($middleName != "") {
                                    echo mb_strtoupper(mb_substr($middleName, 0, 1)) . ".";
                                } ?><?= mb_strtoupper(mb_substr($item["FIELDS"]["NAME"], 0, 1)) ?>.</p>
                            <p class="profile-filter__career">Доктор филологических наук‎</p>
                            <p class="profile-filter__identifier">
                                <span class="profile-filter__id">ID: <?= $item["FIELDS"]["ID"] ?> | </span>
                                <span class="profile-filter__status">физическое лицо</span>
                            </p>
                        </div>
                        <div class="profile-filter__go-to">
                            <a class="profile-filter__go-to-link" href="#">Перейти к карточке</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
