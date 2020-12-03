$(document).ready(function () {
	function showChecksTA() {
		var isPS = false;
		$('.TARGET_AUDIENCE_variants input').each(function () {
			if ($(this).val() == "Профессиональное сообщество") {
				isPS = true;
				$(this).parents(".multi_field_text_input").appendTo($(".TARGET_AUDIENCE_variants"));
				//$(this).parents(".multi_field_text_input").detach();
			}
		});
		if (!isPS) {
			$(".tg_check_group").removeClass("active");
			$(".tg_check_group input").prop('checked', false);
		}
		if (!$(".tg_check_group").hasClass("active") && isPS) {
			$(".tg_check_group").addClass("active");
		}
	}

	$('select[name="TARGET_AUDIENCE"]').on('change', function (event) {
		showChecksTA();
	});
	$('.TARGET_AUDIENCE_variants').on('click', ".remove-field", function (event) {
		setTimeout(function () {
			showChecksTA();
		}, 200);
	});
	$(".edit_profile_btn .button-red").click(function (e) {
		e.preventDefault();
		var profId = $("input[name=PROFILE_ID]").val();
		$('#form-success-del').html("Вы точно хотите удалить учетную запись?<br><div class='button-green form-success-del-btn' data-profile-id='" + profId + "'>Да</div>");
		$.fancybox.open({
			src: '#form-success-del'
		});
	});
	$('html body').on('click', '.form-success-del-btn', function () {
		var data = {};
		data.id = $(this).data("profile-id");
		data.ib = $("input[name=PROFILE_IB]").val();
		$.ajax({
			type: "GET",
			url: "/ajax/profile_changes_del.php",
			data: data,
			dataType: "html",
			success: function (responseData) {
				console.log(responseData);
				$.fancybox.close();
				$('#form-success-del').html('Профиль удален!');
				$.fancybox.open({
					src: '#form-success-del'
				});
			}
		});
	});
	$(".cabinet-user__load-photo .remove_photo").click(function () {
		let data = [{
			"name": "PROFILE_ID",
			"value": $(".personal_logo .add_file form input[name=PROFILE_ID]").val()
		}, {
			"name": "IBLOCK_ID",
			"value": $(this).data("ib")
		}];
		$.ajax({
			type: "GET",
			url: "/ajax/delete_photo.php",
			data: data,
			dataType: "html",
			success: function (responseData) {
				$(".cabinet-user__load-photo_box.no_logo").detach();
				$(".cabinet-user__load-photo").append(responseData);
				$(".cabinet-user__load-photo .remove_photo").addClass("hide");
				//$(".webform-field-upload-list.webform-field-upload-list-single").html("");
				//$(".cabinet-user__load-photo").removeClass("check_logo");
				//$(".cabinet-user__load-photo.check_logo").css("background", "");
			}
		});
	});

	function editProfile(data) {
		console.log(data);
		$.ajax({
			type: "POST",
			url: "/ajax/edit_profile.php",
			data: data,
			dataType: "html",
			success: function (responseData) {
				console.log(responseData);
				$(".result").html("");
				$(".result").html(responseData);
			}
		});
		//console.log(data);
		$.fancybox.open({
			src: '#form-modal-save-account',
		});
		return true;
	}

	function checkFields(fields, requered) {
		var error = '';
		var arEr = [];
		var errorEl = '';
		
		requered.find('*[required]').each(function () {
			var el = $(this).val();
			var parent = $(document.getElementsByName($(this)[0].name)).parent('div');

			if ($(this)[0].type == 'checkbox') {
				if ($(this)[0].checked)
					el = 'true';
				else
					el = '';
			}
			/*if ($(this)[0].type == 'select-one' || $(this)[0].type == 'select') {
				if ($(this)[0].selectedOptions.length > 0)
					el = 'true';
				else
					el = '';
			}*/
			if ($(this)[0].type == 'select-one' || $(this)[0].type == 'select') {
				if ($(this)[0].selectedOptions.length > 0){
					el = 'true';
					if($(this).val() == ""){
						el = '';
					}
				}else{
					el = '';
				}
				if($(this).parents("#PROPERTY_"+this.name).find("."+this.name+"_variants input").length > 0 && !$(this).parents("#PROPERTY_"+this.name).find("."+this.name+"_variants input").hasClass(this.name+"_empty")){
					el = 'true';
				}
				//console.log($(this).parents("#PROPERTY_"+this.name).find("."+this.name+"_variants input").length);
				// console.log($(this).val());	
			}

			// если поле пустое
			if ($(this).attr("name") == "PROPERTY_EMAIL") {
				let login = $(this).val();
		        let result = login.match(/(@ya\.)/);
		        if(result !== null){
		            let correctLogin = login.replace(/(@ya\.)/, "@yandex.");
		            $(this).val(correctLogin);
		            $.fancybox.open("<div>Необходимо полностью писать домен сервера почтового ящика<br>Почта "+login+" заменена на "+correctLogin+"</div>");
					el = '';
				}
			}
			if ($(this).attr("name") == "PROPERTY_OGRN" && $(this).val().length < 13) {
				el = '';
			}
			if ($(this).attr("name") == "PROPERTY_INN" && $(this).val().length < 10) {
				el = '';
			}
			if (el == '') {
				parent.removeClass('valid');
				parent.addClass('error');
				error = 'error';
				var inputName = this.name;
				if($(".input_box").is("#PROPERTY_"+inputName)){
					inputName = "PROPERTY_"+inputName;
				}
				arEr.push(inputName);
				if(errorEl == ''){
					errorEl = $(this);
				}
			} else {
				parent.removeClass('error');
				parent.addClass('valid');
			}
		});
		// console.log(arEr);	
		// return arEr;
		if (error){
			if(!errorEl.closest(".groop_field").find(".groop_field_title").hasClass("active")){
				errorEl.closest(".groop_field").find(".groop_field_title").click();
			}
			return arEr;
		}else{
			return 'ok';
		}
	}

	function checkReqFieldGroop() {

	}
	//проверка поля на ввод данных
	$('.groop_field_box').on('input', function (event) {
		//console.log($(event.target).attr("required"));
		var parent = $(event.target).parent('div');
		var required = parent.data('required');
		if ($(event.target).attr("required") == "required" && parent.attr('class').indexOf('error') >= 0) {
			parent.removeClass('error');
			parent.addClass('valid');
		}
		if ($(event.target).attr("required") == "required" && event.target.value == '') {
			parent.removeClass('valid');
			parent.addClass('error');
		}
	});


	// $(".btn_form_send").click(function(e){
	// 	editProfile($(this));
	// });

	if ($(window).width() > 768) {
		$(".groop_field_box .help").hover(function () {
			$(this).toggleClass("active");
		});
	}
	if ($(window).width() < 768) {
		$(".groop_field_box .help").on('click', function (e) {
			$(this).toggleClass("active");

		});
	}

	$(".cabinet-block-form-form .button-green").click(function (e) {
		e.preventDefault();
		var dataForm = $(this).parents("form").serializeArray();
		var formRequiredFields = $('.js-form-validate');
		var res = checkFields(dataForm, formRequiredFields);
		if (res == 'ok') {
			editProfile(dataForm);
			return false;
		} else {
			var top = $('#' + res[0]).offset().top - 300;
			$('html, body').animate({
				scrollTop: top
			}, 2000);
		}
		// console.log(dataForm);
	});

	//маски
	$(function ($) {
		$('.date').mask('99.99.9999');
		$('.phone').mask("+7 (999) 999-99-99");
		// $('.email').mask({mask:"[AA]-[A|9]{2}-[99]"});
	});

	$(".send-photo").click(function () {
		var form = $(this).parents("form");
		var data = form.serializeArray();
		$.ajax({
			type: "POST",
			url: "/ajax/save_photo.php",
			data: data,
			dataType: "json",
			success: function (responseData) {
				console.log("1");
				$(".remove_photo").removeClass("hide");
			}
		});

		//.submit();
	});

	$('.admin-block .admin_select_change').on('change', function (event) {
		var data = {};
		data.id = $('.admin-block').data('id');
		if ($(event.target)[0].name == 'moderator')
			data.moderator = $(event.target).val();

		if ($(event.target)[0].name == 'active')
			data.active = $(event.target).val();

		if ($(event.target)[0].name == 'trash')
			data.trash = $(event.target).val();

		if ($(event.target)[0].name == 'PROOF_MINFIN'){
			data.checkmf = "0";
			if ($("#PROOF_MINFIN_CHECK").is(':checked')) {
				data.checkmf = $(event.target).val();
			}
		}
		console.log(data);
		$.ajax({
			type: "POST",
			url: "/ajax/profile_changes.php",
			data: data,
			dataType: "json",
			success: function (responseData) {
				console.log(responseData);
				$('#form-modal-save-account').find('.form-modal__name').html('Данные обновлены');
				$.fancybox.open({
					src: '#form-modal-save-account'
				});
				if (responseData.moderator == 10) {
					document.location.href = responseData.redirect
				}
			}
		});
	})

	$('#change_pass').on('click', function (event) {
		var data = {};
		data.change_pass = 'true';
		data.id = $(event.target)[0].name;
		$.ajax({
			type: "POST",
			url: "/ajax/profile_changes.php",
			data: data,
			dataType: "json",
			success: function (responseData) {
				$('#form-modal-save-account').find('.form-modal__name').html('Данные обновлены');
				$.fancybox.open({
					src: '#form-modal-save-account'
				});
			}
		});
	})

	$('.save_comment').on('click', function (event) {
		event.preventDefault();
		var dataForm = $(this).parents("form").serializeArray();
		var data = {};
		data.internal_comment = dataForm[0].value;
		data.id = $(event.target)[0].name;
		$.ajax({
			type: "POST",
			url: "/ajax/profile_changes.php",
			data: data,
			dataType: "json",
			success: function (responseData) {
				$('#form-modal-save-account').find('.form-modal__name').html('Данные обновлены');
				$.fancybox.open({
					src: '#form-modal-save-account'
				});
			}
		});
	})
	//закидываем сообщение о не заполнении обязательного поля
	// $('*[required]').each(function(){
	// 	$(this).on('input',function(event){
	// 		var curClass = $('.required_fields_check').find('.'+$ (this)[0].name.replace('PROPERTY_',''));
	// 		if($(event.currentTarget)[0].required && $(this).val() == ''){
	// 			curClass.removeClass('sidebar__item_valid').addClass('sidebar__item_error');
	// 		}else if($(event.currentTarget)[0].required && $(this).val() !== '' && curClass.hasClass('sidebar__item_error')){
	// 			curClass.removeClass('sidebar__item_error').addClass('sidebar__item_valid');
	// 		}
	// 	})
	// });
	// $('*[required]').on('input',function(event){
	// 	var groopFieldBox = $(this).parents(".groop_field_box");
	// 	var reqInputs = groopFieldBox.find("*[required]");
	// 	var groopValid = true;
	// 	var curClass = $('.required_fields_check').find('.'+$ (this)[0].name.replace('PROPERTY_',''));
	// 	reqInputs.each(function(){
	// 		if($(this).val() == ""){
	// 			groopValid = false;
	// 		}
	// 	});
	// 	if(groopValid){
	// 		curClass.removeClass('sidebar__item_error').addClass('sidebar__item_valid');
	// 	}else{
	// 		curClass.removeClass('sidebar__item_valid').addClass('sidebar__item_error');
	// 	}
	// });

});