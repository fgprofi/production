<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Администратор"); ?>
<main class="main">
	<div class="content">
		<div class="containered">
			<div class="sidebar">
				<div class="sidebar__name">Модерация</div>
				<ul class="sidebar__list">
					<li class="sidebar__item">
						<a class="sidebar__link" href="/admin/">Пользователи</a>
					</li>
					<li class="sidebar__item">
						<a class="sidebar__link" href="/admin/queries_f/">Запросы физ.лица</a>
					</li>
					<li class="sidebar__item">
						<a class="sidebar__link" href="/admin/queries_u/">Запросы юр.лица</a>
					</li>
					<li class="sidebar__item active">
						<a class="sidebar__link" href="/admin/report">Отчет</a>
					</li>
					<!--                    <li class="sidebar__item">-->
					<!--                        <a class="sidebar__link"-->
					<!--                           href="#">Настройки</a>-->
					<!--                    </li>-->
					<li class="sidebar__item ">
						<a class="sidebar__link" href="#">Выход</a>
					</li>
				</ul>
			</div>
			<div class="main-content main-content__report">
				<?
				// $APPLICATION->IncludeComponent(
				// 	"deus:filter.faces",
				// 	"report_filter",
				// 	Array(
				// 		"PROPERTIES"=>array(
				// 			"TYPE_F" => array(
				// 				"NAME"=>"TYPE_F",
				// 				"IBLOCK_ID"=>7,
				// 				"PROP"=>array(
				// 					"REGION_OF_RESIDENCE",
				// 					"LANGUAGE_SKILLS",
				// 					"LOCALITY",
				// 					"PLACE_OF_WORK",
				// 					"KIND_OF_ACTIVITY",
				// 					"FINANCIAL_LITERACY_COMPETENCIES",
				// 					"TARGET_AUDIENCE",
				// 					"WORK_REGIONS",
				// 					"AUTHOR_OF_MATERIALS",
				// 					"SIGN_OF_USER_DATA_DELETION",
				// 					"PERSONAL_DATA",
				// 					"VERIFICATION_PASSED_BY_MODERATOR",
				// 					//"Заблокирован",
				// 					"EXPERT_RATING",
				// 				),
				// 			),
				// 			"TYPE_U" => array(
				// 				"NAME"=>"TYPE_U",
				// 				"IBLOCK_ID"=>8,
				// 				"PROP"=>array(
				// 					"LOCATION_REGION",
				// 					"LOCALITY",
				// 					"FINANCIAL_LITERACY_AREAS",
				// 					"TYPE_ORGANIZATION",
				// 					"TARGET_AUDIENCE",
				// 					"REGIONS_THE_ORGANIZATION_WORKS_WITH",
				// 					"CONTRACTOR_FOR_MATERIALS",
				// 					"SIGN_OF_USER_DATA_DELETION",
				// 					//"Согласие",
				// 					"VERIFICATION_PASSED_BY_MODERATOR",
				// 					//"Заблокирован",
				// 					"EXPERT_RATING",
				// 				),
				// 			),
				// 		),
				// 	)
				// );

				?>

				<p class="h2 title">Отчетные формы по участникам сообщества</p>

				<p class="main-content__report-title">Отчет готов на 50%</p>
				<div class="main-content__report-progress" data-progress="50"></div>
				<div class="main-content__report-btns">
					<a href="#" class="main-content__report-download" id="create_feed">Скачать отчет</a>
					<a href="#" class="main-content__report-create">Создать новый отчет</a>
				</div>
			</div>
		</div>
	</div>
</main>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>