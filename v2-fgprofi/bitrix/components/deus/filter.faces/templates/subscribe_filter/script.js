$(document).ready(function(){
	$(".startFilter").click();
	$(".clear-form").click(function(){
		$("form.active .remove-field").click();
		$("form.active select").val('').trigger('change');
		$("form.active input").val("");
		$("form.all_user input[type=checkbox]").prop("checked",false);
		$('form.active select[name^=EMPTY_PROP]').multipleSelect('uncheckAll');
		$(".startFilter").click();

	});
	$('input,textarea').focus(function(){
		$(this).data('placeholder',$(this).attr('placeholder'))
		$(this).attr('placeholder','');
	});
	$('input,textarea').blur(function(){
		$(this).attr('placeholder',$(this).data('placeholder'));
	});
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
		if(valueField == "TYPE_U"){
			$(".user-search-personal-data").hide();
		}else{
			$(".user-search-personal-data").show();
		}
		$("form.all_user .user-search-personal-data input[type=checkbox]").prop("checked",false);
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
	$(".send-subscribe").click(function(){
		var form = $(this).parent("form");
		var data = form.serializeArray();
		console.log(data);
		$.fancybox.open({
            src: '#popup-subscribe',
        });
	});
	/*$('#create_feed').on('click', function(e){
		e.preventDefault();
		var dataJson = JSON.parse($(this).find(".ajax_data").text());
		var user_type = dataJson.ib;
		var data = {};
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
	})*/
});