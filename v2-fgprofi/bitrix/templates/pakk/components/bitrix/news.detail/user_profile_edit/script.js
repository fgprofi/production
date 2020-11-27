$(document).ready(function(){
	function editProfile(btn){
		var form = btn.parent("form");
		var data = form.serializeArray();
		$.ajax( {
		    type: "POST",
		    url: "/ajax/edit_profile.php",
		    data: data,
		    dataType: "html",
		    success: function( responseData ) {
		    	//console.log(responseData);
		    	$(".result").html("");
		    	$(".result").html(responseData);
		    }
		});
		//console.log(data);
		alert('Профиль сохранен!');
		return false;
	}
	$(".btn_form_send").click(function(e){
		editProfile($(this));
	});
});