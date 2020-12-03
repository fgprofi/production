<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("sending");
?>
<main class="main">
    <div class="content">
    	<div class="containered">
    		<div class="sidebar">
                <div class="sidebar__name">Модерация</div>
                <ul class="sidebar__list">
                    <li class="sidebar__item active">
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
                           href="/admin/report">Отчет</a>
                    </li>
                    <li class="sidebar__item">
                        <div class="sidebar__link sidebar__link-info">Рассылка</div>
                        <div class="sidebar__tab-content">
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/">Мои рассылки</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/#popup-audience">Аудитории</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/template/">Мои шаблоны</a>
                            <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/history/">Архив рассылок</a>
                        </div>
                    </li>
<!--                    <li class="sidebar__item">-->
<!--                        <a class="sidebar__link"-->
<!--                           href="#">Настройки</a>-->
<!--                    </li>-->
                    <li class="sidebar__item">
                        <a class="sidebar__link logout_href"
                           href="#">Выход</a>
                    </li>
                </ul>
            </div>
    		<div class="main-content">
	    		<?$APPLICATION->IncludeComponent(
					"bitrix:subscribe.index",
					"",
					Array(
						"CACHE_TIME" => "3600",
						"CACHE_TYPE" => "A",
						"PAGE" => "#SITE_DIR#about/subscr_edit.php",
						"SET_TITLE" => "Y",
						"SHOW_COUNT" => "Y",
						"SHOW_HIDDEN" => "Y"
					)
				);?>
			</div>
		</div>
    </div>
</main><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>