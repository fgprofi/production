$(document).ready(function(){
	function updateURL(param) {
	    if (history.pushState) {
	        var baseUrl = window.location.protocol + "//" + window.location.host + '/freg/';
	        var newUrl = baseUrl+param+"/";
	        history.pushState(null, null, newUrl);
	    }
	    else {
	        console.warn('History API не поддерживается');
	    }
	}
	$("input[name='REGISTER[EMAIL]']").on('input paste', function(){
		var login = $(this).val();
		var inputBox = $(this).parent(".form_input");
		var dataFace = $(this).parents("form").find("input[name='FACE']:checked").val();
		$("input[name='REGISTER[LOGIN]']").val(login);
		if(dataFace == "TYPE_U"){
			var subdivision = $("input[name='SUBDIVISION']").val();
			$("input[name='REGISTER[LOGIN]']").val(login+"-"+subdivision);
			$.ajax({
	            type: "GET",
	            url: "/ajax/check_ogrn.php?OGRN="+login,
	            dataType: "html",
	            success: function (responseData) {
	            	console.log(responseData);
	                if(responseData != ""){
	                	dataInput = '<div class="form_input subdivision required"><div>Юридическое лицо с таким ОГРН уже существует, профиль будет зарегистрирован как подказделение.</div></div>';
	                	inputBox.after(dataInput);
	                }else{
	                	//console.log(login);
	                	$(".form_input.subdivision").detach();
	                	//$("input[name='REGISTER[LOGIN]']").val(login);
	                }
	            }
	        });
		}
	});
	$("input[name='FACE']").on('change', function(){
		var valueField = $(this).val();
		$(".face_field").toggleClass("hidden_field");
		param = valueField.toLowerCase();
		updateURL(param);
		$("form[name=regform]").attr("action", "/freg/"+param+"/");
	});
	$(".form_title_reg .help").click(function(){
		$.fancybox.open({
            src: '#form_title_reg_description',
        });
	});
	// $("form[name=regform]").on("click", ".help.subdivision_description", function(){
	// 	$.fancybox.open({
 //            src: '#subdivision_description',
 //        });
	// });
	$(".help.password_reg_description").click(function(){
		$.fancybox.open({
            src: '#password_reg_description',
        });
	});
	
	$(".sign_in_alert span").click(function(){	
		$.fancybox.open({
            src: '#sign_in_alert_text',
        });
	});
	$(".bx-auth-reg form").submit(function(){
		// var login = $(this).find('input[name="REGISTER[EMAIL]"]').val();
		// console.log(login);
		// return false;
		// $("#password").removeClass("error");
		// var successForm = true;
		// if(!$("#pwdMeter").hasClass("verystrong")){
		// 	successForm = false;
		// 	$("#pwdMeter").addClass("1");
		// }
		// if(!successForm){
		// 	if($("#pwdMeter").hasClass("strong")){
		// 		successForm = true;
		// 		$("#pwdMeter").addClass("3");
		// 	}
		// 	$("#pwdMeter").addClass("2");
		// }
		// $("#pwdMeter").addClass("4_"+successForm);
		// if(!successForm){
		// 	$("#password").addClass("error");
		// 	$.fancybox.open({
	 //            src: '#password_reg_description',
	 //        });
		// }
		// $("#password").removeAttr("disabled");
		// var pass = $('input[name="REGISTER[PASSWORD]"]').val();
		// var confirmPass = $('input[name="REGISTER[CONFIRM_PASSWORD]"]').val();
		// $('input[name="REGISTER[CONFIRM_PASSWORD]"]').removeClass("error");
		// if(confirmPass != pass){
		// 	$('input[name="REGISTER[CONFIRM_PASSWORD]"]').addClass("error");
		// 	successForm = false;
		// }
		// return successForm;
	});
	
    $("#password").pwdMeter();
});