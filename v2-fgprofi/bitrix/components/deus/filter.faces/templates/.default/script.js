$(document).ready(function(){
	function multiselect_deselectAll($el) {
        // $('option', $el).each(function(element) {
        //     $el.multiSelect('deselect', $(this).val());
        // });
    }

    
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
	
	$('.send-refresh-data-users').on('click',function(e){
		if($(this).hasClass('wait-send')){
			return false;
		}
		var data = {};
		let id = [];
		$(".filter__body .filter__input[name^=select]").each(function(){
			if($(this).prop("checked")){
				id.push(Number($(this).val()));
			}
		});
		//console.log(id);
		if(id.length != 0){
			data.id = id;
			//console.log(data);
			$.ajax({
				type: "POST",
				url: "/ajax/sendRefreshDataUsers.php",
				data: data,
				dataType: "json",
				beforeSend: function () {
                    $('.send-refresh-data-users').addClass('wait-send');
                },
				success: function (responseData) {
					if(responseData.length != 0){
						var popupText = "Выбраным пользователям, отправлены письма<br> для обновления данных";
						$('#form-modal-save-account').find('.form-modal__name').html(popupText);
						$.fancybox.open({
							src: '#form-modal-save-account'
						});
					}
					$(".filter__body .filter__input[name^=select]").prop("checked",false);
					$('.send-refresh-data-users').removeClass('wait-send');
				}
			});
		}else{
			var popupText = "Пользователи не выбраны!";
			$('#form-modal-save-account').find('.form-modal__name').html(popupText);
			$.fancybox.open({
				src: '#form-modal-save-account'
			});
		}
	});
	$('.filter__head').on('click','input',function(e){
		if(!$(this).parent("label").hasClass("select_all")){
			var data = {};
		
			data.active = $(e.target).hasClass('lock_all');
			data.trash = $(e.target).hasClass('trash_all');
			data.change_pass = $(e.target).hasClass('change_pass_all');
			data.id = setFilterEvent();
			//console.log ("22");
			$.ajax({
				type: "POST",
				url: "/ajax/profile_changes.php",
				data: data,
				dataType: "json",
				success: function (responseData) {
					//console.log (responseData);
					var form = $("form.active");
			        var face = $("input[name=FACE]:checked").val();
			        //startFilter(form, face);
					if(responseData.pass == 'false'){
						for(var i of responseData.id){
							//console.log (i);
							//$ ('*[data-item-id=' + i + ']').css('display','none');
						}
					}else{
						//var popupText = "Изменен пароль для пользователей!<br>";
						var popupText = "Отправлено письмо изменения пароля для пользователей!<br>";

						for(var i of responseData.id){
							var userName = $ ('*[data-item-id=' + i + '] p.profile-filter__name').text();
							popupText = popupText+userName+"<br>";
						}
						$('#form-modal-save-account').find('.form-modal__name').html(popupText);
						$.fancybox.open({
							src: '#form-modal-save-account'
						});
					}
				}
			});
		}
	});

	$('.filter__body').on('click',function(event){
		//console.log ("11");
		if($($(event)[0].target)[0].type == 'checkbox'){
			var data = {};
			if(typeof($($(event)[0].target).closest('div.filter__right').data('id')) !== 'undefined'){
				data.id = $($(event)[0].target).closest('div.filter__right').data('id');
			}
			if($(event.target).data('status') == 'block'){
				data.active = $('[data-id='+data.id+']').find('.filter__input')[0].checked;
			}
			if($(event.target).data('status') == 'delete'){
				data.trash = $('*[data-item-id=' + data.id + '] .label-filter_trash input').prop("checked")
			}
			if($(event.target).data('status') == 'pass'){
				data.change_pass = $('[data-id='+data.id+']').find('.filter__change-pass')[0].checked;
				$('[data-id='+data.id+']').find('.filter__change-pass').prop('disabled',true);
			}
			if(data.id)
			{
				if($('*[data-item-id=' + data.id + '] .label-filter_trash').hasClass("blue_trash") && data.trash === false){
					data.trash = true;
				}
				data.user_type = $('.user-search__form').find('*[data-radio-name=FACE]').find('.sign_in_button.active').data('radio-val');
				console.log (data);
				$.ajax({
					type: "POST",
					url: "/ajax/profile_changes.php",
					data: data,
					dataType: "json",
					success: function (responseData) {
						console.log (responseData);
						if(responseData.trash){
							//$ ('*[data-item-id=' + responseData.id + ']').css('display','none');
							for(var i of responseData.id){
								if(!$('*[data-item-id=' + i + '] .label-filter_trash').hasClass("blue_trash") && (responseData.trash == 'true' || responseData.trash == true)){
									$('*[data-item-id=' + i + '] .label-filter_trash').addClass("blue_trash");
									$('*[data-item-id=' + i + '] .label-filter_trash input').prop("checked",true);
								}else if($('*[data-item-id=' + i + '] .label-filter_trash').hasClass("blue_trash") && (responseData.trash == 'true'|| responseData.trash == true)){
									$('*[data-item-id=' + i + '] .label-filter_trash').removeClass("blue_trash");
									$('*[data-item-id=' + i + '] .label-filter_trash input').prop("checked",false);
								}
							}
						}else if(responseData.pass == 'true'){
							$('[data-id='+responseData.id+']').find('.filter__change-pass').prop('checked',false);
							var popupText = "Отправлено письмо изменения пароля для пользователей!<br>";

							for(var i of responseData.id){
								var userName = $ ('*[data-item-id=' + i + '] p.profile-filter__name').text();
								popupText = popupText+userName+"<br>";
							}
							$('#form-modal-save-account').find('.form-modal__name').html(popupText);
							$.fancybox.open({
								src: '#form-modal-save-account'
							});
						}
					}
				});
			}
		}

	});
	//закрываем фильтр в режиме администратора при входе, иначе не корректно инициализируется select2 для селекта выбора
	//window.onload = function(){
		$('.full_filter').find('.filter_btn.active').click();
	//}

	//собираем данные с фильтра для выгрузки отчета
	$('#create_feed').on('click', function(e){
		var users = $ ('.filter').find('*[data-item-id]');
		var user_type = $ ('.user-search__form').find('*[data-radio-name=FACE]').find('.sign_in_button.active').data('radio-val');
		var data = {};
		var arUs = [];
		for(var i of users){
			arUs.push($(i).data('item-id'));
		}
		data.users = arUs;
		data.user_type = user_type;
		$.get('/ajax/create_feed.php','users='+arUs+'&user_type='+user_type, function(){
			document.location.href = '/ajax/create_feed.php?users='+arUs+'&user_type='+user_type;
		});
	})
});