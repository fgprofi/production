function tabActivator(hash){
    $("a.sidebar__link-tab[href$='"+hash+"']").parent("div").find("a.sidebar__link-tab").removeClass("active");
    $("a.sidebar__link-tab[href$='"+hash+"']").addClass("active");
    $(hash).find("div").click();
}
function popupActivator(hash){
    $(hash).find("span").click();
}
function psuedoClick(parentElem) {

    var beforeClicked,
      afterClicked;

  var parentLeft = parseInt(parentElem.getBoundingClientRect().left, 0),
      parentTop = parseInt(parentElem.getBoundingClientRect().top, 0);

  var parentWidth = parseInt(window.getComputedStyle(parentElem).width, 0),
      parentHeight = parseInt(window.getComputedStyle(parentElem).height, 0);

  var before = window.getComputedStyle(parentElem, ':before');

  var beforeStart = parentLeft + (parseInt(before.getPropertyValue("left"), 10)),
      beforeEnd = beforeStart + parseInt(before.width, 10);

  var beforeYStart = parentTop + (parseInt(before.getPropertyValue("top"), 10)),
      beforeYEnd = beforeYStart + parseInt(before.height, 10);

  var after = window.getComputedStyle(parentElem, ':after');

  var afterStart = parentLeft + (parseInt(after.getPropertyValue("left"), 0)),
      afterEnd = afterStart + parseInt(after.width, 16);

  var afterYStart = parentTop + (parseInt(after.getPropertyValue("top"), 0)),
      afterYEnd = afterYStart + parseInt(after.height, 24);

  var mouseX = event.clientX,
      mouseY = event.clientY;

  beforeClicked = (mouseX >= beforeStart && mouseX <= beforeEnd && mouseY >= beforeYStart && mouseY <= beforeYEnd ? true : false);

  afterClicked = (mouseX >= afterStart && mouseX <= afterEnd && mouseY >= afterYStart && mouseY <= afterYEnd ? true : false);

  return {
    "before" : beforeClicked,
    "after"  : afterClicked

  };      

}
window.onhashchange = function() { 
    var hash = window.location.hash;
    if(hash != ""){
        if(hash.indexOf('#tab-') == 0){
            tabActivator(hash);
        }
        if(hash.indexOf('#popup-') == 0){
            popupActivator(hash);
        }
    }
}
$(document).mouseup(function (e){
    var div = $(".selector-open");
    if ($("input").is(".selector-open") && !div.is(e.target)) {
        div[0].checked = false;
        var form = div.parents("form");
        div.removeClass("selector-open"); 
    }

    var headerPopup = $(".header-login__drop *");
    if (!headerPopup.is($(e.target)) && !$(e.target).closest(".show-header-min-box").hasClass("active-header-min-box")) {
        $(".header-login__drop").slideUp(); 
        $(".show-header-min-box").removeClass("active-header-min-box");
    }
});
$(document).ready(function () {
    $(".save-audience-popup").on("click",function(e){
        var getData = "";
        $(".newsletter__tab-content.active .filter__body input[name^=select]:checked").each(function(){
            getData = getData+$(this).val()+",";
        });
        //console.log(getData);
        if(getData == ""){
            e.preventDefault();
            $.fancybox.open({
                src: "#none-users-popup",
            });
        }
        $("#save-audience form textarea[name=audience-users]").text(getData);
    });
    $("#none-users-popup .none-users-popup-btn .button-green").on("click", function(){
        $.fancybox.close();
    });
    $(".form-file-wrap input[type=file]").on("change", function(){
        // var valInput = $(this).val();
        // var valInputArray = valInput.split("\\");
        
        if(!$("form .newsletter__form-group--file").find(".newsletter__form-file").hasClass("active")){
            $("form .newsletter__form-group--file").find(".newsletter__form-file").addClass("active");
        }
        //upload-file-name
        
        // setTimeout(setFileName, 1000);
    });
    $(".newsletter__form-file").on("click", function(){
        $(this).parents(".newsletter__form-group--file").find(".form-file-wrap .webform-button-replace").trigger("click");
        $(".form-file-wrap").show();
    });
    var date = new Date();
    /* Локализация datepicker */
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: 'Предыдущий',
        nextText: 'Следующий',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $('.datepicker-cron-time').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        dynamic: true,
        dropdown: true,
        scrollbar: false,
        // change: function(date){
        //     $(".request-datepicker-time").text(date);
        //     $("input[name=time-cron]").val(date);
        //     $(".datepicker-cron-time").fadeToggle();
        // }
    });
    $(".newsletter__form-trash-wrap").on("click", function(e){
        e.preventDefault();
        var itemId = $(this).data("id");
        var popupId = "#success-delete-popup";
        if(typeof $(this).data("back") != "undefined" && $(this).data("back") == "true"){
            var back = $(this).data("back");
            $(popupId).data("back", back);
        }
        //console.log(itemId);
        $(popupId).data("id", "");
        $.fancybox.open({
            src: popupId,
        });
        $(popupId).data("id", itemId);
    });
    $(".newsletter__form-btns .link-button--cansel").on("click", function(e){
        e.preventDefault();
        document.location.reload(true);
    });
    // $(".newsletter__form-btns .newsletter__form-trash-wrap .newsletter__form-trash").on("click", function(e){
    //     e.preventDefault();
    //     window.location.href = "/admin/subscribe/mailer/";
    //     $('.newsletter__form-trash-wrap').unbind();
    // });
    $(".save-template__btns .link-button--cansel").on("click", function(e){
        e.preventDefault();
        $.fancybox.close();
    });
    
    /*$(".on_before_submit_mailer").on("submit", function(e){
        var dataForm = $(this).serializeArray();
        $(".newsletter__form-group").removeClass("error");
        let arEr = [];
        var arErInput = [];
        var emails = false;
        var rubric = false;
        //console.log(dataForm);
        for (var i = dataForm.length - 1; i >= 0; i--) {
            if((dataForm[i]["name"] == "users" && dataForm[i]["value"] != "") || (dataForm[i]["name"] == "custom-mail" && dataForm[i]["value"] != "")){
                emails = true;
            }
            if(dataForm[i]["name"] == "title-mail" && dataForm[i]["value"] == ""){
                arEr.push("Введите заголовок письма");
                $(".on_before_submit_mailer").find(".newsletter__form-group:eq(1)").addClass("error");
            }
            if(dataForm[i]["name"] == "list" && dataForm[i]["value"] != ""){
                rubric = true;
            }
            if(dataForm[i]["name"] == "TEXT_MAIL" && dataForm[i]["value"] == ""){
                arEr.push("Введите текст письма");
                $(".on_before_submit_mailer").find(".newsletter__form-group:eq(3)").addClass("error");
            }
        }
        if(!emails){
            arEr.push("Нет получателей письма");
            $(".on_before_submit_mailer").find(".newsletter__form-group:eq(0)").addClass("error");
        }
        if(!rubric){
            arEr.push("Выберите рубрику");
            $(".on_before_submit_mailer").find(".newsletter__form-group:eq(2)").addClass("error");
        }
        if(arEr.length > 0){
            var errorPopup = "";
            for (var i = arEr.length - 1; i >= 0; i--) {
                errorPopup = errorPopup+arEr[i]+"<br>";
            }
            $.fancybox.open(errorPopup);
            return false;
        }

    });*/
    $(".on_before_submit_mailer").on("submit", function(e){
        var form = $(this);
        form.find(".error_after_input").detach();
        var dataForm = form.serializeArray();
        $(".newsletter__form-group").removeClass("error");
        let arEr = [];
        var arErInput = [];
        var emails = false;
        var rubric = false;
        //console.log(dataForm);
        for (var i = dataForm.length - 1; i >= 0; i--) {
            if((dataForm[i]["name"] == "users" && dataForm[i]["value"] != "") || (dataForm[i]["name"] == "custom-mail" && dataForm[i]["value"] != "")){
                emails = true;
            }
            if(dataForm[i]["name"] == "title-mail" && dataForm[i]["value"] == ""){
                arEr.push("Введите заголовок письма");
                $(".on_before_submit_mailer").find(".newsletter__form-group:eq(1)").addClass("error");
            }
            if(dataForm[i]["name"] == "list" && dataForm[i]["value"] != ""){
                rubric = true;
            }
            if(dataForm[i]["name"] == "TEXT_MAIL" && dataForm[i]["value"] == ""){
                arEr.push("Введите текст письма");
                $(".on_before_submit_mailer").find(".newsletter__form-group:eq(3)").addClass("error");
            }
        }
        if(!emails){
            arEr.push("Нет получателей письма");
            $(".on_before_submit_mailer").find(".newsletter__form-group:eq(0)").addClass("error");
        }
        if(!rubric){
            arEr.push("Выберите рубрику");
            $(".on_before_submit_mailer").find(".newsletter__form-group:eq(2)").addClass("error");
        }
        if(arEr.length > 0){
            var errorPopup = "";
            for (var i = arEr.length - 1; i >= 0; i--) {
                errorPopup = errorPopup+arEr[i]+"<br>";
            }
            //$.fancybox.open(errorPopup);
            if(!form.find(".error_after_input").length){
                form.prepend("<div class='error_after_input'>"+errorPopup+"</div>");
            }
            return false;
        }

    });
    $(".save-template__form").on("submit", function(e){
        e.preventDefault();
        var dataTemplate = $(".newsletter__form").serializeArray();
        var dataTitle = $(this).serializeArray();
        var data = dataTitle.concat(dataTemplate);
        $.ajax({
            type: "POST",
            url: "/ajax/save-template.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                //console.log(responseData);
                $.fancybox.close();
                window.location.href = "/admin/subscribe/mailer/send/"+responseData+"/";
                //document.location.reload(true);
            }
        });
    });
    $(".newsletter__form-calendar-popup .select-time-open").on("click", function(){
        $(this).hide();
        $(this).parents(".newsletter__form-calendar-popup").find(".select-time").show();
        $(this).parents(".newsletter__form-calendar-popup").find(".select-time input").prop('disabled', (i, v) => !v);
    });
    
    $(".newsletter__form-calendar-popup .select-time-close").on("click", function(){
        $(this).parents(".select-time").hide();
        $(this).parents(".newsletter__form-calendar-popup").find(".select-time-open").show();
        $(this).parents(".select-time").find("input").prop('disabled', (i, v) => !v);
    });
    $("input.datepicker-cron-time").val((date.getHours()+1)+":00");
    $(".request-datepicker").click(function(){
        $(".datepicker-cron").fadeToggle();
    });
    $(".request-datepicker-time").click(function(){
        $(".datepicker-cron-time").fadeToggle();
    });
    
    $(".datepicker-cron").datepicker({
        onSelect: function(date){
            $(".request-datepicker").text(date);
            $("input[name=date-cron]").val(date);
            $(".datepicker-cron").fadeToggle();
        }
    });
    // $("#datepicker").datepicker({
    //     onSelect: function(date){
    //         $('#datepicker_value').val(date)
    //     }
    // });
    $(".main-content.newsletter-write").on("click", ".newsletter__form-whom-edit-item", function() {
        if(psuedoClick(this).after){
            $(this).detach();
            var newNameList = "";
            var newIdList = "";
            var newEmailList = "";
            $(".newsletter__form-whom-edit .newsletter__form-whom-edit-item").each(function(){
                newNameList = newNameList+$(this).text()+" ,";
                newIdList = newIdList+$(this).data("user-id")+" ,";
                newEmailList = newEmailList+$(this).data("user-email")+" ,";
            });
            newNameList = newNameList.slice(0, -2);
            newIdList = newIdList.slice(0, -2);
            newEmailList = newEmailList.slice(0, -2);
            $(".newsletter__form-label.newsletter__form-label--whom span").text(newNameList);
            $("textarea[name=users]").val(newIdList);
            $("textarea[name=emails]").val(newEmailList);
            $("textarea[name=users]").text(newIdList);
            $("textarea[name=emails]").text(newEmailList);
            // console.log(newIdList);
            // console.log(newEmailList);
        }
    });
    $(".unregister-support-popup").on("click", function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/ajax/support_form.php",
            data: "",
            dataType: "html",
            success: function (responseData) {
                //console.log(responseData);
                $(".support-form-popup").html(responseData);
                $.fancybox.open({
                    src: "#support-message",
                });
                $("input.phone_mask").inputmask("+7 (999)-999-99-99", {
                    //"placeholder": ""
                });
            }
        });
    });
    /*$("html body").on("submit", "#support-message form", function(e){
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "POST",
            url: "/ajax/support_addTicked.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                $(".support-message-error").detach();
                if(responseData != "1"){
                    //$("#support-message form").prepend("");
                    $.fancybox.open("<div class='support-message-error'>"+responseData+"</div>");
                }else{
                    $.fancybox.close();
                    $.fancybox.open('<div id="success-message" class="success-message"><img src="/bitrix/templates/pakk/img/message-success.png" alt="Обращение создано" class="success-message__img"><p class="success-message__text">Обращение создано</p></div>');
                }
                //console.log(responseData);
            }
        });
    });*/
    $("html body").on("submit", "#support-message form", function(e){
        e.preventDefault();
        var form = $(this);
        form.find(".error_after_input").detach();
        var data = form.serializeArray();
        $.ajax({
            type: "POST",
            url: "/ajax/support_addTicked.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                $(".support-message-error").detach();
                if(responseData != "1"){
                    //$("#support-message form").prepend("");
                    if(!form.find(".error_after_input").length){
                        form.prepend("<div class='error_after_input'>"+responseData+"</div>");
                    }
                    //$.fancybox.open("<div class='support-message-error'>"+responseData+"</div>");
                }else{
                    $.fancybox.close();
                    $.fancybox.open('<div id="success-message" class="success-message"><img src="/bitrix/templates/pakk/img/message-success.png" alt="Обращение создано" class="success-message__img"><p class="success-message__text">Обращение создано</p></div>');
                }
                //console.log(responseData);
            }
        });
    });
    $("#success-delete-popup .success-delete-popup-btn").on("click", function(e){
        e.preventDefault();
        var inputName = [];
        var data = [];
        var itemId = $(this).parents("#success-delete-popup").data("id");
        var listDelete = false;
        if($("a").hasClass("item-"+itemId)){
            listDelete = true;
        }
        console.log(listDelete);
        inputName["name"] = "id";
        inputName["value"] = itemId;
        data.push(inputName);
        var btn = $(this);
        // console.log($(this).parents("#success-delete-popup").data("back"));
        // if(typeof $(this).parents("#success-delete-popup").data("back") != "undefined" && $(this).parents("#success-delete-popup").data("back") == true){
        //     window.location.href = "/admin/subscribe/mailer/";
        //     console.log($(this).parents("#success-delete-popup").data("back"));
        // }else if(listDelete){
        //     $("#item-"+itemId).detach();
        // }else{
        //     //document.location.reload(true);
        // }
        $.ajax({
            type: "POST",
            url: "/ajax/delete_element.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                //console.log(btn.parents("#success-delete-popup").data("back"));
                $.fancybox.close();
                if(typeof btn.parents("#success-delete-popup").data("back") != "undefined" && btn.parents("#success-delete-popup").data("back") == true){
                    window.location.href = "/admin/subscribe/mailer/";
                    //console.log($(this).parents("#success-delete-popup").data("back"));
                }else if(listDelete){
                    $("#item-"+itemId).detach();
                }else{
                    //document.location.reload(true);
                }
            }
        });
    });
    $(".input_box.checkbox.disabled_check").click(function (e) {
        e.preventDefault();
    });
    $(".webform-field-upload span").click(function () {
        $(this).parent().find("input").click();
    });
    $(".logout_href").click(function (e) {
        e.preventDefault();
        $.fancybox.open({
            src: '#logout-popup',
        });
    });
    function startMailingFilter(form){
        var data = form.serializeArray();
        //console.log(data);
        var action = form.attr("action");
        $.ajax({
            type: "POST",
            url: action,
            data: data,
            dataType: "html",
            success: function (responseData) {
                
                $(".newsletter__tab-content.active .newsletter__content").html("");
                $(".newsletter__tab-content.active .newsletter__content").html($(responseData).children());
            }
        });
    }
    // $(".newsletter__form .rubricator-select").on("click", function(){
    //     if($(this).find(".rubricator-input").prop("checked") && !$(this).find(".rubricator-input").hasClass("selector-open")){
    //         console.log($(this).find(".rubricator-input").hasClass("selector-open"));
    //         $(this).find(".rubricator-input").addClass("selector-open");

    //     }
    // });


    $('html body').on('click', '.rubricator-select', function () {
        $(this).find('.rubricator-items').toggle();
        $(this).toggleClass('active');
    });


    $('html body').on('click', '.rubricator-items__option',function () {
        $(this).closest('.rubricator-select').find('.rubricator-title').text($(this).text());
        $(this).closest('.rubricator-select').find('.rubricator-input').prop('checked', true);
        $(this).closest('.rubricator-select').find('.rubricator-input').val($(this).attr('data-value'));
        $(this).closest('.rubricator-select').find('.rubricator-input').trigger("input");
    });

    $(document).on('click', function(e) {
        if (!$(e.target).parents().addBack().is('.rubricator-select')) {
          $('.rubricator-items').hide();
        }

        if ($('.rubricator-items').is(':visible')) {
            $('.rubricator-select').addClass('active')
        } else {
            $('.rubricator-select').removeClass('active');
        }

      });


    $("input[name=users_search]").on("input", function(){
        let data = {};
        data.search = $(this).val();
        data.ib = $("input[name=users_ib]").val();
        $.ajax({
            type: "POST",
            url: "/ajax/add_userByFio.php",
            data: data,
            dataType: "json",
            success: function (responseData) {
                console.log(responseData);
            }
        });
    });
    $(".mailing-filter .newsletter__form input").on("input", function(){
        // if($(this).hasClass("rubricator-input") && $(this).prop("checked")){
        //     return;
        // }
        var form = $(this).parents("form");
        startMailingFilter(form);
    });

    // $(".mailing-filter .newsletter__tab-btn-wrap").on("click", function(){
    //     function startFilterTab() {
    //         var form = $(".mailing-filter .newsletter__tab-content.active form.newsletter__form");
    //         startMailingFilter(form);
    //     }
    //     setTimeout(startFilterTab, 100);
    // });

    $(".mailing-template .rubricator-select input, .mailing-template input[name=mailing-template-text]").on("input", function(){
        var data = $(this).parents(".mailing-template").serializeArray();
        console.log(data);
        // if($(this).hasClass("selector-open")){
        //     return false;
        // }
        $.ajax({
            type: "POST",
            url: "/ajax/mailing-template-filter.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                $(".newsletter__tab-content.active .newsletter__content").html("");
                $(".newsletter__tab-content.active .newsletter__content").html($(responseData).find("a.newsletter__item.newsletter__item--template"));
            }
        });
    });
    $(".mailing-archive .rubricator-select input, .mailing-archive input[name=mailing-archive-text]").on("input", function(){
        var data = $(this).parents(".mailing-archive").serializeArray();
        $.ajax({
            type: "POST",
            url: "/ajax/mailing-archive-filter.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                
                $(".newsletter__tab-content.active .newsletter__content").html("");
                $(".newsletter__tab-content.active .newsletter__content").html($(responseData).find(".newsletter__date"));
            }
        });
    });
    function checkValidGroup(target) {
        var parent = target.parents('.groop_field_box');
        var groupValid = true;
        var groupNum = $('.groop_field_box').index(parent);
        parent.find("select, input, textarea").each(function () {
            if (!$(this).hasClass("noCheckGroup")) {
                if (/HIDDEN_VIEW/g.test($(this).attr("name")) !== true) {
                    var propName = $(this).attr("name").replace('PROPERTY_', '').replace('[]', '');

                    if (this.nodeName == "SELECT" && $(this).data("multi") > 0) {
                        var patentSelect = $(this).parents("#PROPERTY_" + $(this).attr("name"));
                        //console.log(propName);
                        //console.log("select_"+$(this).val()+"-"+patentSelect.find("."+$(this).attr("name")+"_variants input[type=text]").length+"-"+patentSelect.find("."+$(this).attr("name")+"_variants input[type=hidden]").length);
                        if ($(this).val() == "" && patentSelect.find("." + $(this).attr("name") + "_variants input").length == 0) {
                            //console.log(patentSelect);
                            groupValid = false;
                        }
                        if (patentSelect.find("." + $(this).attr("name") + "_variants input[type=hidden]").length == 1 && $(this).val() == "") {
                            //console.log("2input_" + $(this).attr("name") + "_" + patentSelect.find("." + $(this).attr("name") + "_variants input[type=hidden]").val());
                            groupValid = false;
                        }
                        //console.log("2input_" + $(this).attr("name") + "_" + $(this).val());
                    } else {
                        //console.log(this.nodeName+"_" + $(this).attr("name") + "_" + $(this).val() + "_" + $(this).parent().parent().hasClass("multi_field_text_input") + "_" + $(this).parent().parent().parent().hasClass("multi_field_text"));
                        if ($(this).attr("type") != "hidden" && typeof $(this).data("opt-val") == "undefined") {
                            if ($(this).parent().parent().parent().hasClass("multi_field_text")) {
                                
                                var groopInputError = true;
                                $(this).parents(".input_box.multi_field_text").find("input").each(function () {
                                    if ($(this).val() != "" && $(this).attr("name") != "PROPERTY_"+propName+"[]") {
                                        groopInputError = false;
                                    }
                                });
                                if(groopInputError){
                                    groupValid = false;
                                }
                                //console.log(groopInputError);
                            } else {
                                if ($(this).val() == "" && !$(this).parent().parent().hasClass("multi_field_text_input")) {
                                    groupValid = false;
                                }
                                if ($(this).val() == "" && $(this).parent().parent().hasClass("valid_minus") && $(this).parent().parent().hasClass("multi_field_text_input")) {
                                    groupValid = false;
                                }
                            }

                            //console.log("1input_" + $(this).attr("name") + "_" + $(this).val() + "_" + $(this).parent().parent().hasClass("multi_field_text_input") + "_" + $(this).parent().parent().parent().hasClass("multi_field_text"));
                        }
                    }
                }
            }
        });
        //console.log(groupValid);
        if (groupValid) {
            $(".required_fields_check li:eq(" + groupNum + ")").removeClass('sidebar__item_error').addClass('sidebar__item_valid');
        } else {
            $(".required_fields_check li:eq(" + groupNum + ")").removeClass('sidebar__item_valid').addClass('sidebar__item_error');
        }
    }


    $(".section__top").click(function () {
        $(this + '.section__content').slideToggle();
    });

    var windowWidth = window.innerWidth;

    $('.drop-login__menu-item_feedback').fancybox({
        src: '#form-modal',
        beforeShow: function (instance, current) {
            if ($('.header-block div').is('.header-hidden-phone')) {
                let phone = $('.header-hidden-phone').text();
                $('input[name="phone"]').val(phone);
            }
            $("#form-modal input").each(function () {
                if (typeof $(this).data("default-value") != "undefined") {
                    $(this).val($(this).data("default-value"));
                }
            });
        }
    });

    $('html body').on('click', '.modal-wrap-close', function () {
        $.fancybox.close();
    });
    $('html body').on('click', '.form-modal-save-account__submit', function () {
        $.fancybox.close();
    });

    $(function () {
        var windowWidth = $(window).width();
        var emailChangeButton = $(".email-setting__button_changed");

        if ($(document).ready() && windowWidth < 769) {
            emailChangeButton.html('Изменить');
        } else {
            emailChangeButton.html('Изменить электронную почту');
        }
    });

    $(".header-login.authorized a.show-header-min-box").click(function (e) {
        e.preventDefault();
        if (!$(this).hasClass("active-header-min-box")) {
            //console.log($(this).hasClass("active-header-min-box"));
            $(this).addClass("active-header-min-box");
            $(".header-login__drop").slideDown();
        }
    });

    $(".filter__body").on('change', '.filter__left .filter__input', function () {
        if ($(this).prop("checked")) {
            $(this).parents('.filter__item').css('background', 'rgba(17, 155, 236, 0.03)');
        } else {
            $(this).parents('.filter__item').css('background', 'unset');
        }
    });
    $("#PROPERTY_PHONE input").inputmask("+7 (999)-999-99-99", {
        //"placeholder": ""
    });
    $(".form_filter input[name='DATE_OF_BIRTH']").inputmask("99.99.9999", {
    });
    $("#PROPERTY_OGRN input").inputmask("9999999999999", {
        "placeholder": "",
        clearIncompvare: false,
        greedy: false,
        regex: "[0-9]{13}",
    });
    $(".maskogrn").inputmask("9999999999999", {
        "placeholder": "",
        clearIncompvare: false,
        greedy: false,
        regex: "[0-9]{13}",
    });
    var isValid = Inputmask.isValid
    $("#PROPERTY_KPP input").inputmask("999999999", {
        "placeholder": "",
        clearIncompvare: true,
        greedy: false,
        regex: "[0-9]{9}"
    });
    $("#PROPERTY_INN input").inputmask("9999999999", {
        "placeholder": "",
        clearIncompvare: false,
        greedy: false,
        regex: "[0-9]{10}"
    });
    $('.sign_in_button.active').parent(".sign_in_option-item").css('border-color', '#1EB795');

    $(".login .sign_in_option .sign_in_option-item").click(function () {
        $(this).parents(".sign_in_option").find(".sign_in_option-item").css('border-color', '#e3e4e4');
        $(this).parents(".sign_in_option").find(".sign_in_button").removeClass("active");
        $(this).css('border-color', '#1EB795').find(".sign_in_button").addClass("active");
        if ($(this).hasClass("sign_in_option-item_entity")) {
            $(".bx-system-auth-form .form_input.email > div").html('ОГРН организации (13 цифр)');
            $(".bx-system-auth-form .form_input.email > input").attr('placeholder', '0000000000000-000').attr('data-min', '17').inputmask("9999999999999-999", {
                "placeholder": ""
            });
            $(".bx-auth-reg .form_input.email input").attr('placeholder', 'ОГРН организации (13 цифр)').attr('data-min', '13').inputmask("9999999999999", {
                "placeholder": ""
            });
            //$(".bx-system-auth-form .form_input.email input").addClass("onlyInt");
        } else {
            $(".bx-system-auth-form .form_input.email > div").html('E-mail')
            $(".bx-system-auth-form .form_input.email > input").attr('placeholder', 'E-mail').inputmask("remove").val("");
            $(".bx-auth-reg .form_input.email input").attr('placeholder', 'Адрес электронной почты').attr('data-min', '').inputmask("remove");
            $(".bx-system-auth-form .form_input.email input").removeClass("onlyInt");
        }
        $(".sign_in_alert").toggleClass("active");
        if (typeof $(this).parents(".sign_in_option").data("radio-name") != "undefined") {
            $("input[name=" + $(this).parents(".sign_in_option").data("radio-name") + "][value=" + $(this).find(".sign_in_button").data("radio-val") + "]").trigger("click");
        }
    });

    /*function checkReq(input) {
        input.removeClass("error");
        var valInput = input.val();
        if (input.length > 0) {
            if (input[0].type == 'checkbox') {
                if (!input[0].checked) {
                    $(input).next().addClass("error_red");
                    valInput = '';
                } else {
                    $(input).next().removeClass("error_red");
                    valInput = input[0].checked;
                }
            }
            if (input[0].type == 'password') {
                if (input.val().length < 6) {
                    input.addClass("error");
                    return false;
                }
            }
            if (input[0].name == 'REGISTER[EMAIL]' && typeof input.data("min") == "undefined") {
                if (input.val().indexOf('@') < 0) {
                    input.addClass("error");
                    return false;
                }
            }
            if (input[0].name == 'ID_USER_PR') {
                var data = {};
                data.id = input.val();
                if (data.id === 1) {
                    $.fancybox.open({
                        src: '#no_user',
                    });
                    input.addClass("error");
                    return false;
                }
                if (data.id > 0) {
                    var checkIssetUser = true;
                    $.ajax({
                        type: "POST",
                        url: "/ajax/check_uz_id.php",
                        data: data,
                        async: false,
                        dataType: "html",
                        success: function (responseData) {
                            if (responseData == false) {
                                $.fancybox.open({
                                    src: '#no_user',
                                });
                                input.addClass("error");
                                checkIssetUser = false;
                            }
                        }
                    });
                    if(!checkIssetUser){
                        return false;
                    }
                } else {
                    $.fancybox.open({
                        src: '#no_user',
                    });
                    input.addClass("error");
                    return false;
                }
            } else {
                if (typeof input.data("min") != "undefined") {
                    inputDataMin = input.data("min");
                    //console.log (inputDataMin);
                    valInputLength = valInput.length;
                    //console.log (valInputLength);

                    if (valInputLength < inputDataMin) {
                        input.addClass("error");
                        return false;
                    } else {
                        return true;
                    }
                }
                //console.log(valInput);
                if (valInput == "") {
                    input.addClass("error");
                    return false;
                } else {
                    return true;
                }
            }
        }

    }*/
    function checkReq(input) {
        input.removeClass("error");
        var valInput = input.val();
        $(".error_after_input").detach();
        if (input.length > 0) {
            if (input[0].type == 'checkbox') {
                if (!input[0].checked) {
                    $(input).next().addClass("error_red");
                    valInput = '';
                } else {
                    $(input).next().removeClass("error_red");
                    valInput = input[0].checked;
                }
            }
            if (input[0].type == 'password') {
                if (input.val().length < 6) {
                    input.addClass("error");
                    return false;
                }
            }
            if (input[0].name == 'REGISTER[EMAIL]' && typeof input.data("min") == "undefined") {
                if (input.val().indexOf('@') < 0) {
                    input.addClass("error");
                    return false;
                }
            }
            if (input[0].name == 'ID_USER_PR') {
                var data = {};
                data.id = input.val();
                if (data.id === 1) {
                    // $.fancybox.open({
                    //     src: '#no_user',
                    // });
                    $(".error_after_input").html($("#no_user").text());
                    input.addClass("error");
                    return false;
                }
                if (data.id > 0) {
                    var checkIssetUser = true;
                    $.ajax({
                        type: "POST",
                        url: "/ajax/check_uz_id.php",
                        data: data,
                        async: false,
                        dataType: "html",
                        success: function (responseData) {
                            if (responseData == false) {
                                // $.fancybox.open({
                                //     src: '#no_user',
                                // });
                                $(".error_after_input").html($("#no_user").text());
                                input.addClass("error");
                                checkIssetUser = false;
                            }
                        }
                    });
                    if(!checkIssetUser){
                        return false;
                    }
                } else {
                    // $.fancybox.open({
                    //     src: '#no_user',
                    // });
                    $(".error_after_input").html($("#no_user").text());
                    input.addClass("error");
                    return false;
                }
            } else {
                if (typeof input.data("min") != "undefined") {
                    inputDataMin = input.data("min");
                    //console.log (inputDataMin);
                    valInputLength = valInput.length;
                    //console.log (valInputLength);

                    if (valInputLength < inputDataMin) {
                        input.addClass("error");
                        return false;
                    } else {
                        return true;
                    }
                }
                //console.log(valInput);
                if (valInput == "") {
                    input.addClass("error");
                    return false;
                } else {
                    return true;
                }
            }
        }

    }

    $(".bx-system-auth-form .form_button button").click(function (e) {
        e.preventDefault();
        $(".error_box").detach();
        var form = $(this).parents("form");
        var er = false;
        form.find(".required input").each(function () {
            var dataEr = checkReq($(this));
            if (!dataEr && er === false) {
                er = true;
            }
        });
        //console.log(er);
        if (!er) {
            $(this).parents("form").find("input[type=submit]").click();
        }
    });
    /*$(".bx-auth-reg .form_button button").click(function (e) {
        e.preventDefault();
        let login = $('input[name="REGISTER[EMAIL]"]').val();
        let result = login.match(/(@ya\.)/);
        if(result !== null){
            let correctLogin = login.replace(/(@ya\.)/, "@yandex.");
            $('input[name="REGISTER[EMAIL]"]').val(correctLogin);
            $('input[name="REGISTER[LOGIN]"]').val(correctLogin);
            $.fancybox.open("<div>Необходимо полностью писать домен сервера почтового ящика<br>Почта "+login+" заменена на "+correctLogin+"</div>");
        }else{
            $(".error_box").detach();
            var form = $(this).parents("form");
            var er = false;
            $("#password").removeClass("error");
            var successForm = false;
            if (!$("#pwdMeter").hasClass("verystrong")) {
                er = true;
            } else {
                successForm = true;
            }
            if (!successForm) {
                if ($("#pwdMeter").hasClass("strong")) {
                    er = false;
                    successForm = true;
                }
            }
            if (!successForm) {
                $("#password").addClass("error");
                $.fancybox.open({
                    src: '#password_reg_description',
                });
            }
            $("#password").removeAttr("disabled");
            var pass = $('input[name="REGISTER[PASSWORD]"]').val();
            var confirmPass = $('input[name="REGISTER[CONFIRM_PASSWORD]"]').val();
            $('input[name="REGISTER[CONFIRM_PASSWORD]"]').removeClass("error");
            if (confirmPass != pass) {
                $('input[name="REGISTER[CONFIRM_PASSWORD]"]').addClass("error");
                er = true;
                $("#password").addClass("error");
                $.fancybox.open({
                    src: '#password_different',
                });
            }
            if ($(this).find("input").hasClass("maskogrn")) {
                //checkReq($(this).find("input"));
            }
            form.find(".required").each(function () {
                if (!$(this).hasClass("hidden_field") && !$(this).parent("div").hasClass("hidden_field")) {
                    var dataEr = checkReq($(this).find("input"));
                    if (dataEr === false && er === false) {
                        er = true;
                    }
                }
            });
            // console.log("er_" + er);
            // console.log("successForm_" + successForm);

            if (!er && successForm) {
                $(this).parents("form").find("input[type=submit]").click();
            }
        }


        //отправляем на регистрацию если нет ошибок

    });*/
    $(".bx-auth-reg .form_button button").click(function (e) {
        e.preventDefault();
        $("#pass_mess").html("");
        $("#pass_diff_mess").html("");
        let login = $('input[name="REGISTER[EMAIL]"]').val();
        let result = login.match(/(@ya\.)/);
        if(result !== null){
            let correctLogin = login.replace(/(@ya\.)/, "@yandex.");
            $('input[name="REGISTER[EMAIL]"]').val(correctLogin);
            $('input[name="REGISTER[LOGIN]"]').val(correctLogin);
            $.fancybox.open("<div>Необходимо полностью писать домен сервера почтового ящика<br>Почта "+login+" заменена на "+correctLogin+"</div>");
        }else{
            $(".error_box").detach();
            var form = $(this).parents("form");
            var er = false;
            $("#password").removeClass("error");
            var successForm = false;
            if (!$("#pwdMeter").hasClass("verystrong")) {
                er = true;
            } else {
                successForm = true;
            }
            if (!successForm) {
                if ($("#pwdMeter").hasClass("strong")) {
                    er = false;
                    successForm = true;
                }
            }
            if (!successForm) {
                $("#password").addClass("error");
                // $.fancybox.open({
                //     src: '#password_reg_description',
                // });
                $(".pass_mess").html($("#password_reg_description").html());
            }
            $("#password").removeAttr("disabled");
            var pass = $('input[name="REGISTER[PASSWORD]"]').val();
            var confirmPass = $('input[name="REGISTER[CONFIRM_PASSWORD]"]').val();
            $('input[name="REGISTER[CONFIRM_PASSWORD]"]').removeClass("error");
            if (confirmPass != pass) {
                $('input[name="REGISTER[CONFIRM_PASSWORD]"]').addClass("error");
                er = true;
                $("#password").addClass("error");
                //$("#password_different").show();
                $(".pass_diff_mess").html($("#password_different").html());
                // $.fancybox.open({
                //     src: '#password_different',
                // });
            }
            if ($(this).find("input").hasClass("maskogrn")) {
                //checkReq($(this).find("input"));
            }
            form.find(".required").each(function () {
                if (!$(this).hasClass("hidden_field") && !$(this).parent("div").hasClass("hidden_field")) {
                    var dataEr = checkReq($(this).find("input"));
                    if (dataEr === false && er === false) {
                        er = true;
                    }
                }
            });
            // console.log("er_" + er);
            // console.log("successForm_" + successForm);

            if (!er && successForm) {
                $(this).parents("form").find("input[type=submit]").click();
            }
        }


        //отправляем на регистрацию если нет ошибок

    });
    $('.jsFilterSelect').on("change", function (data) {


        if (data.target.getAttribute('data-multi') > 0) {
            var repID = $(data.target)[0].selectedOptions[0].getAttribute('value');
            var containHTML = $('.' + data.target.getAttribute('data-code') + '_variants')[0].innerHTML;
            var repVal = $(data.target)[0].selectedOptions[0].getAttribute('data-name');
            if (repID) {
                //console.log("." + data.target.getAttribute('data-code') + "_empty_"+repID);

                $(this).parents(".input_box").find('.' + data.target.getAttribute('data-code') + '_variants')[0].innerHTML = containHTML + "<div class='multi_field_text_input valid_minus'><div class=\"field-row\"><input name='PROPERTY_" + data.target.getAttribute('data-code') + "[" + repID + "]' type='text' data-opt-val='" + repID + "' value='" + repVal + "'><span class=\"remove-field\"></span></div></div>";
                //удаляем выбранный селект
                $(data.target).find('option:selected').remove();
                $("." + data.target.getAttribute('data-code') + "_empty").detach();
            }
        } else {
            $(this).parents(".input_box").find('.' + data.target.getAttribute('data-code') + '_variants').html("");
            $(this).parents(".input_box").find('.' + data.target.getAttribute('data-code') + '_variants').html("<input type='hidden' name='PROPERTY_" + data.target.getAttribute('data-code') + "' data-opt-val='" + $(this).val() + "' value='" + $(this).val() + "'>");
        }
    });

    function autoTextInput(input, face) {
        var form = input.parents("form");
        var data = form.serializeArray();
        var inputName = [];
        inputName["name"] = "input";
        inputName["value"] = input.attr("name");
        data.push(inputName);
        var faceName = [];
        faceName["name"] = "face";
        faceName["value"] = face;
        data.push(faceName);
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/ajax/auto_text.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                $(".selector-input").detach();
                input.parents(".input_box").append(responseData);
                console.log(responseData);
            }
        });
    }

    function filterPersonAjax(data, append) {
        $.ajax({
            type: "POST",
            url: "/ajax/filter_profile.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                //console.log(responseData);
                var countNext = $(responseData).find(".NavRecordCount").text();
                var res = $(responseData).find(".res");
                var c = 0;
                if(typeof ($(responseData).data("count-res")) != "undefined" && $(responseData).data("count-res") !== null){
                    c = $(responseData).data("count-res");
                }
                $(".count_res_filter").text("Найдено пользователей: "+c).show();
                if (countNext == 0) {
                    $(".filter__bottom .filter__button").hide();
                } else {
                    $(".filter__bottom .filter__button").show();
                    $(".filter__bottom .filter__button span").text(countNext);
                }

                if (append) {
                    $(".filter__body").append($(responseData).find(".filter__item"));
                } else {
                    $(".filter__body").html("");
                    $(".filter__body").html($(responseData).find(".filter__item"));
                }
            }
        });
    }

    function filterMailerAjax(data, append) {
        $.ajax({
            type: "POST",
            url: "/ajax/filter_mailer.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                //console.log(responseData)
                var countNext = $(responseData).find(".NavRecordCount").text();
                var res = $(responseData).find(".res");
                 var c = 0;
                if(typeof ($(responseData).data("count-res")) != "undefined" && $(responseData).data("count-res") !== null){
                    c = $(responseData).data("count-res");
                }
                $(".count_res_filter").text("Найдено пользователей: "+c).show();
                if (countNext == 0) {
                    $(".filter__bottom .filter__button").hide();
                } else {
                    $(".filter__bottom .filter__button").show();
                    $(".filter__bottom .filter__button span").text(countNext);
                }

                if (append) {
                    $(".filter__body").append($(responseData).find(".filter__item"));
                } else {
                    $(".filter__body").html("");
                    $(".filter__body").html($(responseData).find(".filter__item"));
                }
            }
        });
    }
    function filterCommunicationAjax(data, append) {
        $.ajax({
            type: "POST",
            url: "/ajax/filter_communication.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                //console.log(responseData)
                var countNext = $(responseData).find(".NavRecordCount").text();
                var res = $(responseData).find(".res");
                 var c = 0;
                if(typeof ($(responseData).data("count-res")) != "undefined" && $(responseData).data("count-res") !== null){
                    c = $(responseData).data("count-res");
                }
                $(".count_res_filter").text("Найдено пользователей: "+c).show();
                if (countNext == 0) {
                    $(".filter__bottom .filter__button").hide();
                } else {
                    $(".filter__bottom .filter__button").show();
                    $(".filter__bottom .filter__button span").text(countNext);
                }

                if (append) {
                    $(".filter__body").append($(responseData).find(".filter__item"));
                } else {
                    $(".filter__body").html("");
                    $(".filter__body").html($(responseData).find(".filter__item"));
                }
            }
        });
    }

    function filterReportAjax(data) {
        // console.log("11");
        $.ajax({
            type: "POST",
            url: "/ajax/filter_report_new.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                $("#create_feed .ajax_data").text(responseData);
                var ajaxDataParse = $.parseJSON(responseData);
                if (typeof (ajaxDataParse['id']) != "undefined" && ajaxDataParse['id'] !== null) {
                    $('.total-user-val').text(ajaxDataParse['id'].length);
                } else {
                    $('.total-user-val').text(0);
                }
            }
        });
    }

    function startFilter(form, face, append = false) {
        var data = form.serializeArray();
        var dataAllUser = $(".all_user").serializeArray();
        data = data.concat(dataAllUser);
        var countItems = [];
        countItems["name"] = "countItems";
        countItems["value"] = $(".filter__body").data("count-items");
        if($("form").is(".filter_byFio")){
            if($("form.filter_byFio input[name=users_id]").val() != ""){
                var users_id = [];
                users_id["name"] = "users_id";
                users_id["value"] = $("form.filter_byFio input[name=users_id]").val();
                data.push(users_id);
            }
        }
        data.push(countItems);
        countNumPage = $(".filter__body").data("num-page");
        if (append) {
            countNumPage++;
            $(".filter__body").data("num-page", countNumPage);
        } else {
            $(".filter__body").data("num-page", 1);
            countNumPage = 1;
        }
        var numPage = [];
        numPage["name"] = "numPage";
        numPage["value"] = countNumPage;
        $("label.select_all input").prop('checked', false);
        data.push(numPage);
        $(".filter .filter__head .filter__right input").prop('checked', false);
        if (form.hasClass("report_filter")) {
            filterReportAjax(data);
        } else if (form.hasClass("mailer_filter")) {
            filterMailerAjax(data, append);
        } else if (form.hasClass("communication_filter")) {
            filterCommunicationAjax(data, append);
        } else {
            //console.log(data);
            filterPersonAjax(data, append);
        }

        //console.log(data);
        // $.ajax({
        //     type: "POST",
        //     url: "/ajax/filter_profile.php",
        //     data: data,
        //     dataType: "html",
        //     success: function (responseData) {
        //         var countNext = $(responseData).find(".NavRecordCount").text();
        //         //console.log($(responseData).find(".NavRecordCount"));
        //         var res = $(responseData).find(".res");
        //         if (countNext == 0) {
        //             $(".filter__bottom .filter__button").hide();
        //         } else {
        //             $(".filter__bottom .filter__button").show();
        //             $(".filter__bottom .filter__button span").text(countNext);
        //         }

        //         if (append) {
        //             $(".filter__body").append($(responseData).find(".filter__item"));
        //         } else {
        //             $(".filter__body").html("");
        //             $(".filter__body").html($(responseData).find(".filter__item"));
        //         }

        //         //console.log(responseData);
        //     }
        // });
    }
    $(".newsletter-search__close").on("click", function(){
        $(this).parents("form").find("input").val("");
        $(this).parents("form").trigger("reset");
        $(this).trigger("input");
        $("form.active .startFilter").click();
    });
    $(".filter_byFio input[type=text]").on('input',function(e){
        let data = {};
        data.search = $(this).val();
        data.ib = $("input[name=FACE]:checked").val();
        $.ajax({
            type: "POST",
            url: "/ajax/filter_userByFio.php",
            data: data,
            dataType: "html",
            success: function (responseData) {
                console.log(responseData);
                if(responseData != "0" || data.search != ""){
                    $(".filter_byFio input[name=users_id]").val(responseData);
                }else{
                    $(".filter_byFio input[name=users_id]").val("");
                }
                $("form[data-face="+data.ib+"] .startFilter").click();
            }
        });
    });
    $(".startFilter").click(function () {
        var form = $("form.active");
        var face = $("input[name=FACE]:checked").val();
        startFilter(form, face);
    });
    $(".all_user .check input").change(function () {
        var form = $(this).parents("form.all_user").next(".full_filter_box").find("form.active");
        var face = $("input[name=FACE]:checked").val();
        startFilter(form, face);
    });
    $(".all_user .sign_in_option .sign_in_option-item").click(function () {
        $(this).parents(".sign_in_option").find(".sign_in_button").removeClass("active");
        $(this).find(".sign_in_button").addClass("active");
        if (typeof $(this).parents(".sign_in_option").data("radio-name") != "undefined") {
            $("input[name=" + $(this).parents(".sign_in_option").data("radio-name") + "][value=" + $(this).find(".sign_in_button").data("radio-val") + "]").trigger("click");
        }
        if ($(this).find(".sign_in_button").data("radio-val") == "TYPE_U") {
            $(".sign_in_option[data-radio-name=PERSONAL_DATA]").hide();
        } else {
            $(".sign_in_option[data-radio-name=PERSONAL_DATA]").show();
        }
        var form = $(this).parents("form.all_user").next(".full_filter_box").find("form.active");
        var face = $("input[name=FACE]:checked").val();
        startFilter(form, face);
        $('.jsFilterSelect').select2('destroy');

        function select2Init() {
            $('.jsFilterSelect').select2({
                placeholder: {
                    id: 0,
                    text: 'Выбрать'
                },
                language: {
                    noResults: function (params) {
                        return "Ничего не найдено";
                    }
                }
            });
            $('b[role="presentation"]').hide();
        }

        setTimeout(select2Init, 500);
    });
    $(".form_filter input, .form_filter select").on('input', function () {
        var form = $(this).parents(".form_filter");
        var face = $("input[name=FACE]:checked").val();
        startFilter(form, face);
    });
    $('.input_box').on('click', '.selector-value', function () {
        if (!$(this).hasClass("disabled")) {
            var face = $("input[name=FACE]:checked").val();
            var form = $(this).parents(".form_filter");
            var value = $(this).data("value");
            $(this).parents(".input_box").find("input").val(value);
            startFilter(form, face);
        }
        $(".selector-input").detach();
    });
    $(".filter__bottom .filter__button").click(function () {
        var form = $("form.form_filter.active");
        var face = $("input[name=FACE]:checked").val();
        startFilter(form, face, true);
    });
    $('.auto_text').on('input', function () {
        var face = $("input[name=FACE]:checked").val();
        autoTextInput($(this), face);
    });
    $(".multi_field_text .multi_field_text_plus").click(function () {
        var inputBox = $(this).parent();
        inputBox.addClass("margin-bottom");
        var inputBlock = $(this).parents(".multi_field_text");
        var inputVal = inputBox.find("input").val();
        if (inputVal != "") {
            var inputBoxClone = inputBox.clone();
            var nameInput = $(this).parents(".multi_field_text").attr("id");
            //console.log(inputBoxClone);
            inputBox.find("input").attr("name", nameInput + "[]");
            inputBoxClone.find(".multi_field_text_plus").remove();
            inputBoxClone.addClass("margin-bottom").addClass('valid_minus');
            inputBoxClone.insertBefore(inputBlock.find('.multi_field_text_input')[0]);
            inputBoxClone.find('.field-row').append("<span class=\"remove-field\"></span>");
            inputBox.find("input").val("");
        }
    });

    $("form").on("click", ".remove-field", function () {
        console.log("2");
        var inputBox = $(this).parent().parent();
        var box = $(this).parent().parent().parent();
        var cab = 0;
        if (inputBox.parent().find('.multi_field_text_input').length >= 1 && inputBox.parent().parent().find("select").length != 0) {
            var codeField = inputBox.parent().parent().find("select").data("code");
            if (inputBox.parent().find('.multi_field_text_input').length == 1) {
                inputBox.parent().parent().find("." + codeField + "_variants").append("<input type='hidden' class='" + codeField + "_empty' name='PROPERTY_" + codeField + "' value='false'>");
            }
            
            if ($(this).parents(".cabinet-block-form").length == 1) {

                /*if($(this).parents(".cabinet-block-form").find(".input_box").is(".multi_field_text")){
                    cab = $(this).parents("#PROPERTY_" + codeField).find(".input_box.multi_field_text");
                }else{*/
                cab = $(this).parents("#PROPERTY_" + codeField).find("." + codeField + "_variants");
                //}
                //console.log($(this).parents(".cabinet-block-form").find(".input_box").is(".multi_field_text"));
            }
        }
        var newStateText = $(this).parents(".multi_field_text_input").find("input").val();
        var newStateVal = $(this).parents(".multi_field_text_input").find("input").data("opt-val");
        var newState = new Option(newStateText, newStateVal, false, false);
        newState.setAttribute("data-name", newStateText);
        inputBox.parent().parent().find("select").append(newState);
        var thisMultiFieldText = false;
        if($(this).closest(".input_box").hasClass("multi_field_text")){
            var thisMultiFieldText = true;
        }
        inputBox.detach();
        if(thisMultiFieldText){
            if (box.parents(".cabinet-block-form").length == 1) {
                checkValidGroup(box);
                // console.log(box.attr("class"));
                // console.log(inputBox.attr("class"));
            }
        }
        if (cab != 0) {
            checkValidGroup(cab);
        }
        if ($("form").hasClass("form_filter")) {
            var form = $("form.active");
            var face = $("input[name=FACE]:checked").val();
            startFilter(form, face);
        }
    });
    // $(".input_box.multi_field_text").on("click", ".remove-field", function () {
    //     console.log("1");
    //     var inputBox = $(this).parent().parent();
    //     var box = $(this).parent().parent().parent();
    //     inputBox.detach();
    //     if (box.parents(".cabinet-block-form").length == 1) {
    //         // console.log("2");
    //         // console.log(box);
    //         checkValidGroup(box);
    //     }
    // });
    $('.jsFilterSelect').select2({
        placeholder: {
            id: 0,
            text: 'Выбрать'
        },
        language: {
            noResults: function (params) {
                return "Ничего не найдено";
            }
        }
    });
    $('b[role="presentation"]').hide();

    $(".checkbox").click(function () {
        if (!$(this).hasClass("disabled_check")) {
            var checkId = $(this).find("label").attr("for");
            if ($("#" + checkId).is(':checked')) {
                $("#" + checkId).prop('checked', false);
                if (!$(this).find("input").is(".empty_val")) {
                    $(this).append("<input value='' class='empty_val' type='hidden' name='" + checkId + "'>");
                }

            } else {
                $("#" + checkId).prop('checked', true);
                $(this).find(".empty_val").detach();
            }
        }
        //console.log();
    });
    $("#accordion").accordion();
    //$('.multi_select').multiSelect();
    $(".check_select .check_select_title").click(function () {
        var checkSelect = $(this).parent(".check_select");
        var dataId = checkSelect.data("id");
        var dataValue = checkSelect.data("value");
        var inputBox = checkSelect.parents(".multi_check");
        var inputBoxName = inputBox.data("name");
        if (checkSelect.hasClass("check")) {
            inputBox.find("input[data-id='" + dataId + "']").detach();
        } else {
            inputBox.prepend("<input type='hidden' name='" + inputBoxName + "' data-id='" + dataId + "' value='" + dataValue + "'>");
        }
        if (dataValue == 10) {
            checkSelect.find(".check_select_content").slideToggle();
        }
        checkSelect.toggleClass("check");
    });
    $(".btn_send").click(function () {
        alert("Форма еще не звязана с mysql!");
    });

    //отправка формы обратной связи
    $('.form-modal__submit').on('click', function (e) {
        e.preventDefault();
        var form = $(e.target).parents("form");
        var data = form.serializeArray();
        var er = false;
        var modalMessage = $(".modal__message").fancybox();

        form.find(".required input").each(function () {
            var dataEr = checkReq($(this));
            if (!dataEr && er === false) {
                er = true;
            }
        });
        //console.log(er);
        if (!er && !form.hasClass('wait-send')) {
            // console.log (data);
            $.ajax({
                type: "POST",
                url: "/ajax/send_feedback.php",
                data: data,
                dataType: "html",
                beforeSend: function () {
                    form.addClass('wait-send');
                },
                success: function (responseData) {
                    $('.form-modal__input').val('');
                    $('.modal-wrap-close').click();
                    form.removeClass('wait-send');
                    modalMessage.show();
                    //console.log(123123);
                    setTimeout(
                        function () {
                            modalMessage.hide();
                        },
                        2000
                    );
                }
            });
        }

    });

    //зачищаем поле выбранного селектара для множественного поля
    $('.jsFilterSelect').on('change', function () {
        //console.log($('.jsFilterSelect').data('multi'));
    })

    var strGET = window.location.search.replace('?', '');
    var arGET = strGET.split('&');
    for (var aGet of arGET) {
        var sGet = aGet.split('=');
        if (sGet[0] == 'error') {
            $.fancybox.open({
                src: '#form-modal-save-account',
                opts: {
                    beforeShow: function () {
                        $(this).find('.form-modal__name').html(sGet[1]);
                    }
                }
            });
        }
    }
    // $('.form-modal-save-account__submit').on('click', function(){
    //     location.href = '/personal/';
    // })

    $('.required_fields_check').on('click', function (e) {
        var block = $(e.target).data('block');
        var top = $('.' + block).offset().top - 100;
        // console.log ($('.'+block));
        $('html, body').animate({
            scrollTop: top
        }, 2000);
    })

    //разрешаем ввод только латинских букв в поле email
    var inputEmail = $('.email input, input[name=PROPERTY_EMAIL]');

   /* inputEmail.on('keypress', (e) => {
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[a-zA-Z0-9 @ \- _ .]/.test(String.fromCharCode(keyCode)) // Проверка на разрешённые символы
            ||
            (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)){// Проверка на количество пробелов
                console.log(inputEmail.data("min"));
                console.log(inputEmail.attr("class"));
                console.log(inputEmail);
                if(typeof inputEmail.data("min") == "undefined"){
                    $.fancybox.open("<div>Cмените раскладку клавиатуры, при вводе кириллицы.</div>");
                }else{
                    if(!/[0-9]/.test(String.fromCharCode(keyCode))){
                        $.fancybox.open("<div>Допускается ввод только цифр.</div>");
                    }
                }
                

                e.preventDefault(); // Если условие выполнилось, то запрещаем ввод символа
            } 
            
    });*/
    inputEmail.on('keypress', (e) => {
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[a-zA-Z0-9 @ \- _ .]/.test(String.fromCharCode(keyCode)) // Проверка на разрешённые символы
            ||
            (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)){// Проверка на количество пробелов
                if(typeof inputEmail.data("min") == "undefined"){
                    //$.fancybox.open("<div>Cмените раскладку клавиатуры, при вводе кириллицы.</div>");
                    if(!$(e.target).next(".error_after_input").length){
                        $(e.target).after("<div class='error_after_input'>Cмените раскладку клавиатуры, при вводе кириллицы.</div>");
                    }
                }else{
                    if(!/[0-9]/.test(String.fromCharCode(keyCode))){
                        //$.fancybox.open("<div>Допускается ввод только цифр.</div>");
                        if(!$(e.target).next(".error_after_input").length){
                            $(e.target).after("<div class='error_after_input'>Допускается ввод только цифр.</div>");
                        }
                    }
                }
                

                e.preventDefault(); // Если условие выполнилось, то запрещаем ввод символа
            }else{
                $(e.target).next(".error_after_input").detach();
            }
            
    });
    // var NAME_TYPE_F = $('*[name=NAME_TYPE_F]');
    // NAME_TYPE_F.on('keypress', (e) => {
    //     //console.log($('#no_user'));
    //     var keyCode = e.keyCode || e.which; // Код символа
    //     if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode)) || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)) // Проверка на количество пробелов
    //     {
    //         e.preventDefault();
    //         $('#no_user').html("Допускается ввод только русских букв");
    //         $.fancybox.open({
    //             src: '#no_user'
    //         });
    //     } // Если условие выполнилось, то запрещаем ввод символа
    // });
    var NAME_TYPE_F = $('*[name=NAME_TYPE_F]');
    NAME_TYPE_F.on('keypress', (e) => {
        //console.log($('#no_user'));
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
        {
            e.preventDefault();
            $('#no_user').html("Допускается ввод только русских букв");
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>"+$("#no_user").text()+"</div>");
            }
            
            // $.fancybox.open({
            //     src: '#no_user'
            // });
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    // var SURNAME = $('*[name=SURNAME]');
    // SURNAME.on('keypress', (e) => {
    //     var keyCode = e.keyCode || e.which; // Код символа
    //     if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
    //     {
    //         e.preventDefault();
    //         $('#no_user').html("Допускается ввод только русских букв");
    //         $.fancybox.open({
    //             src: '#no_user'
    //         });
    //     } // Если условие выполнилось, то запрещаем ввод символа
    // });
    var SURNAME = $('*[name=SURNAME]');
    SURNAME.on('keypress', (e) => {
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
        {
            e.preventDefault();
            $('#no_user').html("Допускается ввод только русских букв");
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>"+$("#no_user").text()+"</div>");
            }

            // $.fancybox.open({
            //     src: '#no_user'
            // });
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    // var SURNAME = $('*[name=PROPERTY_SURNAME]');
    // SURNAME.on('keypress', (e) => {
    //     //console.log($('#no_user'));
    //     var keyCode = e.keyCode || e.which; // Код символа
    //     if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode)) || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)) // Проверка на количество пробелов
    //     {
    //         e.preventDefault();
    //         $('#no_user').html("Допускается ввод только русских букв");
    //         $.fancybox.open({
    //             src: '#no_user'
    //         });
    //     } // Если условие выполнилось, то запрещаем ввод символа
    // });
    var SURNAME = $('*[name=PROPERTY_SURNAME]');
    SURNAME.on('keypress', (e) => {
        //console.log($('#no_user'));
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
        {
            e.preventDefault();
            $('#no_user').html("Допускается ввод только русских букв");
            // $.fancybox.open({
            //     src: '#no_user'
            // });
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>"+$("#no_user").text()+"</div>");
            }
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    // var FIRST_NAME = $('*[name=PROPERTY_FIRST_NAME]');
    // var IB_ID = $('*[name=PROFILE_IB]');
    // FIRST_NAME.on('keypress', (e) => {
    //     var keyCode = e.keyCode || e.which; // Код символа
    //     if (IB_ID.val() !== '8') {
    //         if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || & keyCode === 32)*/) // Проверка на количество пробелов
    //         {
    //             e.preventDefault();

    //             $('#no_user').html("Допускается ввод только русских букв");
    //             $.fancybox.open({
    //                 src: '#no_user'
    //             });
    //         } // Если условие выполнилось, то запрещаем ввод символа
    //     }
    // });
    var FIRST_NAME = $('*[name=PROPERTY_FIRST_NAME]');
    var IB_ID = $('*[name=PROFILE_IB]');
    FIRST_NAME.on('keypress', (e) => {
        var keyCode = e.keyCode || e.which; // Код символа
        if (IB_ID.val() !== '8') {
            if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || & keyCode === 32)*/) // Проверка на количество пробелов
            {
                e.preventDefault();

                $('#no_user').html("Допускается ввод только русских букв");
                // $.fancybox.open({
                //     src: '#no_user'
                // });
                if(!$(e.target).next(".error_after_input").length){
                    $(e.target).after("<div class='error_after_input'>"+$("#no_user").text()+"</div>");
                }
            }else{
                $(e.target).next(".error_after_input").detach();
            }
        }
    });
    // var MIDDLENAME = $('*[name=PROPERTY_MIDDLENAME]');
    // MIDDLENAME.on('keypress', (e) => {
    //     var keyCode = e.keyCode || e.which; // Код символа
    //     if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
    //     {
    //         e.preventDefault();
    //         $('#no_user').html("Допускается ввод только русских букв");
    //         $.fancybox.open({
    //             src: '#no_user'
    //         });
    //     } // Если условие выполнилось, то запрещаем ввод символа
    // });
    var MIDDLENAME = $('*[name=PROPERTY_MIDDLENAME]');
    MIDDLENAME.on('keypress', (e) => {
        var keyCode = e.keyCode || e.which; // Код символа
        if (!/[а-яА-Я-\s]/.test(String.fromCharCode(keyCode))/* || (/[ ]/.test(String.fromCharCode(keyCode)) && keyCode === 32)*/) // Проверка на количество пробелов
        {
            e.preventDefault();
            $('#no_user').html("Допускается ввод только русских букв");
            // $.fancybox.open({
            //     src: '#no_user'
            // });
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>"+$("#no_user").text()+"</div>");
            }
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    // $('.bx-system-auth-form input[name=USER_LOGIN]').on('keypress paste', function(e){
    //     var keyCode = e.keyCode || e.which;
    //     if($(this).hasClass("onlyInt")){
    //         // if (!/[0-9]/.test(String.fromCharCode(keyCode))){
    //         //     e.preventDefault();
    //         //     $.fancybox.open("<div>Допускается ввод только цифр</div>");
    //         // }
    //     }else{
    //         if (/[а-яА-Я]/.test(String.fromCharCode(keyCode)) && !$(this).parent("div").hasClass("email")){
    //             e.preventDefault();
    //             $.fancybox.open("<div>Не допускается ввод русских букв</div>");
    //         }
    //     }
    // });
    $('.bx-system-auth-form input[name=USER_LOGIN]').on('keypress paste', function(e){
        var keyCode = e.keyCode || e.which;
        if($(this).hasClass("onlyInt")){
            // if (!/[0-9]/.test(String.fromCharCode(keyCode))){
            //     e.preventDefault();
            //     $.fancybox.open("<div>Допускается ввод только цифр</div>");
            // }
        }else{
            if (/[а-яА-Я]/.test(String.fromCharCode(keyCode))/* && !$(this).parent("div").hasClass("email")*/){
                e.preventDefault();
                //$.fancybox.open("<div>Не допускается ввод русских букв</div>");
                if(!$(e.target).next(".error_after_input").length){
                    $(e.target).after("<div class='error_after_input'>Не допускается ввод русских букв</div>");
                }
            }else{
                $(e.target).next(".error_after_input").detach();
            }
        }
    });
    $('.bx-system-auth-form input[name=USER_PASSWORD]').on('keypress paste', function(e){
        var keyCode = e.keyCode || e.which;
        if (/[а-яА-Я]/.test(String.fromCharCode(keyCode))){
            e.preventDefault();
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>Не допускается ввод русских букв</div>");
            }
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    $('.bx-auth-reg input[name*=PASSWORD]').on('keypress paste', function(e){
        var keyCode = e.keyCode || e.which;
        if (/[а-яА-Я]/.test(String.fromCharCode(keyCode))){
            e.preventDefault();
            if(!$(e.target).next(".error_after_input").length){
                $(e.target).after("<div class='error_after_input'>Не допускается ввод русских букв</div>");
            }
        }else{
            $(e.target).next(".error_after_input").detach();
        }
    });
    //открываем пароль при необходимости
    $('.form_input').find('.eye').on('click', function (e) {
        if ($(e.target).prevAll().attr('type') == 'password') {
            $(e.target).prevAll().attr('type', '');
            $(e.target).parent().css('background-image', 'url("/bitrix/templates/pakk/img/eye.svg")')
        } else {
            $(e.target).prevAll().attr('type', 'password')
            $(e.target).parent().css('background-image', 'url("/bitrix/templates/pakk/img/input-pass.svg")')
        }
    });

    //сообщение при успешной регистрации
    // window.onload = function () {
    //     var strGET = window.location.search.replace('?', '');
    //     var pathName = window.location.pathname;
    //     var arGET = strGET.split('&');
    //     if (pathName == '/auth/') {

    //         for (var aGet of arGET) {
    //             var sGet = aGet.split('=');
    //             var mGet = arGET[1].split('=');
    //             if (sGet[0] == 'success' && sGet[1] == 'Y') {
    //                 $('#form-modal-save-account').find('.form-modal__name').html("Спасибо за регистрацию!<br> <span style='font-size:14px; font-weight:100'>Вам на почту <b style='color:#1db795'>" + mGet[1] +
    //                     "</b> отправлено письмо с ссылкой для подтверждения почтового адреса.<br>Перейдите по указанной ссылке" +
    //                     " и введите логин и пароль<br>Убедитесь, что письмо не попало в спам.</span>");
    //                 $.fancybox.open({
    //                     src: '#form-modal-save-account'
    //                 });
    //             }
    //         }
    //     }


    // }

    //Прогресс бар в модеравция/очтёт
    var progress = $('.construction-houses__content__item__village__readiness__procent'),
        progressValue = [];
    for (var i = 0; i < progress.length; i++) {
        progressValue.push(progress[i].getAttribute('data-progress'));
        $(progress).eq(i).addClass(function () {
            return 'progress-' + progressValue[i];
        });
        $('body').append('<style>.progress-' + progressValue[i] + ':before {width: ' + progressValue[i] + '%;}</style>');
    }


    //АККАРДЕОН в редактировании лк

    $('.block_1 .groop_field_title').addClass('active')
    var acc = $(".groop_field .groop_field_title"),
        i, panel;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {

            panel = this.parentElement.parentElement.querySelector('.groop_field_box');
            if (this.classList.contains('active')) {
                $(panel).fadeOut();
                this.classList.toggle("active");
            } else {
                $(".groop_field .groop_field_title").removeClass('active');
                $('.groop_field_box').hide();
                $('html, body').stop().animate({
                    scrollTop: $(this).offset().top - 100
                }, 300);
                $(panel).fadeIn();
                this.classList.toggle("active");

            }
        });
    }


    $('.modern-version__close').on('click', function () {
        $('.modern-version').hide();
    })


    $(function () {
        $("select.form__input-multi").multipleSelect({
            selectAll: false,
            filter: true,
            onClick: function (view) {
                var form = $("form.active");
                var face = $("input[name=FACE]:checked").val();
                startFilter(form, face);
            }
        });
    });

    $('.cabinet-block-form .groop_field_box').on('input', function (event) {
        checkValidGroup($(event.target));
    });

    $('.cabinet-block-form input.phone').on('change', function (event) {
        checkValidGroup($(event.target));
    });

    $(".multi_field_text input[type=text]").on('input', function (event) {
        var nameInput = $(this).parents(".multi_field_text").attr("id");
        var valueInput = $(this).val();
        var newName = nameInput + "[" + valueInput + "]";
        $(this).attr("name", newName);
    });
    // $(".cabinet-block-form .input_box").on("click", ".remove-field", function(){
    //     checkValidGroup($(this));
    //     console.log("21214");
    // });
















    $('.faq-tab__info').on('click', function () {
        $(this).toggleClass('active');
        $(this).siblings('.faq-tab__content').slideToggle();
    });


    $('.fancybox-popup__link').fancybox();


    $('.header-notification__icon').on('click', function (e) {
        $('.header-notification__content').fadeToggle();
    });

    $('.header-notification__title svg').on('click', function () {
        $('.header-notification__content').fadeOut();
    });


    $('.header-search__btn').on('click', function (e) {
        $('.header-search__wrap').fadeToggle();
    });


    $('.header-search__form svg').on('click', function (e) {
        $('.header-search__wrap').fadeOut();
    });

    /*$('.header-search__input').focus(function() {
        $('.header-search__prompt').fadeIn();
    });
    $('.header-search__input').focusout(function() {
        $('.header-search__prompt').fadeOut();
    });*/

    // $('.header-search__input').on("input", function() {
    //     if($(this).val() != "" && $(this).val().length > 2){
    //         var searchPopup = $(this).parents("form").find(".header-search__prompt");
    //         $.ajax({
    //             type: "GET",
    //             url: "/ajax/search.php",
    //             data: "q="+$(this).val(),
    //             dataType: "html",
    //             success: function (responseData) {
    //                 searchPopup.html("");
    //                 //console.log(responseData);
    //                 if(!searchPopup.hasClass("active_popup")){
    //                     searchPopup.fadeIn();
    //                     searchPopup.addClass("active_popup");
    //                 }
    //                 if(responseData == ""){
    //                     searchPopup.fadeOut();
    //                     searchPopup.removeClass("active_popup");
    //                 }
                    
    //                 searchPopup.html(responseData);
    //             }
    //         });
    //     }else{
    //         searchPopup.fadeOut();
    //         searchPopup.removeClass("active_popup");
    //     }
    // });
    $('.header-search__input-wrap').click(function (e) {
        if (e.offsetX > e.target.offsetLeft) {
            
        }else{
            $(this).parents("form").submit();
        }
    });
    (function () {
        $('.newsletter__tab-info').on('click', '.newsletter__tab-btn', function (e) {
            $('.newsletter__tab-btn-wrap').removeClass('active');
            $(e.target).addClass('active');
            $(this).closest('.newsletter-search__content').find('.newsletter__tab-content').removeClass('active').eq($(this).index()).addClass('active');
            if($(this).parents(".newsletter").hasClass("mailing-filter")){
                var form = $(".mailing-filter .newsletter__tab-content.active form.newsletter__form");
                startMailingFilter(form);
            }
            
        });
    })();


    (function () {
        $('.account__tab-wrap').on('click', '.account__tab-btn', function (e) {
            $('.account__tab-btn').removeClass('active');
            $(e.target).addClass('active');
            $(this)
                .closest('.account__tab').find('.account__tab-content').removeClass('show').eq($(this).index()).addClass('show');
        });
    })();




    $('.newsletter__form-label--whom').on('click', function () {
        $(this).siblings('.newsletter__form-whom-edit').toggleClass('show-flex');
    });

    $('.newsletter__form-calendar-wrap').on('click', function () {
        $(this).toggleClass('newsletter__form-calendar-wrap--active');
        $(this).siblings('.newsletter__form-calendar-popup').toggleClass('show');
    });

    $('.sidebar__link-info').on('click', function () {
        $(this).siblings('.sidebar__tab-content').fadeToggle();
    });


    var hash = window.location.hash;
    if(hash != ""){
        if(hash.indexOf('#tab-') == 0){
            tabActivator(hash);
        }
        if(hash.indexOf('#popup-') == 0){
            popupActivator(hash);
        }
    }
});