$(document).ready(function(){
	$(".audience-popup__content .audience-popup__item").on("click", function(){
		$(".audience-popup__content .audience-popup__item").removeClass("checked");
		$(this).addClass("checked");
	});
	$(".audience-popup__btns .link-button.select-item").on("click", function(){
		var data = [];
		var auditId = [];
        auditId["name"] = "audit";
        auditId["value"] = $(".audience-popup__content .audience-popup__item.checked").data("id");
        data.push(auditId);
        var users = [];
        users["name"] = "users";
        users["value"] = $("textarea[name=users]").val();
        data.push(users);
		$.ajax({
			type: "POST",
			url: "/ajax/getUsersByIdAudit.php",
			data: data,
			dataType: "json",
			success: function (responseData) {
				var usersId = "";
				var usersEmail = "";
				var usersName = "";
				var usersHtml = "";
				for (var i = responseData.length - 1; i >= 0; i--) {
					usersId = usersId+responseData[i]["ID"]+",";
					usersEmail = usersEmail+responseData[i]["PROPERTY_EMAIL_VALUE"]+",";
					usersName = usersName+responseData[i]["NAME"]+",";
					usersHtml = usersHtml+'<div class="newsletter__form-whom-edit-item" data-user-id="'+responseData[i]["ID"]+'" data-user-email="'+responseData[i]["PROPERTY_EMAIL_VALUE"]+'">'+responseData[i]["NAME"]+' </div>';
				}
				usersId = usersId.slice(0,-1);
				usersEmail = usersEmail.slice(0,-1);
				usersName = usersName.slice(0,-1);
				$("textarea[name=users]").text(usersId);
				$("textarea[name=emails]").text(usersEmail);
				$(".newsletter__form-label--whom span").text(usersName);
				$(".newsletter__form-whom-edit").html(usersHtml);
				// console.log(usersId);
				// console.log(usersEmail);
				// console.log(usersName);
				// console.log(usersHtml);
				$.fancybox.close();
			}
		});
		//window.location.href = "/admin/subscribe/mailer/send/"+id+"/";
	});
});