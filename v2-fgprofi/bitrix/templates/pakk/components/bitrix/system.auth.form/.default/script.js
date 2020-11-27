$(document).ready(function(){
	$("input[name='USER_LOGIN']").on('input paste', function(){
		var input = $(this);
		var login = $(this).val();
		var inputBox = $(this).parent(".form_input");
		var dataFace = $(".sign_in_option .sign_in_button.active").data("radio-val");
		if(dataFace == "TYPE_U"){
			$.ajax({
	            type: "GET",
	            url: "/ajax/check_ogrn.php?OGRN="+login,
	            dataType: "html",
	            success: function (responseData) {
	            	console.log(input.val().length);
	                if(responseData != ""){
	                	input.attr('placeholder', 'Логин').attr('data-min', '').inputmask("remove");
	                	input.inputmask("9999999999999-999", {
			                "placeholder": ""
			            });
	                	input.addClass("ogrnandsubdivision");
	                }
	                /*else{
	                	if(input.hasClass("ogrnandsubdivision") && input.val().length<14){
				            input.removeClass("ogrnandsubdivision");
				            input.inputmask("remove");
		                	input.attr('placeholder', 'ОГРН организации (13 цифр)').attr('data-min', '13').inputmask("9999999999999", {
				                "placeholder": ""
				            });
		                }
	                }*/
	            }
	        });
		}
	});
	// $("input[name='DATA_USER_LOGIN']").on('input', function(){
	// 	var login = $(this).val();
	// 	var inputBox = $(this).parent(".form_input");
	// 	var dataFace = $(".sign_in_option .sign_in_button.active").data("radio-val");
	// 	if(dataFace == "TYPE_U"){
	// 		$.ajax({
	//             type: "GET",
	//             url: "/ajax/check_ogrn.php?OGRN="+login,
	//             dataType: "html",
	//             success: function (responseData) {
	//                 if(responseData == ""){
	//                 	$(".dataLogin").detach();
	//                 	$(".form_input.subdivision").detach();
	//                 	$("input[name='DATA_USER_LOGIN']").attr("name", "USER_LOGIN");
	//                 }
	//             }
	//         });
	// 	}
	// });
	// $(".sign_in_option .sign_in_option-item").on("click", function(){
	// 	if($(".sign_in_option .sign_in_button.active").data("radio-val") == "TYPE_F"){
	// 		$(".dataLogin").detach();
	// 		$(".form_input.subdivision").detach();
	// 		$("input[name='DATA_USER_LOGIN']").attr("name", "USER_LOGIN");
	// 	}else{
	// 		var login = $("input[name='USER_LOGIN']").val();
	// 		var inputBox = $("input[name='USER_LOGIN']").parent(".form_input");
	// 		var dataFace = $(".sign_in_option .sign_in_button.active").data("radio-val");
	// 		if(dataFace == "TYPE_U"){
	// 			$.ajax({
	// 	            type: "GET",
	// 	            url: "/ajax/check_ogrn.php?OGRN="+login,
	// 	            dataType: "html",
	// 	            success: function (responseData) {
	// 	                if(responseData != ""){
	// 	                	dataInput = '<div class="form_input subdivision required"><input name="SUBDIVISION" type="text" value="" inputmode="text" placeholder="Код подразделения"><div class="help subdivision_description">?<div class="help-description" id="subdivision_description"><p>Код подразделения</p></div></div></div>';
	// 	                	inputBox.after(dataInput);
	// 	                	$("input[name='USER_LOGIN']").attr("name", "DATA_USER_LOGIN");
	// 	                	$(".bx-system-auth-form form").append("<input type='hidden' class='dataLogin' name='USER_LOGIN' value='"+login+"'>");
	// 	                }else{
	// 	                	$(".dataLogin").detach();
	// 	                	$(".form_input.subdivision").detach();
	// 	                	$("input[name='DATA_USER_LOGIN']").attr("name", "USER_LOGIN");
	// 	                }
	// 	            }
	// 	        });
	// 		}
	// 	}
	// });
	// $(".bx-system-auth-form form").on("input", "input[name='SUBDIVISION']", function(){
	// 	var subdivision = $(this).val();
	// 	if(subdivision != ""){
	// 		var login = $("input[name='USER_LOGIN']").val();
	// 		$("input[name='USER_LOGIN']").val(login+"-"+subdivision);
	// 	}
	// });
	// $(".sign_in").on("click", ".help.subdivision_description", function(){
	// 	$.fancybox.open({
 //            src: '#subdivision_description',
 //        });
	// });
});