<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("support");
$USER_PROP = needAuth('/auth/');
//die();
?><main class="main main--snow">
<div class="content">
	<div class="containered">
		
		<?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
		
		<div class="main-content support-content">
			 <?$APPLICATION->IncludeComponent(
					"bitrix:support.ticket",
					"",
					Array(
						"SEF_MODE" => "N", 
						"TICKETS_PER_PAGE" => "50", 
						"MESSAGES_PER_PAGE" => "20", 
						"SET_PAGE_TITLE" => "Y", 
						"VARIABLE_ALIASES" => Array(
							"ID" => "ID"
						)
					)
				);?>
			</div>
		</div>
	</div>
 </main><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>