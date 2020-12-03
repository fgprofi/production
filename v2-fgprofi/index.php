<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Портал Сообщества профессионалов в области финансовой грамотности. Создан в рамках Проекта Минфина России «Содействие повышению уровня финансовой грамотности населения и развитию финансового образования в Российской Федерации».");
$APPLICATION->SetPageProperty("keywords", "Портал Сообщества профессионалов в области финансовой грамотности. Создан в рамках Проекта Минфина России «Содействие повышению уровня финансовой грамотности населения и развитию финансового образования в Российской Федерации».");
$APPLICATION->SetPageProperty("title", "Портал Сообщества профессионалов в области финансовой грамотности.");
$APPLICATION->SetTitle("");
?>

<? if ($_GET['account_recovery'] == '1') : ?>
    <div class="login account-recovery-wrap">
        <div class="sign_in account-recovery">
            <div class="account-recovery__caption">
                <h2 class="account-recovery__title">Восстановление аккаунта</h2>
                <p class="account-recovery__title-note">Введите последний ваш логин/email этого аккаунта</p>
            </div>
            <form class="account-recovery__form">
                <label class="form__label">
                    <input class="form__input" type="email" placeholder="E-mail">
                </label>
                <div class="account-recovery__success"></div>
                <input class="form__submit" type="submit" value="Отправить">
            </form>
            <p class="another__text">
                <a class="another-link" href="#">Другой способ</a>
            </p>
        </div>
    </div>
<? endif; ?>

<main class="main">
    <div class="main__header header-main">
        <div class="containered">
            <div class="header-main__content">
                <!--                    <div class="header-main__block-button">-->
                <!--                        <a class="header-main__button" href="/">назад</a>-->
                <!--                    </div>-->
                <h1 class="header-main__title"><span class="header-main__title-capital" style="color: #111111;"><b>Финансовая грамотность</b></span><span style="color: #111111;"><b> </b></span><br>
                    <b> </b><span><b>Сообщество профессионалов</b></span></h1>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="containered">
            <div class="nav__list">
                <a class="nav__item item-nav" href="/about/">
                    <div class="item-nav__name item-nav__name_about">
                        О проекте
                    </div>
                    <div class="item-nav__desc">
                        Общая информация о предыстории, целях и задачах проекта
                    </div>
                </a>
                <a class="nav__item item-nav" href="/about/kontseptsiya/">
                    <div class="item-nav__name item-nav__name_bulb">
                        Концепция развития сообщества
                    </div>
                    <div class="item-nav__desc">
                        Концепция развития сообщества профессионалов в области финансовой грамотности
                    </div>
                </a>
                <a class="nav__item item-nav" href="/news/">
                    <div class="item-nav__name item-nav__name_news">
                        Новости
                    </div>
                    <div class="item-nav__desc">
                        События проекта и мира финансовой грамотности
                    </div>
                </a>
                <a class="nav__item item-nav" href="/freg/">
                    <div class="item-nav__name item-nav__name_login">
                        Зарегистрироваться
                    </div>
                    <div class="item-nav__desc">
                        Для желающих вступить в Сообщество
                    </div>
                </a>
                <a class="nav__item item-nav" href="/auth/type_f/">
                    <div class="item-nav__name item-nav__name_man">
                        Личный кабинет
                    </div>
                    <div class="item-nav__desc">
                        Вход для зарегистрированного участника Сообщества
                    </div>
                </a>
                <a class="nav__item item-nav" href="/consulting/">
                    <div class="item-nav__name item-nav__name_centre">
                        Консультационный центр
                    </div>
                    <div class="item-nav__desc">
                        Ответы на вопросы участников Сообщества
                    </div>
                </a>

                <? /*<a class="nav__item item-nav" href="/auth/type_f/">
                        <div class="item-nav__name item-nav__name_man">
                            Личный кабинет Физического лица
                        </div>
                        <div class="item-nav__desc">
                            Вход для зарегистрированного участника Сообщества
                        </div>
                    </a>
                    <a class="nav__item item-nav" href="/auth/type_u/">
                        <div class="item-nav__name item-nav__name_personal">
                            Личный кабинет Юридического лица
                        </div>
                        <div class="item-nav__desc">
                            Вход для зарегистрированного участника Сообщества
                        </div>
                    </a>*/ ?>

                <a class="nav__item item-nav" href="https://www.finpronews.ru/" target="_blank">
                    <div class="item-nav__name item-nav__name_magazine">
                        Журнал «Дружи с финансами»
                    </div>
                    <div class="item-nav__desc">
                        Издание для специалистов, занимающихся распространением финансовой грамотности и защитой
                        прав потребителей финансовых услуг
                    </div>
                </a>


                <a class="nav__item item-nav" href="about/faq">
                    <div class="item-nav__name item-nav__name_faq">Частые вопросы</div>
                    <div class="item-nav__desc">
                        <?/*Пилотные регионы, участвующие в реализации Проекта*/?>
                        Ответы на наиболее популярные вопросы
                    </div>
                </a>
                <a class="nav__item item-nav" target="_blank" href="http://numbers.fgprofi.ru/">
                    <div class="item-nav__name item-nav__name_news">
                        Карты, графики, инфографика
                    </div>
                    <div class="item-nav__desc">
                        Материалы по финансовой грамотности и защите прав потребителей
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>