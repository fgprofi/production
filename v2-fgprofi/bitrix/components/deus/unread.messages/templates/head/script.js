$(document).ready(function(){
	function getMessageReportHead(){
		let dataTemplate = [];
		let data = [];
		dataTemplate["name"] = "template";
        dataTemplate["value"] = "ajax-head";
        data.push(dataTemplate);
		$.ajax({
            type: "POST",
            url: "/ajax/supportMessages.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
            	$(".header-notification__content a").detach();
            	if(responseData != ""){
            		$(".header-notification__content").append(responseData);
            	}
            	if($(".header-notification__content a").length>0){
            		$(".header-notification__icon span").detach();
            		$(".header-notification__icon").append("<span class='header-notification__amount'>"+$(".header-notification__content a").length+"</span>");
                    $("ul li.li_count_message").append("<div class='count_message'>"+$(".header-notification__content a").length+"<div>");
            	}else{
            		$(".header-notification__icon span").detach();
                    $("ul li.li_count_message .count_message").detach();
            	}

                //console.log($(".header-notification__content a").length);
            }
        });
	}
    getMessageReportHead();
    setInterval(function() {
      getMessageReportHead();
    }, 5000);
});