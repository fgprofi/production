$(document).ready(function(){
	function getMessageReportHead(){
		let dataTemplate = [];
		let data = [];
		dataTemplate["name"] = "template";
        dataTemplate["value"] = "ajax";
        data.push(dataTemplate);
		$.ajax({
            type: "POST",
            url: "/ajax/supportMessages.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
            	if(responseData != ""){
            		$(".notification__content").html(responseData);
            	}
                //console.log(responseData);
            }
        });
	}
    // setInterval(function() {
    //   getMessageReportHead();
    // }, 5000);
    $(".notification").on("click", ".notification__item-close", function(e){
        if (typeof $(this).data("mess-type") != "undefined") {
            if($(".header-notification__icon span").is(".header-notification__amount")){
                var countMess = $(".header-notification__icon span.header-notification__amount").text();
                countMess--;
                if(countMess == 0){
                    $(".header-notification__icon span.header-notification__amount").detach();
                }else{
                    $(".header-notification__icon span.header-notification__amount").text(countMess);
                }
            }
        	let dataTicket = [];
            let data = [];
            dataTicket["name"] = "itemId";
            dataTicket["value"] = $(this).data("item-mess-id");
            data.push(dataTicket);
            var urlAjax = "/ajax/"+$(this).data("mess-type")+"MessagesClose.php";
    		$.ajax({
                type: "POST",
                url: urlAjax,
                data: data,
                dataType: "html",
                success: function (responseData) {
                	console.log(responseData);
                }
            });
            
            $(this).parents(".notification__item").detach();
        }
    });
});