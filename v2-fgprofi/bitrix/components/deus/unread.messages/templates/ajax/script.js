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
    setInterval(function() {
      getMessageReportHead();
    }, 5000);
});