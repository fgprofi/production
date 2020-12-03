$(document).ready(function(){
	$(".filter_btn").click(function(){
		var filterBox = $(this).parents(".full_filter_box");
		filterBox.find(".filter_btn").toggleClass("active");
		filterBox.find(".full_filter").slideToggle("400");
		$('.jsFilterSelect').select2('destroy');
		function select2Init() {
			$('.jsFilterSelect').select2({
		        placeholder: {id: 0, text: 'Выбрать'}, language: {
		            noResults: function (params) {
		                return "Ничего не найдено";
		            }
		        }
		    });
		    $('b[role="presentation"]').hide();
		}

		setTimeout(select2Init, 500);
		
	})
	$("input[name='FACE']").on('change', function(){
		var valueField = $(this).val();
		$("form.form_filter").removeClass("active");
		$("form[data-face="+valueField+"]").addClass("active");
	});
	$("label.select_all").click(function(){
		if($(this).find("input").prop('checked')){
			$(this).parents(".filter").find(".filter__item .filter__left label input").prop('checked', true);
		}else{
			$(this).parents(".filter").find(".filter__item .filter__left label input").prop('checked', false);
		}
	});
	function setFilterEvent(typeFace, event){
		let data = [];
		$(".filter .filter__item .filter__left label input:checked").each(function(){
			data.push($(this).val());
		});
		return data;
	}
	$(".filter .filter__head .label-filter_lock input").on("change", function(event){
		var typeFace = $("input[name=FACE]:checked").val();
		setFilterEvent(typeFace, event);
	});

	// $('.filter__head').on('click','input',function(e){
	// 	var data = {};
	//
	// 	data.active = $(e.target).hasClass('lock_all');
	// 	data.trash = $(e.target).hasClass('trash_all');
	// 	data.change_pass = $(e.target).hasClass('change_pass_all');
	// 	data.id = setFilterEvent();
	// 	console.log (data);
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "/ajax/profile_changes.php",
	// 		data: data,
	// 		dataType: "json",
	// 		success: function (responseData) {
	// 			console.log (responseData);
	// 			if(responseData.pass == 'false'){
	// 				for(var i of responseData.id){
	// 					console.log (i);
	// 					$ ('*[data-item-id=' + i + ']').css('display','none');
	// 				}
	// 			}
	// 		}
	// 	});
	// });

	$('.filter__body').on('click',function(event){
		if($($(event)[0].target)[0].type == 'checkbox'){
			var data = {};
			if(typeof($($(event)[0].target).closest('div').data('id')) !== 'undefined')
				data.id = $($(event)[0].target).closest('div').data('id');
			if(typeof($('[data-id='+data.id+']').find('.filter__input')[0]) !== 'undefined')
				data.active = $('[data-id='+data.id+']').find('.filter__input')[0].checked;
			if(typeof($('[data-id='+data.id+']').find('.filter__trash')[0]) !== 'undefined')
				data.trash = $('[data-id='+data.id+']').find('.filter__trash')[0].checked;
			if(typeof($('[data-id='+data.id+']').find('.filter__change-pass')[0]) !== 'undefined')
				data.change_pass = $('[data-id='+data.id+']').find('.filter__change-pass')[0].checked;

			if(data.id)
			{
				console.log (data);
				$.ajax({
					type: "POST",
					url: "/ajax/profile_changes.php",
					data: data,
					dataType: "json",
					success: function (responseData) {
						console.log (responseData);
						if(responseData.pass == 'false'){
							$ ('*[data-item-id=' + responseData.id + ']').css('display','none');
						}
					}
				});
			}
		}

	});
	//закрываем фильтр в режиме администратора при входе, иначе не корректно инициализируется select2 для селекта выбора
	// window.onload = function(){
	// 	$('.full_filter').find('.filter_btn.active').click();
	// }

	//собираем данные с фильтра для выгрузки отчета
	$('#create_feed').on('click', function(e){
		e.preventDefault();
		var dataJson = JSON.parse($(this).find(".ajax_data").text());
		console.log(dataJson);
		// var users = $ ('.filter').find('*[data-item-id]');
		var user_type = dataJson.ib;
		var data = {};
		// var arUs = [];
		// for(var i of users){
		// 	arUs.push($(i).data('item-id'));
		// }
		data.users = dataJson.id;
		data.user_type = user_type;
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
								$.get('/ajax/create_feed.php','users='+dataJson.id+'&user_type='+user_type, function(){
									document.location.href = '/ajax/create_feed.php?users='+dataJson.id+'&user_type='+user_type;
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
		//$.fancybox.open('<div class="popup_progress"><p class="main-content__report-title">Отчет готов на 50%</p><div class="main-content__report-progress" data-progress="50"></div></div>');
		// $.get('/ajax/create_feed.php','users='+dataJson.id+'&user_type='+user_type, function(){
		// 	document.location.href = '/ajax/create_feed.php?users='+dataJson.id+'&user_type='+user_type;
		// });
	})
});