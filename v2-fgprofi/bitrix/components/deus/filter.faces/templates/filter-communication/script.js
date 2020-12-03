$(document).ready(function(){
	// $(".send-check-users").click(function(){
	// 	var getData = "?user-id='";
	// 	$(this).parents(".filter").find("input[name^=select]").each(function(){
	// 		getData = getData+","+$(this).val();
	// 	});
	// 	getData = getData+","+$(this).val();
	// 	console.log(getData);
	// });
	
	$(".link-button--cansel").on("click",function(){
		$.fancybox.close();
	});
	
	// $(".send-check-users").click(function(){
	// 	var getData = "";
	// 	$(".senda a span").detach();
	// 	$(".senda a").attr("href", "");
	// 	$(this).parents(".filter").find("input[name^=select]:checked").each(function(){
	// 		getData = getData+$(this).val()+",";
	// 	});
	// 	var form = $(this).parents("form");
	// 	form.find("textarea").text(getData);
	// 	var dataForm = form.serializeArray();
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "/ajax/userEmails.php",
	// 		data: dataForm,
	// 		dataType: "html",
	// 		success: function (responseData) {
	// 			//console.log(responseData);
	// 			if(responseData != ""){
	// 				$(".senda a").attr("href", responseData);
	// 				$(".senda a").html("<span></span>");
	// 				$(".senda a span").click();
	// 			}
	// 		}
	// 	});
	// });
	$("html body").on("submit","#write-message form", function(e){
		e.preventDefault();
		var dataFormCheck = $(this).serializeArray();
		let arEr = [];
        var arErInput = [];
        var fileInput = [];
        $(this).find("input, textarea").removeClass("error");
        for (var i = dataFormCheck.length - 1; i >= 0; i--) {
            if(dataFormCheck[i]["name"] == "theme" && dataFormCheck[i]["value"] == ""){
                arEr.push("Введите тему письма");
                $(this).find("input[name="+dataFormCheck[i]["name"]+"]").addClass("error");
            }
            if(dataFormCheck[i]["name"] == "text_mail" && dataFormCheck[i]["value"] == ""){
                arEr.push("Введите текст письма");
                $(this).find("textarea[name="+dataFormCheck[i]["name"]+"]").addClass("error");
            }
        }
        
        // fileInput["name"] = "file";
        // fileInput["value"] = $('input[name=IMAGE_ID]')[0].files;
        // dataForm.push(fileInput);
        var dataForm = new FormData(this);     
        //console.log(dataForm);
        if(arEr.length == 0){
			$.ajax({
				type: "POST",
				url: "/ajax/sendMailPerson.php",
				data: dataForm,
				dataType: "html",
				contentType: false,
				processData: false,
				method: 'POST',
				success: function (responseData) {
					if(responseData != ""){
						$.fancybox.close();
						$.fancybox.open(responseData);
					}
					//console.log(responseData);
				}
			});
		}else{
			var errorStr = "";
			for (var i = arEr.length - 1; i >= 0; i--) {
				errorStr = errorStr+arEr[i]+"<br>"
			}
			$.fancybox.open(errorStr);
		}
		return false;
	});
	$(".filter").on("click", ".filter__item .filter__right .link-button", function(){
		var id = $(this).parent(".filter__right").data("id");
		var userId = [];
		var typeUser = [];
        var data = [];
        var type_user = $("input[name=FACE]:checked").val();
        userId["name"] = "id";
        userId["value"] = id;
        data.push(userId);
        typeUser["name"] = "type_user";
        typeUser["value"] = type_user;
        data.push(typeUser);
		//console.log(data);
		$.ajax({
			type: "POST",
			url: "/ajax/communication_form.php",
			data: data,
			dataType: "html",
			success: function (responseData) {
				//console.log(responseData);
				$(".communication-form-popup").html(responseData);
				$.fancybox.open({
		            src: "#write-message",
		        });
			}
		});
	});
	function multiselect_deselectAll($el) {
        // $('option', $el).each(function(element) {
        //     $el.multiSelect('deselect', $(this).val());
        // });
    }
    $(".newsletter__tab-btn-wrap").on("click", function(){
    	if($(this).hasClass("newsletter__tab-btn-wrap--individual")){
    		$(".all_user .sign_in_option .sign_in_option-item [data-radio-val=TYPE_F]").parent().trigger("click");
    	}
    	if($(this).hasClass("newsletter__tab-btn-wrap--entity")){
    		$(".all_user .sign_in_option .sign_in_option-item [data-radio-val=TYPE_U]").parent().trigger("click");
    	}
    });
    
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
		$(".filter_byFio input").val("");
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
		console.log(id);
		if(id.length != 0){
			data.id = id;
			console.log(data);
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
	//закрываем фильтр в режиме администратора при входе, иначе не корректно инициализируется select2 для селекта выбора
	//window.onload = function(){
		$('.full_filter').find('.filter_btn.active').click();
	//}
});