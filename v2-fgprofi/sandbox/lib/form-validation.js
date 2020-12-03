/*
 *  jQuery Validation
 *  заимствовано
 */
function checkIssetPhoneFields()
{
    var mobile_codeId = null;
    var mobile_numberId = null;
    var home_codeId = null;
    var home_numberId = null;
    var mobile_code = null;
    var mobile_number = null;
    var home_code = null;
    var home_number = null;

    if(($("input").is("#phone_code_1") || $("input").is("[name=phone_code_1]")) && !is_mobile()) {
        mobile_codeId = "phone_code_1";
        mobile_numberId = "phone_number_1";
        mobile_code = jQuery("input[name=phone_code_1], input#phone_code_1");
        mobile_number = jQuery("input[name=phone_number_1], input#phone_number_1");
    }
    else if(($("input").is("#mobile_phone_code") || $("input").is("[name=mobile_phone_code]")) || is_mobile()) {
        mobile_codeId = "mobile_phone_code";
        mobile_numberId = "mobile_phone_phone";
        mobile_code = jQuery("input[name=mobile_phone_code], input#mobile_phone_code");
        mobile_number = jQuery("input[name=mobile_phone_phone], input#mobile_phone_phone");
    }

    if(($("input").is("#phone_code_2") || $("input").is("[name=phone_code_2]")) && !is_mobile()) {
        home_codeId = "phone_code_2";
        home_numberId = "phone_phone_2";
        home_code = jQuery("input[name=phone_code_2], input#phone_code_2");
        home_number = jQuery("input[name=phone_number_2], input#phone_number_2");
    }
    else if(($("input").is("#home_phone_code") || $("input").is("[name=home_phone_code]")) || is_mobile()) {
        home_codeId = "home_phone_code";
        home_numberId = "home_phone_phone";
        home_code = jQuery("input[name=home_phone_code], input#home_phone_code");
        home_number = jQuery("input[name=home_phone_phone], input#home_phone_phone");
    }

    if(($("input").is("#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX") || $("input").is("[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX]")) && !is_mobile()) {
        home_codeId = "USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX";
        home_numberId = "USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR";
        home_code = jQuery("input[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX], input#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX");
        home_number = jQuery("input[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR], input#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR");
    }
    else if(($("input").is("#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX") || $("input").is("[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX]")) && !is_mobile()) {
        home_codeId = "USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX";
        home_numberId = "USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR";
        home_code = jQuery("input[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX], input#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX");
        home_number = jQuery("input[name=USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR], input#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR");
    }

    var numbers = {
        home: {
            codeId: home_codeId,
            numberId: home_numberId,
            code: home_code,
            number: home_number
        },
        mobile: {
            codeId: mobile_codeId,
            numberId: mobile_numberId,
            code: mobile_code,
            number: mobile_number
        }
    };
    return numbers;
}
jQuery(document).ready(function(){
    var numbers = checkIssetPhoneFields();
    jQuery(numbers.home.code).keyup(function(event, el){
        if($(this).val().length >= 3) {
            var nw = 0;
            if($(this).val().length > 3) {
                var nw = ($(this).val().length - 3) * 8;
            }
            //$(this).css({"width":parseInt(25 + nw)+"px"});
            var newpl = new Array(10-$(this).val().length + 1).join("0");
            //$(this).next().attr("style","width:"+parseInt(73 - nw)+"px !important;");
            $(this).next().attr("placeholder", newpl);
        }
        if(jQuery(this).val().length == 5 && !(event.keyCode == 37 || event.keyCode == 39)){//37 и 39 - Стрелки вправо/влево
            jQuery(this).blur();
            numbers.home.number.focus().focus(); //Fix for IE
        }
    });

    jQuery(numbers.mobile.code).keyup(function(event, el){
        // 37 и 39 - Стрелки вправо/влево. 9 и 16 tab и shift+tab
        if(jQuery(this).val().length == 3 && jQuery.inArray(event.keyCode, [37, 39, 9, 16]) == -1){
            jQuery(this).blur();
            numbers.mobile.number.focus().focus(); //Fix for IE
        }
    });
});

if(jQuery.validator) {
    jQuery.validator.addMethod("elkPersonalPhoneValidate", function(value, element) {
            var numbers = checkIssetPhoneFields();
            jQuery(numbers.home.number).blur(function(){
                var newpl = new Array(10-$(this).prev().val().length + 1).join("0");
                jQuery(this).attr("placeholder", newpl);
            });
            return elkPersonalPhoneValidate(value, element, numbers.home.code, numbers.home.number);
        },"Error field"
    );
    jQuery.validator.addMethod("myTrim", function(value, element) {
            return (value.replace(/\s*/, '').length > 0)
        },"Пустое поле"
    );
    jQuery.validator.addMethod("myTrim", function(value, element) {
            return (value.replace(/\s*/, '').length > 0)
        },"Пустое поле"
    );
    jQuery.validator.addMethod("newMobilePhoneValidate", function(value, element) {
            return newMobilePhoneValidate(value, element);
        },"Error field"
    );
    jQuery.validator.addMethod("elkMobilePhoneValidate", function(value, element) {
            var numbers = checkIssetPhoneFields();
            return elkMobilePhoneValidate(value, element, numbers.mobile.code, numbers.mobile.number);
        },"Error field"
    );
    jQuery.validator.addMethod("cartMobileCode", function(value, element) {
            return cartMobileCode(value, element);
        },"Error field"
    );
    jQuery.validator.addMethod("cartMobilePhone", function(value, element) {
            return cartMobilePhone(value, element);
        },"Error field"
    );

    jQuery.validator.addMethod("__elkEmailValidate", function(value, element) {
            return elkEmailValidate(value, element);
        }
    );
    jQuery.validator.addMethod("__isNumber", function(value, element) {
            return elkIsNumber(value, element);
        }
    );
    jQuery.validator.addMethod("__islengthPostCode", function(value, element) {
            return elkIsMinMaxlength(value, element);
        }
    );
    jQuery.validator.addMethod("elkNameValidate", function(value, element) {
            return elkNameValidate(value, element);
        }
    );
    jQuery.validator.addMethod("elkNameLength", function(value, element) {
            return elkNameLength(value, element);
        }
    );
    jQuery.validator.addMethod("notMoreCurrentDate", function(value, element) {
            return notMoreCurrentDate(value, element);
        }
    );
    jQuery.validator.addMethod("__elkINNValidate", function(value, element) {
            return validateINN(value, element);
        }
    );
    jQuery.validator.addMethod("__elkOKPOValidate", function(value, element) {
            return validateOKPO(value, element);
        }
    );
    jQuery.validator.addMethod("__elkOGRNValidate", function(value, element) {
            return validateOGRN(value, element);
        }
    );
    jQuery.validator.addMethod("__elkOKATOValidate", function(value, element) {
            return validateOKATO(value, element);
        }
    );
    jQuery.validator.addMethod("__elkSETTLValidate", function(value, element) {
            return validateSETTL(value, element);
        }
    );
    jQuery.validator.addMethod("__elkCORRValidate", function(value, element) {
            return validateCORR(value, element);
        }
    );
    jQuery.validator.addMethod("__elkKPPValidate", function(value, element) {
            return validateKPP(value, element);
        }
    );
    jQuery.validator.addMethod("__elkKPPZeroValidate", function(value, element) {
            return validateKPPZero(value, element);
        }
    );
    jQuery.validator.addMethod("__elkBIKValidate", function(value, element) {
            return validateBIK(value, element);
        }
    );

    jQuery.validator.addMethod("birthDateValidate", function(date, element){
        if(date.length == 0){return true;}
        var regxp = /^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/g;
        if(date.length > 0 && date.match(regxp)){
            let arrD = date.split(".");
            arrD[1] -= 1;
            let d = new Date(arrD[2], arrD[1], arrD[0]);
            if (d.getFullYear() == arrD[2] && d.getMonth() == arrD[1] && d.getDate() == arrD[0]) {
                return true;
            }
        }
        return false;
    });

    jQuery.validator.addMethod("notDefaultText", function(value, element){
        if(value == jQuery(element).attr('placeholder')){
            return false;
        }else{
            return true;
        }
    });

    jQuery.validator.addMethod("changePassword", function(value, element) {
        if($('#idUserChangePhone').length > 0) {
            var p = jQuery('#idUserChangePhone').val();
            var e = jQuery('#idEmailChangePassword').val();
            if(p.length <= 0 && e.length <= 0) return false;
        }
        return true;
    }, 'Введите адрес эл. почты или номер телефона.');

    /*jQuery.validator.addMethod("email2", function(value, element, param) {
        return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value);
    }, 'Адрес эл. почты введен некорректно.');*/

    jQuery.validator.addMethod("email2", function(value, element, param) {
        //return this.optional(element) || /^((\".*\")|([a-z0-9_]+([=_.0-9a-z+~'!\$&*^`|\\#%/?{}-]*))[a-z0-9A-Z]{1})@(([0-9a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF-]+\.)+)([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF0-9]{1,5}[a-zA-Z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]{1})$/i.test(value);
        return this.optional(element) || /^((\".*\")|([a-z0-9_]+([=_.0-9a-z+~'!\$&*^`|\\#%/?{}-]*))[a-z0-9A-Z]{1}[-]{0,1})@(((([0-9a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([-]{0,1}))+([0-9a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+\.)+)([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF0-9]{1,5}[a-zA-Z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]{1})$/i.test(value);
    }, 'Адрес эл. почты введен некорректно.');


    jQuery.validator.addMethod("email", function(value, element) {
        var obEmail = jQuery(element);
        obEmail.data('error', null);

        if (value == obEmail.attr('placeholder')) {
            return true;
        }

        if(value.length <= 0) {
            return true; // Если поле обязательное, то делаем validate -> rules -> required.
        }

        if (value.length > 60) {
            var errorMessage = 'Количество введенных символов не должно превышать 60 символов.';
            obEmail.data('error',  errorMessage);
            return false;
        }


        //  [а-яА-Я] === [\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]
        var ruRegPattern = /^([a-zA-Z0-9_-]([-_0-9a-zA-Z\.]{0,62}[a-zA-Z0-9_-])|([a-zA-Z0-9_-]))@(([0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF-]{0,}[0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]\.)|([0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]\.))+([\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]{2,6})$/i
        var enRegPattern = /^([a-zA-Z0-9_-]([-_0-9a-zA-Z\.]{0,62}[a-zA-Z0-9_-])|([a-zA-Z0-9_-]))@(([0-9a-zA-Z][0-9a-zA-Z-]{0,}[0-9a-zA-Z]\.)|([0-9a-zA-Z]\.))+([a-zA-Z]{2,6})$/i;

        if (!enRegPattern.test(value) && !ruRegPattern.test(value)) {
            var errorMessage = 'Адрес эл. почты введен некорректно.';
            obEmail.data('error',  errorMessage);
            return false;
        }
        return true;
    });

    jQuery.validator.addMethod("order-email", function(value, element) {
        var obEmail = jQuery(element);
        obEmail.data('error', null);

        if (value == obEmail.attr('placeholder')) {
            return true;
        }

        if(value.length <= 0) {
            return true; // Если поле обязательное, то делаем validate -> rules -> required.
        }

        if (value.length > 100) {
            var errorMessage = 'Количество введенных символов не должно превышать 100.';
            obEmail.data('error',  errorMessage);

            return false;
        }

        //  [а-яА-Я] === [\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]
        var ruRegPattern = /^([a-zA-Z0-9_-]([-_0-9a-zA-Z\.]{0,100}[a-zA-Z0-9_-])|([a-zA-Z0-9_-]))@(([0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF-]{0,}[0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]\.)|([0-9\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]\.))+([\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]{2,6})$/i
        var enRegPattern = /^([a-zA-Z0-9_-]([-_0-9a-zA-Z\.]{0,100}[a-zA-Z0-9_-])|([a-zA-Z0-9_-]))@(([0-9a-zA-Z][0-9a-zA-Z-]{0,}[0-9a-zA-Z]\.)|([0-9a-zA-Z]\.))+([a-zA-Z]{2,6})$/i;

        if (!enRegPattern.test(value) && !ruRegPattern.test(value)) {
            errorMessage = 'Адрес эл. почты введен некорректно.';
            obEmail.data('error',  errorMessage);
            return false;
        }

        return true;
    });

    jQuery.validator.setDefaults({
        debug: false,
        onfocusout: function(element, event) {
            if ($(element).val() != "" && jQuery(element).valid()) {
                jQuery('.passSubmit').removeAttr('disabled');
            }
            return;
        },
        errorClass: 'invalid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            var pos = jQuery(element).position();
            var t = pos.top+element.height()/2-12;
            var l = pos.left+element.outerWidth();
            // #38649
            if (element.attr('id') == 'USER_PASSWORD_PASSWORD'){
                error.addClass('invalid errorBox error-password-important').css({top:t, left:l});
            } else {
                error.addClass('invalid errorBox').css({top:t, left:l});
            }
            var numbers = checkIssetPhoneFields();
            if (element.attr("name") == numbers.mobile.codeId || element.attr("name") == numbers.mobile.numberId) {
                error.insertAfter(numbers.mobile.number);
            } else if (element.attr("name") == numbers.home.codeId || element.attr("name") == numbers.home.numberId) {
                error.insertAfter(numbers.home.number);
            } else {
                error.insertAfter(element);
            }
            if($(element).data('error_pos') == 'left') {
                error.wrap('<div class="regErrorLeft"></div>');
                l = pos.left-element.outerWidth()-170;
                error.css({left:l});
            }

            if (element.attr('id') == 'USER_PASSWORD_PASSWORD'){
                error.attr('style', 'margin-top: 0 !important');
            }
        },
        showErrors: function(errorMap, errorList) {
            var obj = this;
            var error = [];
            jQuery.each(obj.errorList, function(i, el){
                obj.errorList[i].message = '<span class="regErrorMid">'+el.message+'</span><div class="errorBoxArrow"></div>';
                error[i] = $(obj.errorList[i].element);
            });
            obj.defaultShowErrors();
            if (error.length) {
                for (var i = error.length - 1; i >= 0; i--) {
                    adjustWarning($(error)[i].siblings('.errorBox'));
                }
            }
        },
        success: function(label) {
            label.remove();
        }
    });
}

jQuery.fn.extend({
    change_password: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                changePassword: true
            });
        }
        return this;
    },
    valid_card: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: false,
                //number: true,
                //__isNumber: true,
                minlength: 19,
                maxlength: 19,
                messages: {
                    /*__isNumber: function(value, element) {
                     return jQuery(element).data('error');
                     },
                     number: elkFormDefaultError('only_digits'),
                     */
                    required: "Не указан номер карты.",
                    minlength: elkFormDefaultError('only_16_cart'),
                    maxlength: elkFormDefaultError('only_16_cart')
                }
            });
        }
    },
    valid_pincode: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                minlength: 4,
                maxlength: 4,
                messages: {
                    required: "Не указан PIN-код.",
                    minlength: elkFormDefaultError('only_4_pin'),
                    maxlength: elkFormDefaultError('only_4_pin')
                }
            });
        }
    },
    valid_email: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                __elkEmailValidate:true,
                maxlength: 60,
                //email2: true,
                messages: {
                    required: "Адрес эл. почты обязателен к заполнению!",
                    __elkEmailValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    not_more_current_date: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                notMoreCurrentDate: true,
                messages: {
                    notMoreCurrentDate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_password: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: true
            });
        }
    },
    valid_face: function () {
        elkFormatName(jQuery(this));
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                elkNameValidate: true,
                elkNameLength: true,
                messages: {
                    required: "Имя не указано!",
                    elkNameValidate: function (value, element) {
                        return jQuery(element).data('error');
                    },
                    elkNameLength: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_face_last: function () {
        elkFormatName(jQuery(this));
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                elkNameValidate: true,
                messages: {
                    required: "Фамилия не указана!",
                    elkNameValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_face_second: function () {
        elkFormatName(jQuery(this));
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                elkNameValidate: true,
                elkNameLength: true,
                messages: {
                    required: "Отчество не указано!",
                    elkNameValidate: function (value, element) {
                        return jQuery(element).data('error');
                    },
                    elkNameLength: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_street: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                myTrim: true,
                messages: {
                    required: "Улица не указана!",
                    myTrim: "Улица не указана!"
                }
            });
        }
    },
    valid_build: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: true,
                myTrim: true,
                messages: {
                    required: "Дом не указан!",
                    myTrim: "Дом не указан!"
                }
            });
        }
    },
    valid_home_code: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                number: true,
                elkPersonalPhoneValidate: true,
                messages: {
                    notDefaultText : "Код города обязателен к заполнению",
                    required: "Код города обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkPersonalPhoneValidate: "Код города должен содержать не менее 3 цифр."
                }
            });
        }
    },
    valid_city: function(){
        if(this.length>0){
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                myTrim: true,
                messages: {
                    required: "Город не указан!",
                    myTrim: "Город не указан!"
                }
            });
        }
    },
    valid_client_city: function () {
        this.rules('add', {
            maxlength: 40,
            messages: {
                maxlength: 'Ошибка! Количество введенных символов не должно превышать 40 символов.'
            }
        });
    },
    valid_home_phone: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText: true,
                required: !jQuery(this).hasClass('no_required'),
                maxlength: false,
                number: true,
                elkPersonalPhoneValidate: true,
                messages: {
                    notDefaultText : "Номер телефона обязателен к заполнению",
                    required: "Номер телефона обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkPersonalPhoneValidate: "Код города и номер должны содержать 10 цифр."
                }
            });
        }
    },
    valid_modile_code: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                number: true,
                elkMobilePhoneValidate: true,
                messages: {
                    notDefaultText : "Код оператора обязателен к заполнению",
                    required: "Код оператора обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkMobilePhoneValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                    //elkMobilePhoneValidate: "Код оператора должен содержать 3 цифры."
                }
            });
        }
    },
    valid_mobile_code_online_cheque: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                number: true,
                elkMobilePhoneValidate1: true,
                messages: {
                    required: "Код оператора обязателен к заполнению",
                    notDefaultText : "Код оператора обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkMobilePhoneValidate1: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_mobile_phone_online_cheque: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText: true,
                maxlength: false,
                number: true,
                elkMobilePhoneValidate1: true,
                messages: {
                    required: "Номер телефона обязателен к заполнению",
                    notDefaultText : "Номер телефона обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkMobilePhoneValidate1: function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_modile_code_for_mob: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                elkMobilePhoneValidate: true,
                messages: {
                    notDefaultText : "Код оператора обязателен к заполнению",
                    required: "Код оператора обязателен к заполнению",
                    elkMobilePhoneValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                    //elkMobilePhoneValidate: "Код оператора должен содержать 3 цифры."
                }
            });
        }
    },
    valid_mobile_phone: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                maxlength: false,
                number: true,
                elkMobilePhoneValidate: true,
                messages: {
                    notDefaultText : "Номер телефона обязателен к заполнению",
                    required: "Номер телефона обязателен к заполнению",
                    number: "Для ввода допустимы только цифры.",
                    elkMobilePhoneValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                    //elkMobilePhoneValidate: "Номер должен содержать 7 цифр."
                }
            });
        }
    },
    valid_mobile_phone_cart: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                cartMobileCode:true,
                cartMobilePhone:true,
                required: !jQuery(this).hasClass('no_required'),
                messages: {
                    notDefaultText : "Номер телефона обязателен к заполнению",
                    required: "Номер телефона обязателен к заполнению",
                    cartMobileCode: "Неверный код оператора",
                    cartMobilePhone:"Номер телефона должен содержать 10 цифр",
                    cartMobilePhoneNum: "Номер телефона может состоять только из цифр"
                }
            });
        }
    },
    valid_mobile_mask: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                maxlength: false,
                number: false,
                elkMobilePhoneValidate: false,
                newMobilePhoneValidate:true,
                messages: {
                    notDefaultText : "Поле обязательно к заполнению",
                    required: "Поле обязательно к заполнению",
                    newMobilePhoneValidate: "Некорректный код оператора",
                }
            });
        }
    },
    valid_birth_date: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                maxlength: false,
                number: false,
                birthDateValidate: true,
                messages: {
                    notDefaultText : "",
                    required: "Дата рождения не указана!",
                    number: "",
                    birthDateValidate:'Неверный формат даты'
                }
            });
        }
    },
    valid_mobile_phonevalid_mobile_phone_for_mob: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                notDefaultText : true,
                required: !jQuery(this).hasClass('no_required'),
                maxlength: false,
                elkMobilePhoneValidate: true,
                messages: {
                    notDefaultText : "Номер телефона обязателен к заполнению",
                    required: "Номер телефона обязателен к заполнению",
                    elkMobilePhoneValidate: function (value, element) {
                        return jQuery(element).data('error');
                    }
                    //elkMobilePhoneValidate: "Номер должен содержать 7 цифр."
                }
            });
        }
    },
    valid_send_request_cp: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: true,
                messages: {
                    required: "Выберите один из вариантов"
                }
            });
        }
    },
    valid_form_textarea: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required')
                /*messages: {
                 required: "Данное поле необходимо заполнить."
                 }*/
            });
        }
    },
    anketa_valid_mobile_phone: function () {
        if (this.length > 0) {
            jQuery(this).rules("add", {
                required: !jQuery(this).hasClass('no_required'),
                number: true,
                minlength: 7,
                messages: {
                    required: "Номер должен содержать 7 цифр.",
                    minlength: "Номер должен содержать 7 цифр.",
                    number: "Для ввода допустимы только цифры."
                }
            });
        }
    },
    valid_company_name : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                maxlength : 150,
                messages : {
                    required : "Название компании обязательно к заполнению",
                    maxlength : "Максимальное количество символов в поле \"Название компании\" - 150"
                }
            });
        }
    },
    valid_inn : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                myTrim     : true,
                __elkINNValidate: true,
                messages : {
                    required : "ИНН обязателен к заполнению",
                    myTrim: "ИНН заполнено неверно",
                    __elkINNValidate:function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_postcode : function(){
        if(this.length > 0){
            this.value = jQuery(this).val().replace(" ", '');
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __islengthPostCode: true,
                //number : true,
                __isNumber: true,
                messages : {
                    required : "Почтовый индекс обязателен к заполнению",
                    __islengthPostCode: "Индекс должен содержать 6 цифр.",
                    //number: "Для ввода допустимы только цифры."
                    __isNumber: "Для ввода допустимы только цифры."
                }
            });
        }
    },
    valid_bik : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                myTrim   : true,
                __elkBIKValidate:true,
                messages : {
                    required : "БИК обязателен к заполнению",
                    myTrim   : "БИК заполнено неверно",
                    __elkBIKValidate:function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_kpp : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                myTrim   : true,
                __elkKPPValidate:true,
                messages : {
                    required : "КПП обязателен к заполнению",
                    myTrim   : "КПП заполнено неверно",
                    __elkKPPValidate:function (value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_kpp_zero: function() {
        jQuery(this).rules("add", {
            required : false,
            __elkKPPZeroValidate:true,
            messages : {
                __elkKPPZeroValidate:function (value, element) {
                    return jQuery(element).data('error');
                }
            }
        });
    },
    valid_okpo : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __elkOKPOValidate: true,
                messages : {
                    required: "ОКПО обязателен к заполнению",
                    __elkOKPOValidate: function(value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_ogrn : function(){;
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __elkOGRNValidate: true,
                messages : {
                    required : "ОГРН обязателен к заполнению",
                    __elkOGRNValidate: function(value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_okato : function(){;
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __elkOKATOValidate: true,
                messages : {
                    required : "ОКАТО обязателен к заполнению",
                    __elkOKATOValidate: function(value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_settl_account : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __elkSETTLValidate: true,
                messages : {
                    required : "Расчетный счет обязателен к заполнению",
                    __elkSETTLValidate: function(value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_bank_name : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                maxlength : 100,
                messages : {
                    required : "Название банка обязательно к заполнению",
                    maxlength : "Максимальное количество символов в поле \"Название банка\" - 100"
                }
            });
        }
    },
    valid_corr_acount : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                __elkCORRValidate: true,
                messages : {
                    required : "Корр. счет обязателен к заполнению",
                    __elkCORRValidate: function(value, element) {
                        return jQuery(element).data('error');
                    }
                }
            });
        }
    },
    valid_ur_address : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                messages : {
                    required : "Юридический адрес обязателен к заполнению"
                }
            });
        }
    },
    valid_delivery_address : function(){
        if(this.length > 0){
            jQuery(this).rules("add", {
                required : !jQuery(this).hasClass('no_required'),
                messages : {
                    required : "Укажите адрес доставки или \n измените способ получения на шаге Пункт Самовывоза"
                }
            });
        }
    },
    resetForm: function () {
        var getInputState = function (input) {
                return {
                    value: input.value,
                    checked: input.checked
                }
            },
            getInputUniqueId = function (input) {
                return input.id + input.name;
            },
            inputStatesAreEqual = function (firstState, secondState) {
                return (firstState.value == secondState.value) && (firstState.checked == secondState.checked);
            };

        var $form = this,
            inputStateBeforeReset = {};

        $(':input', $form).each(function () {
            inputStateBeforeReset[getInputUniqueId(this)] = getInputState(this);
        });

        $form[0].reset();
        $(':input', $form).each(function () {
            var stateBeforeReset = inputStateBeforeReset[getInputUniqueId(this)],
                stateAfterReset = getInputState(this);

            if (!(inputStatesAreEqual(stateBeforeReset, stateAfterReset))) {
                $(this).change().trigger('refresh');
            }
        });
    },
    setNumber: function (bExtended) {
        // bExtended - флаг указывающий что можно также вводить символы "/" и "-".
        jQuery(this).keypress(function (event, el) {
            return VEnterOnlyDic(event, el, bExtended);
        });
        jQuery(this).keydown(function (event, el) {
            return VEnterOnlyDic(event, el, bExtended);
        });
        return this;
    }
});

function _changeUserPhone(obj) {
    jQuery('div.dl_type_phone').hide();
    jQuery('div.'+jQuery(obj).val()).show();
}


//------------------------------------------------------------------------------------------------//
//-----| Валидаторы. |----------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------//

function elkFormDefaultError(sCode) {
    var obErrors = {
        error: 'Ошибка!',
        no_value: 'Не введено значение.',
        only_16_cart: 'Укажите 16 цифр номера карты.',
        only_4_pin:  'Укажите 4 цифры <span style="white-space:nowrap">PIN-кода</span>.',
        only_digits: 'Для ввода допустимы только цифры.',
        phone_code: '1 Код оператора должен содержать 3 цифры.',
        phone_number: 'Номер должен содержать 7 цифр.',
        homephone_code: 'Код города должен содержать не менее 3 цифр.',
        homephone_number: 'Код города и номер должны содержать 10 цифр.'
    };
    return (sCode in obErrors) ? obErrors[sCode] : obErrors.error;
}

function elkFormError(obElelement, sCode) {
    var obErrors = {
        error: 'Ошибка!',
        email_too_long: 'Количество введенных символов не должно превышать 60 символов.',
        email_incorrect: 'Адрес эл. почты введен некорректно.',
        password_too_long: 'Количество введенных символов не должно превышать 40 символов.',
        name_too_long: 'Количество введенных символов не должно превышать 40 символов.',
        name_too_short: 'Количество введенных символов должно быть 1 и более.',
        name_has_no: 'Введены некорректные данные.',
        name_illegal: 'Введены некорректные символы.',
        name_has_no_vowels: 'Введены некорректные данные.',
        name_has_both_layouts: 'Введите данные, используя одну раскладку клавиатуры.',
        name_has_repeated_symbols: 'Введены некорректные данные.',
        name_mobile_phone_interval: "Код оператора введен неверно.",//Код оператора >900 и <1000
        name_mobile_phone_code: "Код оператора должен содержать 3 цифры.",
        name_USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX  : "Код оператора должен содержать 3 цифры.",
        name_mobile_phone_phone: "Номер должен содержать 7 цифр.",
        name_mobile_has_repeated_symbols: "Введите, пожалуйста, корректный номер телефона.",
        competitor_sku_url_wrong: "Указанный интернет-магазин не входит в список конкурентов по акции «Гарантия низкой цены»",
        date_isnt_correct : "Поле заполнено некорректно.",
        date_current : "Дата не может больше текущей.",
        card_invalid : "Не верный номер карты.",

        isNumber: 'Для ввода допустимы только цифры.',
        index_not_valid : "Индекс должен содержать не менее 6 цифр.",

        inn_empty: 'ИНН пуст',
        inn_only_number: 'ИНН может состоять только из цифр',
        inn_length: 'ИНН может состоять только из 10 или 12 цифр',

        okpo_only_number: 'ОКПО может состоять только из цифр',
        okpo_length: 'ОКПО может состоять только из 8 цифр',

        ogrn_only_number: 'ОГРН может состоять только из цифр',
        ogrn_length: 'Максимальное количество символов в поле "ОГРН" - 50',

        okato_only_number: 'ОКАТО может состоять только из цифр',
        okato_length: 'Максимальное количество символов в поле "ОКАТО" - 50',

        settl_only_number: 'В поле "Расчетный счет" допустимы только цифры',
        settl_length: 'Допустимое количество символов в поле "Расчетный счет" - 20',

        corr_only_number: 'В поле "Корр.счет" допустимы только цифры',
        corr_length: 'Допустимое количество символов в поле "Корр.счет" - 20',

        kpp_only_number: 'КПП может состоять только из цифр',
        kpp_error: 'КПП может состоять только из 9 цифр',
        kpp_use_dash: 'Для пустого kpp используйте \"-\"',

        bik_only_number: 'БИК может состоять только из цифр',
        bik_length: 'БИК может состоять только из 9 цифр'
    };
    obElelement.data('error',  (sCode in obErrors) ? obErrors[sCode] : obErrors.error);
    return false;
}
function elkIsNumber(value, element) {
    var obField = jQuery(element);
    obField.data('error', null);
    if(value.match(/[^0-9\s]/)) {
        return elkFormError(obField, 'isNumber');
    }
    return true;
}

function validateOKPO(okpo, element) {
    var obField = jQuery(element),
        error = new Object(),
        required = !jQuery(element).hasClass('no_required');

    obField.data('error', null);
    if (typeof okpo === 'number') {
        okpo = okpo.toString();
    } else if (typeof okpo !== 'string') {
        okpo = '';
    }
    if (okpo === '-')
        return true;

    if (!okpo.length) {
        if (required) {
            error.code = 1;
            error.message = 'no_value';
        }
    } else if (/[^0-9]/.test(okpo)) {
        error.code = 2;
        error.message = 'okpo_only_number';
    } else if (okpo.length > 0 && okpo.length !== 8) {
        error.code = 3;
        error.message = 'okpo_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateOGRN(ogrn, element) {
    var obField = jQuery(element),
        result = false,
        error = new Object(),
        required = !jQuery(element).hasClass('no_required');

    obField.data('error', null);
    if (typeof ogrn === 'number') {
        ogrn = ogrn.toString();
    } else if (typeof ogrn !== 'string') {
        ogrn = '';
    }
    if (!ogrn.length && required) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(ogrn)) {
        error.code = 2;
        error.message = 'ogrn_only_number';
    } else if (ogrn.length > 50) {
        error.code = 3;
        error.message = 'ogrn_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateSETTL(settl, element) {
    var obField = jQuery(element),
        result = false,
        error = new Object(),
        required = !jQuery(element).hasClass('no_required');

    obField.data('error', null);
    if (typeof settl === 'number') {
        settl = settl.toString();
    } else if (typeof settl !== 'string') {
        settl = '';
    }
    if (!settl.length && required) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(settl)) {
        error.code = 2;
        error.message = 'settl_only_number';
    } else if (settl.length > 0 && settl.length !== 20) {
        error.code = 3;
        error.message = 'settl_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateCORR(corr, element) {
    var obField = jQuery(element),
        result = false,
        error = new Object(),
        required = !jQuery(element).hasClass('no_required');

    obField.data('error', null);
    if (typeof corr === 'number') {
        corr = corr.toString();
    } else if (typeof corr !== 'string') {
        corr = '';
    }
    if (!corr.length && required) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(corr)) {
        error.code = 2;
        error.message = 'corr_only_number';
    } else if (corr.length > 0 && corr.length !== 20) {
        error.code = 3;
        error.message = 'corr_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateOKATO(okato, element) {
    var obField = jQuery(element),
        result = false,
        error = new Object(),
        required = !jQuery(element).hasClass('no_required');

    obField.data('error', null);
    if (typeof okato === 'number') {
        okato = okato.toString();
    } else if (typeof okato !== 'string') {
        okato = '';
    }
    if (!okato.length && required) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(okato)) {
        error.code = 2;
        error.message = 'okato_only_number';
    } else if (okato.length > 50) {
        error.code = 3;
        error.message = 'okato_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateINN(inn, element) {
    var obField = jQuery(element);
    var result = false;
    var error = new Object();

    obField.data('error', null);
    if (typeof inn === 'number') {
        inn = inn.toString();
    } else if (typeof inn !== 'string') {
        inn = '';
    }
    if (!inn.length) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(inn)) {
        error.code = 2;
        error.message = 'inn_only_number';
    } else if ([10, 12].indexOf(inn.length) === -1) {
        error.code = 3;
        error.message = 'inn_length';
    } else {
        result = true;
        /*    Проверка на реальный ИНН    *
        result = false;
        var checkDigit = function (inn, coefficients) {
            var n = 0;
            for (var i in coefficients) {
                n += coefficients[i] * inn[i];
            }
            return parseInt(n % 11 % 10);
        };
        switch (inn.length) {
            case 10:
                var n10 = checkDigit(inn, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if (n10 === parseInt(inn[9])) {
                    result = true;
                }
                break;
            case 12:
                var n11 = checkDigit(inn, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                var n12 = checkDigit(inn, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if ((n11 === parseInt(inn[10])) && (n12 === parseInt(inn[11]))) {
                    result = true;
                }
                break;
        }
        /* ------- */

        if (!result) {
            error.code = 4;
            error.message = 'name_has_no';
        }
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateKPP(kpp, element) {
    var obField = jQuery(element);
    var error = new Object();

    obField.data('error', null);

    if (typeof kpp === 'number') {
        kpp = kpp.toString();
    } else if (typeof kpp !== 'string') {
        kpp = '';
    }
    if (!kpp.length) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(kpp)) {
        error.code = 2;
        error.message = 'kpp_only_number';
    } else if (kpp.length !== 9) {
        error.code = 3;
        error.message = 'kpp_error';
    }


    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}
function validateKPPZero(kpp, element) {
    var obField = jQuery(element);
    var error = new Object();

    obField.data('error', null);

    if (kpp == "-") {
        return true;
    }

    if (!kpp.length) {
        error.code = 1;
        error.message = 'kpp_use_dash';
    } else if (/[^0-9]/.test(kpp)) {
        error.code = 2;
        error.message = 'kpp_only_number';
    } else if (kpp.length !== 9) {
        error.code = 3;
        error.message = 'kpp_error';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;
}

function validateBIK(bik, element) {
    var obField = jQuery(element);
    var error = new Object();

    obField.data('error', null);

    if (typeof bik === 'number') {
        bik = bik.toString();
    } else if (typeof bik !== 'string') {
        bik = '';
    }
    if (!bik.length) {
        error.code = 1;
        error.message = 'no_value';
    } else if (/[^0-9]/.test(bik)) {
        error.code = 2;
        error.message = 'bik_only_number';
    } else if (bik.length !== 9) {
        error.code = 3;
        error.message = 'bik_length';
    }

    if(error.code > 0){
        return elkFormError(obField, error.message);
    }
    return true;

}

function elkIsMinMaxlength(value, element) {
    var obField = jQuery(element);
    obField.data('error', null);
    value = obField.val().replace(/\s*/g, '');
    if(value.length != 6) {
        return elkFormError(obField, 'index_not_valid');
    }
    return true;
}
function elkEmailValidate(value, element) {
    var obEmail = jQuery(element);

    if(value.length <= 0) {
        return true; // Если поле обязательное, то делаем validate -> rules -> required.
    }
    obEmail.data('error', null);
    if(value.length > 60) {
        return elkFormError(obEmail, 'email_too_long');
    }
    var emailRegex = /^[a-zA-Z0-9-_]{1,}\.?([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]*@((([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+\-)*[a-zA-Z0-9]+\.[a-zA-Z]{2,6})|(([а-яА-ЯёЁ0-9]+\.)*([а-яА-ЯёЁ0-9]+\-)*[а-яА-ЯёЁ0-9]+\.[а-яА-ЯёЁ]{2,6}))$/;

    if (!emailRegex.test(value)) {
        return elkFormError(obEmail, 'email_incorrect');
    }

    /* var arDogs = value.match(/@/g);
     // 02
     if(!arDogs || (arDogs.length != 1)) {
         return elkFormError(obEmail, 'email_incorrect');
     } else {
         var emailparts = value.split('@');
         var emailLogin = emailparts[0];
         var emailDomain = emailparts[1];

         // 04
         if (!emailDomain.match(/\./)) {
             return elkFormError(obEmail, 'email_incorrect');
         }

         // 06
         if (value.substring(0,1)=='.' || value.substring(value.length-1,value.length)=='.') {
             return elkFormError(obEmail, 'email_incorrect');
         }

         //01,03
         var loginRegExp = /^[a-zA-Z0-9-_]{1,}\.?([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+$/;
         if(!loginRegExp.test(emailLogin)){
             return elkFormError(obEmail, 'email_incorrect');
         }
         if (emailLogin.match(/[^-_a-zA-Z0-9\.]/)) {
             return elkFormError(obEmail, 'email_incorrect');
         }
         if (emailDomain.match(/[^-_a-zA-Zа-яА-ЯёЁ0-9\.]/)) {
             return elkFormError(obEmail, 'email_incorrect');
         }

         //05
         var domainZone = emailDomain.substring(emailDomain.lastIndexOf('.')+1,emailDomain.length);
         if (domainZone.match(/[^a-zA-Zа-яА-ЯёЁ]/) || domainZone.length<2 || domainZone.length>6) {
             return elkFormError(obEmail, 'email_incorrect');
         }

         if (emailDomain.match(/[a-zA-Z]/) && emailDomain.match(/[а-яА-ЯёЁ]/)) {
             return elkFormError(obEmail, 'email_incorrect');
         }

         if (value.match(/\.\./)) {
             return elkFormError(obEmail, 'email_incorrect');
         }
     }*/

    return true;
}

function ElkEnterOnlyDic(event) {
    var ctrlDown = event.ctrlKey||event.metaKey;
    var currentKeyCode = event.which,

        // Код клавиши "V"
        vKeyCode = 86,

        /* Коды спецклавиш
         * 8 = Backspace
         * 9 = Tab
         * 13 = Enter
         * 17 = Ctrl
         * 35 = End
         * 36 = Home
         * 37 = Arrow Left
         * 39 = Arrow Right
         * 46 = Delete
         */
        specialKeyCodes = [0, 8, 9, 13, 17, 35, 36, 37, 39, 46];

    if((ctrlDown && event.which==65) || event.which==17) return true; //Crtl+a

    // Допускается использование вставки по Ctrl+V
    if ((currentKeyCode == vKeyCode) && event.ctrlKey) return;

    // Допускается использование спецклавиш
    if (jQuery.inArray(currentKeyCode, specialKeyCodes) >= 0) return;

    // Допускается использование цифровых клавиш для ввода цифр
    var currentKeyIsNumeric =
        (currentKeyCode >= 48 && currentKeyCode <= 57)      // Стандартные цифровые клавиши
        || (currentKeyCode >= 96 && currentKeyCode <= 105); // Цифровые клавиши NumPad

    if (currentKeyIsNumeric && ! (event.ctrlKey || event.shiftKey || event.altKey)) return;

    // Остальные комбинации клавиш не допускаются
    event.preventDefault();
}

function ElkCardValidate(value, element) {
    var obCard = jQuery(element);
    var bReturn = false;
    if(value.length != 0) {
        var cardValue = value.replace(/\s/gi, "");
        if(cardValue.length!=16 || isNaN(cardValue)) {
            jQuery('.carderror')
                .html("Неверно указан Номер карты, повторите попытку")
                .show();
        } else {
            var i = 0;
            var aSum = 0;
            while(ch = cardValue.substr(i, 1)) {
                var number_ch = Number(ch);
                if((i % 2) == 1) {
                    aSum += number_ch;
                } else {
                    if(number_ch*2 >= 10) {
                        aSum += 1 + (number_ch*2)%10;
                    } else {
                        aSum += number_ch*2;
                    }
                }
                i += 1;
                if(i == 15) {
                    break;
                }
            }

            var validCorrect = ((10 - (aSum % 10)) % 10);
            if(validCorrect == Number(cardValue.substr(15, 1))) {
                bReturn = true;
            } else {
                return elkFormError(obCard, 'card_invalid');
            }
        }
    }
    return bReturn;
}

function elkFormatName(element) {
    jQuery(element).change(function(){
        var value = jQuery(this).val();
        value = jQuery.trim(value);
        value = value.toLowerCase();

        value = value.replace(/(\s+)/g, " "); // multimple spaces to one
        value = value.replace(/^[-\s]+|[-\s]+$/g, ""); //stars or ends with \s or "-"
        value = (value + '').replace(/^([a-zа-я])|(\s|\-)+([a-zа-я])/g, function ($1) {
            return $1.toUpperCase();
        });

        jQuery(this).val(value);
    });
}

function elkNameLength(value, element) {
    var obName = jQuery(element);
    if (value.length < 2) {
        return elkFormError(obName, 'name_too_short');
    }
    return true;
}

function elkNameValidate(value, element) {
    var obName = jQuery(element);
    if(value.length <= 0) {
        return true; // Если поле обязательное, то делаем validate -> rules -> required.
    }
    obName.data('error', null);
    if(value.length > 40) {
        return elkFormError(obName, 'name_too_long');
    }

    if(value.length < 1) {
        return elkFormError(obName, 'name_too_short');
    }

    if(value.match(/^нет$/i)) {
        return elkFormError(obName, 'name_has_no');
    }

    if(value.match(/[^A-Za-z\-А-Яа-яЁё\s]/)) {
        return elkFormError(obName, 'name_illegal');
    }

    if(!value.match(/[AaEeIiOoUuYy]/) && !value.match(/[АаЕеЁёИиОоУуЫыЭэЮюЯя]/)) {
        return elkFormError(obName, 'name_has_no_vowels');
    }

    if(value.match(/[A-Za-z]/) && value.match(/[А-Яа-яЁё]/)) {
        return elkFormError(obName, 'name_has_both_layouts');
    }

    if(value.match(/([a-z\-а-яё])\1{2}/ig)) {
        return elkFormError(obName, 'name_has_repeated_symbols');
    }

    return true;
}

function elkMobilePhoneValidate(value, element, code, number){
    if (!jQuery(code).val().length && !jQuery(number).val().length) {
        return true;
    }
    jQuery(element).data('error', null);
    if (jQuery(element).attr("name") == jQuery(code).attr("name")) {
        if (value.length != 3) {
            elkFormError(jQuery(element), 'name_mobile_phone_code');
            return false;
        }
        if (!(value>=900 && value<1000)) {
            elkFormError(jQuery(element), 'name_mobile_phone_interval');
            return false;
        }
        return true;
    }
    if (jQuery(element).attr("name") == jQuery(number).attr("name")) {
        if (value.length && value.length != 7) {
            elkFormError(jQuery(element), 'name_mobile_phone_phone');
            return false;
        }
        if (value.match(/1234567/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        if (value.match(/([0-9]+)\1{5,}/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        return true;
    }
}

function newMobilePhoneValidate(value, element) {
    var operatorCode = value.substring(
        value.lastIndexOf("(") + 1,
        value.lastIndexOf(")")
    );

    if (!(operatorCode>=900 && operatorCode<1000)) {
        return false;
    }

    if (operatorCode.length != 3) {
        return false;
    }

    return true;
}

function elkMobilePhoneValidate1(value, element, code, number){
    var code = jQuery("#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_PRFX");
    var number = jQuery("#USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR");
    if (!jQuery(code).val().length && !jQuery(number).val().length) {
        return true;
    }
    jQuery(element).data('error', null);
    if (jQuery(element).attr("name") == jQuery(code).attr("name")) {
        if(jQuery(element).hasClass('no_required')){
            return true;
        }
        if (value.length != 3) {
            elkFormError(jQuery(element), 'name_mobile_phone_code');
            return false;
        }
        if (!(value>=900 && value<1000)) {
            elkFormError(jQuery(element), 'name_mobile_phone_interval');
            return false;
        }
        return true;
    }
    if (jQuery(element).attr("name") == jQuery(number).attr("name")) {
        if(jQuery(element).hasClass('no_required')){
            return true;
        }
        if (value.length && value.length != 7) {
            elkFormError(jQuery(element), 'name_mobile_phone_phone');
            return false;
        }
        if (value.match(/1234567/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        if (value.match(/([0-9]+)\1{5,}/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        return true;
    }
    if (jQuery(element).attr("name") == 'USER_ONLINE_CHEQUE_DELIVERY_TYPE_SMS_NMBR') {
        if (value.length && value.length != 7) {
            elkFormError(jQuery(element), 'name_mobile_phone_phone');
            return false;
        }
        if (value.match(/1234567/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        if (value.match(/([0-9]+)\1{5,}/)) {
            elkFormError(jQuery(element), 'name_mobile_has_repeated_symbols');
            return false;
        }
        return true;
    }
}

function elkPersonalPhoneValidate(value, element, code, number){
    if( !jQuery(code).val().length  && !jQuery(number).val().length) {
        return true;
    }
    var numsize = 10 - jQuery(code).val().length;
    if (jQuery(element).attr("name") == jQuery(code).attr("name")) {
        if(value.length < 3) {
            return false;
        }
        /*if( (jQuery(code).val().length + jQuery(number).val().length) != 10) {
            jQuery(number).valid();
        }*/
        return true;
    }else if( jQuery(element).attr("name") == jQuery(number).attr("name")) {
        if(value.length != numsize) {
            return false;
        }
        return true;
    }
    return false;
}
function cartMobileCode(elem){
    var operatorCode = elem.substring(
        elem.lastIndexOf("(") + 1,
        elem.lastIndexOf(")")
    );

    if (!(operatorCode>=900 && operatorCode<1000)) {
        return false;
    }

    if (operatorCode.length != 3) {
        return false;
    }

    return true;
}
function cartMobilePhone(elem){

    var value = elem.replace(/[-+()_ ]/g, '');
    if (value.match(/[^0-9\s]/)) {
        return false;
    }
    if (value.length && value.length != 11) {
        return false;
    }
    return true;
}

function notMoreCurrentDate(value, element){
    var obName = jQuery(element);
    if(!value.length) {
        return true;
    }

    var curDate = new Date();

    var newDate = value;
    var arr = newDate.split('.');
    newDate = arr[2]+"-"+arr[1]+"-"+arr[0];
    newDate = new Date(newDate)
    obName.data('error', null);
    if(newDate > curDate) {
        return elkFormError(obName, 'date_current');
    }
    return true;

}

function doGetCaretPosition (ctrl) {
    var iCaretPos = 0;
    if(document.selection) {
        ctrl.focus();
        var sel = document.selection.createRange();
        sel.moveStart ('character', -ctrl.value.length);
        iCaretPos = sel.text.length;
    } else if(ctrl.selectionStart || ctrl.selectionStart == '0') {
        iCaretPos = ctrl.selectionStart;
    }
    return iCaretPos;
}

new function($) {
    $.fn.setCursorPosition = function(pos) {
        if ($(this).get(0).setSelectionRange) {
            $(this).get(0).setSelectionRange(pos, pos);
        } else if ($(this).get(0).createTextRange) {
            var range = $(this).get(0).createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }
}(jQuery);


function VEnterOnlyDic(event, obj, bExtended) {
    if(bExtended) {
        var bExt = jQuery.inArray(event.which, [45,47,109,111,189,191,17,86,187,43,37,38,39,40,61,107]) != -1;
        if(!bExt && event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57) && (event.which < 96 || event.which > 105)) return false;
    } else {
        if((event.which != 46 && event.which != 39 && event.which != 37 && event.which != 13 && event.which != 9 && event.which != 8 && event.which != 86 && event.which != 17
            && event.which != 0
            && (event.which < 48 || event.which > 57)
            && (event.which < 96 || event.which > 105)
        ) || (event.which === 37 && event.shiftKey)
        ) return false;
    }
}


function interceptKeys(evt) {
    evt = evt||window.event // IE support
    var c = evt.keyCode
    var ctrlDown = evt.ctrlKey||evt.metaKey // Mac support

    // Check for Alt+Gr (http://en.wikipedia.org/wiki/AltGr_key)

    if (ctrlDown && evt.altKey) return true

    // Check for ctrl+c, v and x
    else if (ctrlDown && c==67) return false // c
    else if (ctrlDown && c==86) return false // v
    else if (ctrlDown && c==88) return false // x
    else if (ctrlDown && c==65) return false // a
    // Otherwise allow
    return true
}

new function($) {
    $.fn._eventEnterCard = function() {
        $(this).change(function(){
            $(this).val(formatCard($(this).val()));
        });

        $(this).keypress(function(event, el){
            $(this).val(formatCard($(this).val()));
        });

        var ctrlDown = false;
        var ctrlA = false;
        var ctrlV = false;
        var ctrlC = false;

        $(this).keydown(function(event, el){
            var self = $(this);
            //17 - ctrl
            //91 - cmd (для mac)
            if(!ctrlDown && (event.which == 17 || event.which == 91)) {
                ctrlDown = true;
                return;
            }
            //65 - a
            //86 - v
            //67 - c
            ctrlA = (ctrlDown && event.which == 65);
            ctrlV = (ctrlDown && event.which == 86);
            ctrlC = (ctrlDown && event.which == 67);

            ctrlDown = false;
        });

        $(this).keyup(function(event, el){
            var self = $(this);

            if( !(ctrlA || ctrlC || ctrlV) ) { $(this).val( formatCard(self.val()) ); }
        });
    }
}(jQuery);
function formatCard(str) {
    str = str.replace(/\D/g, '');
    if(str.length > 16) {
        str = str.substr(0, 16);
    }
    var new_str = '';
    for (var i = 0; i < str.length; i = i + 4) {
        new_str = new_str + str.substr(i, 4) + ' ';
    }
    new_str = new_str.slice(0, -1);
    return new_str;
}

/**
 * Функция форматирует номер карты.
 * Передается элемент input, если значение совпадает с placeholder'ом, то не форматируется
 *
 * @param elem
 * @returns {*}
 */
function formatCardInput(elem) {
    var value = elem.val();
    var placeholder = elem.attr("placeholder");

    if (value == placeholder) {
        return value;
    } else {
        return formatCard(value);
    }
}

/**
 * Функция для ограничения ввода количества символов
 */
function validateNumberPhone(obj, i){
    if (obj.value.length > i) {
        obj.value = obj.value.slice(0,i);
    }
}