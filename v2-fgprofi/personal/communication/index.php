<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Общение");
if(!isset($USER_PROP["PROOF_MINFIN"]) || $USER_PROP["PROOF_MINFIN"] != 23){
	LocalRedirect("/personal/");
}
//echo "<pre>"; print_r($USER_PROP); echo "</pre>";
?>
<main class="main">
    <div class="content">
    	<div class="containered">
    		<?/*<div class="sidebar">
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
<!--                    <li class="sidebar__item">-->
<!--                        <a class="sidebar__link"-->
<!--                           href="#">Настройки</a>-->
<!--                    </li>-->
                    <li class="sidebar__item">
                        <a class="sidebar__link logout_href"
                           href="#">Выход</a>
                    </li>
                </ul>
            </div>*/?>
            <?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
    		<div class="main-content">
				<?$APPLICATION->IncludeComponent(
					"deus:filter.faces",
					"filter-communication",
					Array(
						"MULTI_SELECT"=>array(
							"LANGUAGE_SKILLS",
						),
						"PROPERTIES"=>array(
							"TYPE_F" => array(
								"NAME"=>"TYPE_F",
								"IBLOCK_ID"=>7,
								"PROP"=>array(
									"FIRST_NAME",
									"SURNAME",
									"DATE_OF_BIRTH",
									"EMAIL",
									"SOC",
									"POSITION",
									"SIFLAS",
									"LANGUAGE_SKILLS",
									"REGION_OF_RESIDENCE",
									"LOCALITY",
									"PLACE_OF_WORK",
									"EDUCATION",
									"KIND_OF_ACTIVITY",
									"FINANCIAL_LITERACY_COMPETENCIES",
									"TARGET_AUDIENCE",
									"WORK_REGIONS",
									"AUTHOR_OF_MATERIALS",
									"SIGN_OF_USER_DATA_DELETION",
									"PERSONAL_DATA",
									"VERIFICATION_PASSED_BY_MODERATOR",
									"EXPERT_RATING",
								),
							),
							"TYPE_U" => array(
								"NAME"=>"TYPE_U",
								"IBLOCK_ID"=>8,
								"PROP"=>array(
									"FIRST_NAME",
									"INN",
									"KPP",
									"OGRN",
									"ACTUAL_ADDRESS",
									"PHONE",
									"EMAIL",
									"SITE_PAGE",
									"ADDITIONAL_INFORMATION",
									"NAME_SUBDIVISION",
									"LOCATION_REGION",
									"LOCALITY",
									"FINANCIAL_LITERACY_AREAS",
									"TYPE_ORGANIZATION",
									"TARGET_AUDIENCE",
									"REGIONS_THE_ORGANIZATION_WORKS_WITH",
									"CONTRACTOR_FOR_MATERIALS",
									"SIGN_OF_USER_DATA_DELETION",
									"VERIFICATION_PASSED_BY_MODERATOR",
									"EXPERT_RATING",
								),
							),
						),
					)
				);?>
			</div>
		</div>
    </div>
</main>
<div class="communication-form-popup">
	
</div>
<?//echo "<pre>"; print_r($USER_PROP); echo "</pre>";?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>