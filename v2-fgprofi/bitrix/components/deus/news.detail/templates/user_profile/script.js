$(document).ready(function(){
	$(".close_mess").click(function(){
		let data = [];
		let user = [];
        user["name"] = "face";
        user["value"] = $(this).data("user-id");
        data.push(user);
		$.ajax({
            type: "POST",
            url: "/bitrix/components/deus/news.detail/templates/user_profile/close_message.php",
            data: data,
            success: function (responseData) {
            	console.log(responseData);
            	$(".state-account_success").detach();
            }
        });
	});
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
    $(".account__info").on("click", ".write-message-btn", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var type_user = $(this).data("ib-id");
        var userId = [];
        var typeUser = [];
        var data = [];
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
});