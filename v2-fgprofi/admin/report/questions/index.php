<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$USER_PROP = needAuth('/freg/');
$APPLICATION->SetTitle("Администратор"); 

// $ob = CIBlockElement::getList(array(),array("IBLOCK_ID"=>15, "GLOBAL_ACTIVE"=>"N"),false,false,array("ID", "IBLOCK_ID", "NAME"));
// while($res = $ob->Fetch()){
// 	$arResult[] = $res;
// }
$arResult["SUPPORT_THEME_HL"] = getSupportThemes();
// echo "<pre>"; print_r($arResult); echo "</pre>";
// die();

?>
<main class="main">
	<div class="content">
		<div class="containered">
			<?require($_SERVER["DOCUMENT_ROOT"]."/include/sitebar-menu.php");?>
			<div class="main-content">
				<form action="" class="report-mailing">
					<div class="rubricator-select">
                        <div class="rubricator-items">
                            <?$rubricCheckName = "Выберите категорию";
                            foreach($arResult["SUPPORT_THEME_HL"] as $theme):?>
                                <div data-value='<?=$theme["UF_CODE"]?>' class="rubricator-items__option"><?=$theme["UF_NAME_THEME"]?></div>
                            <?endforeach;?>
                        </div>
                        <div class="rubricator-title"><?=$rubricCheckName?></div>
                        <input type="hidden" class="rubricator-input" name="list" value="">
                    </div>
				</form>
				<br>
				<br>
				<a href="#" class="main-content__report-download" id="create_feed">
				    <div class="ajax_data" style="display:none"></div>
				    Скачать отчет
				</a>
				<a href="#" class="main-content__report-download" id="create_all_feed">
				    Скачать полный отчет
				</a>
				<div class="data_res"></div>
			</div>

		</div>
	</div>
</main>
<style>
	#popup_progress{
		display: none;
	}
	#popup_progress .main-content__report-progress .progress-bg {
	    position: absolute;
	    height: 100%;
	    top: 0;
	    left: 0;
	    background: url(/bitrix/templates/pakk/img/progress-bar.png);
	}
	#popup_progress .main-content__report-progress:before{
		display: none;
	}
	#popup_progress .fancybox-close-small{
		display: none;
	}
</style>
<script>
	$(".report-mailing").on("input", function(){
		var data = $(this).find(".rubricator-input").val();
		$("#create_feed .ajax_data").text(data);
		//console.log(data);
	});
	$('#create_feed').on('click', function(e){
		e.preventDefault();
		$(".progress-bg").css("width", "0%");
		$(".main-content__report-title span").text("0");
		var data = $(this).find(".ajax_data").text();
		if(data != ""){
			$.fancybox.open({
				src: '#popup_progress',
				type: 'inline',
				smallBtn : false,
				opts: {
					afterShow: function(instance, current) {
						var fullTime = 3000;
						var timeProgress = fullTime/100;
						var dataClear = 0;
						var dataPercent = 0;
						intervalProgress = setInterval(function(){
							dataPercent++;
							$(".main-content__report-title span").text(dataPercent);
							$(".progress-bg").animate({
								width:dataPercent+'%'
							}, timeProgress);
							
							dataClear = dataClear+30;
							if(dataClear == fullTime){
								clearInterval(intervalProgress);
								setTimeout(function(){
									$.get('/ajax/create_questions_by_rubrics_feed.php','rubric_id='+data, function(dataAjax){
										//console.log(dataAjax);
										//$(".data_res").html(dataAjax);
										document.location.href = '/ajax/create_questions_by_rubrics_feed.php?rubric_id='+data;
									});
									$.fancybox.close();
								}, 1000);
							}
						}, timeProgress);
					},
					beforeClose: function(){
						if($(".main-content__report-title span").text() != "100"){
							return false;
						}
					}
				}
			});
		}
	});
	$('#create_all_feed').on('click', function(e){
		e.preventDefault();
		$(".progress-bg").css("width", "0%");
		$(".main-content__report-title span").text("0");
		$.fancybox.open({
			src: '#popup_progress',
			type: 'inline',
			smallBtn : false,
			opts: {
				afterShow: function(instance, current) {
					var fullTime = 3000;
					var timeProgress = fullTime/100;
					var dataClear = 0;
					var dataPercent = 0;
					intervalProgress = setInterval(function(){
						dataPercent++;
						$(".main-content__report-title span").text(dataPercent);
						$(".progress-bg").animate({
							width:dataPercent+'%'
						}, timeProgress);
						
						dataClear = dataClear+30;
						if(dataClear == fullTime){
							clearInterval(intervalProgress);
							setTimeout(function(){
								document.location.href = '/ajax/create_questions_feed_xlsx.php';
								$.fancybox.close();
							}, 1000);
						}
					}, timeProgress);
				},
				beforeClose: function(){
					if($(".main-content__report-title span").text() != "100"){
						return false;
					}
				}
			}
		});
	});
</script>
<div id="popup_progress">
    <p class="main-content__report-title">Отчет готов на <span>0</span>%</p>
    <div class="main-content__report-progress">
        <div class="progress-bg"></div>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>