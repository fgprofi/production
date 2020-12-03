var bonusCardOK = false;
var checkCardTimer = false;
var checkCaptchaCardTimer = false;
var bonusCardState = true;
var RegistrationError = {
    showAll: function (errors) {
        $.each(errors, function (key, value) {
            if (value == '') {
                return;
            }
            switch (key) {
                case 'email':
                    RegistrationError.show('regEmail', value);
                    break;
                case 'name':
                    RegistrationError.show('regName', value);
                    break;
                case 'lastName':
                    RegistrationError.show('regLastName', value);
                    break;
                case 'password':
                    RegistrationError.show('regPassConf', value);
                    break;
                case 'cardNumber':
                    RegistrationError.show('regCard', value);
                    break;
                case 'issueCard':
                    RegistrationError.show('regPin', value);
                    break;
            }
        });
    },
    show: function (containerClass, value) {
        var errorContainer = $('.' + containerClass).next('.regError:first');
        errorContainer.find('.regErrorMid').html(value);
        if (value && value.length) {
            $(document).trigger('auth.registration.error', {error: value});
            errorContainer.addClass('enabled');
            var errorBox = errorContainer.find('.errorBox');
            //func in responsive.js
            adjustWarning(errorBox.parents('.regError'));
            if (errorBox.length > 0 && ! errorBox.is(':visible')) {
                errorBox.show();
            }
        }
    },
    hide: function (containerClass) {
        var errorContainer = $('.' + containerClass).next('.regError:first');
        //errorContainer.find('.regErrorMid').html('');
        errorContainer.removeClass('enabled');
    },
    hideAll: function() {
        $('.regError').removeClass('enabled');
        $('.regInputMod').removeClass('regInputError');
    }
};

var formFieldFromCardProfile = {
    name: null,
    last_name: null,
    email: null
};

var formFieldFilledByUser = {
    name: null,
    last_name: null,
    email: null
};

function isCoBrandCard(){
    var cardValue = $('input.regCard').val().replace(/\s/gi, '');
    if( cardValue.match(/^9643774(59|60|61)[0-9]{7}$/) && cardValue.length == 16 ){
        return  ((cardValue == '9643774609549633') || (cardValue >= '9643774599142431' && cardValue <= '9643774599342833') || (cardValue >= '9643774609551647' && cardValue <= '9643774611001623') || (cardValue >= '9643774609043041' && cardValue <= '9643774609543040'));
    }

    return false;
}

$(document).ready(function(){
    /* ***** поля формы регистрации ***** */

    // Форматирование полей ФИО
    elkFormatName($('.regName, .regLastName, .regSecondName'));

    // Если включен CAPS LOCK, покажем иконку
    $('.regPasswordWrap ').keypress(function(e) {
        var s = String.fromCharCode( e.which );
        if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
            $('.pass_more').addClass('enabled');
        } else {
            $('.pass_more').removeClass('enabled');
        }
    });
    /* ***** /поля формы регистрации ***** */

    jQuery('.regPasswordWrap input[name="USER_PASSWORD"]').keyup(function(event) {
        // убрал проверку на backspace и delete, так как иначе не обновляется поле,
        // а вообще моргание происходит из-за /home/ivan/www/eldorado/repo/htdocs/static/js/redesign2/auth.js:299
        // в этом же коммите там оставил комментарий.

        showQualityPass($(this).val());

        var ctrlDown = event.ctrlKey||event.metaKey;
        if((ctrlDown && event.which==65) || event.which==17 || event.which==65) return true; //Crtl+a

        if (jQuery.inArray(event.which, [9,37,39]) >= 0) {
            return true;
        }
        jQuery(this).copy_password();
    }).keydown(function(event){
        var ctrlDown = event.ctrlKey||event.metaKey;
        if((ctrlDown && event.which==65) || event.which==17) return true; //Crtl+a
    });

    $(document).on('auth.registrationLink.click', function() {
        showQualityPass(jQuery('.regPasswordWrap input[name="USER_PASSWORD"]').val());
    });

    /* ***** /сабмит формы регистрации ***** */

    /* ***** привязка карты ***** */

    // показывать хэлперы при фокусе на инпуты карты и пина
    $('input.regCard')
        .live({
            focusin: function() {
                if( !isCoBrandCard() ) {
                    $('.regNumberHelp').show();
                }
            },
            focusout: function() {$('.regNumberHelp').hide();}
        })
        .keydown(function(event){
            ElkEnterOnlyDic(event);
            if( isCoBrandCard() ) {
                $('.regNumberHelp').hide();
                RegistrationError.show('regCard', 'Для карты «Хоум Кредит-Эльдорадо» доступна только авторизация.');
            }
        })._eventEnterCard();
    $('input.regPin')
        .live({
            focusin: function() {
                if( !isCoBrandCard() ){
                    $('.regPinHelp').show();
                }
                if(!$(this).val()) {
                    $(this).attr('placeholder', '');
                }
            },
            focusout: function() {
                $('.regPinHelp').hide();
                if(!$(this).val()) {
                    $(this).attr('placeholder', 'PIN');
                }
            }
        })
        .keydown(function(event){
            ElkEnterOnlyDic(event);
        });

    // перейти на поле пин при вводе 19-ти символов в поле номера карты
    $('.regCard').keyup(function(event){
        if (event.which != 16 && event.which != 9) {
            if ($('.regCard').val().length == 19) {
                //Фикс для IE
                var $regPin = $(".regPin");
                if ($.browser.msie) {
                    $(".regPinDub").hide();
                    $regPin.show();
                    $regPin.focus();
                }
                else {
                    $regPin.focus();
                }
                return;
            }
        }
        hideFields(false);
        fillForm(formFieldFilledByUser, false);
        $('.regCardCorrectImg').removeClass('enabled');
    });
    // перейти на поле имейл при вводе 4-х символов в поле пин
    $('.regPin').keyup(function(event){
        if (event.which != 16 && event.which != 9) {
            if ($('.regPin').val().length == 4) {
                $(".regEmail").focus();
                return;
            }
        }
        hideFields(false);
        fillForm(formFieldFilledByUser, false);
        $('.regCardCorrectImg').removeClass('enabled');
    });

    $('#NEW_NAME, #NEW_LAST_NAME, #NEW_EMAIL').change(function() {
        var el = $(this);
        var map = {
            NEW_NAME: 'name',
            NEW_LAST_NAME: 'last_name',
            NEW_EMAIL: 'email'
        };
        var key = map[el.attr('id')];
        formFieldFilledByUser[key] = el.val();
        $('.regInputSubmit').css('background-image', 'url("/static/images/redesign2/registration/regInputSubmit.png")');
        $('.regInputSubmit').attr('rel', '');
    });


    function checkCardEvent(){
        var cardNumber = $('.regCard');
        var cardPin = $('.regPin');
        var recaptcha = $('#g-recaptcha-registration').find("textarea[name='g-recaptcha-response']").val();
        var okValues = cardPin.val().length == 4 && cardNumber.val().length == 19;
        if(typeof recaptcha === 'undefined' || recaptcha == ''){
            if (okValues) {
                clearInterval(checkCaptchaCardTimer);
                checkCaptchaCardTimer = setInterval(function() {
                    var recaptcha = $('#g-recaptcha-registration').find("textarea[name='g-recaptcha-response']").val();
                    if(typeof recaptcha !== 'undefined' && recaptcha.length > 0){
                        clearInterval(checkCaptchaCardTimer);
                        checkCardEvent();
                    }
                }, 1000);
            }
            return true;
        }
        var checkStatus = {
                valid:false,
                message: ''
            },
            isChecked = false;
        if(checkCardTimer > 0)
            clearTimeout(checkCardTimer);
        checkCardTimer = setTimeout(function() {
            bonusCardOK = false;
            if (okValues) {
                checkStatus = checkCard(cardNumber.val(), cardPin.val(), recaptcha);


                if (checkStatus.success) {
                    $('.regCardCorrectImg').addClass('enabled');
                    cardNumber.removeClass('regInputError');
                    cardPin.removeClass('regInputError');
                    RegistrationError.hide('regCard');
                } else {
                    $('.regCardCorrectImg').removeClass('enabled');
                    cardNumber.addClass('regInputError');
                    cardPin.addClass('regInputError');
                    RegistrationError.show('regCard', checkStatus.message);
                    recaptcha_init('g-recaptcha-registration');
                }

                if (checkStatus.data !== undefined && checkStatus.data.userProfile.name !== undefined) {
                    formFieldFromCardProfile = setProfile(formFieldFromCardProfile, checkStatus.data.userProfile);
                    fillForm(formFieldFromCardProfile, true);
                }
                bonusCardOK = checkStatus.success;
                regFormValidate();
            }
        }, 2000);
    }

    // псевдо проверка номера карты и пина
    // -> результат проверки карты и пина, используется для определения возможности сабмита формы
    $('.regPin, .regCard').blur(function(event) {
        var ctrlDown = event.ctrlKey||event.metaKey;
        if((ctrlDown && event.which==65) || event.which==17 || event.which==65) return true; //Crtl+a

        checkCardEvent();
    });



    $('.popupReg input').keyup(function() {
        var val = $(this).val();
        if (val.length) {
            regFormValidate(this, val);
        }
    });
    // див новой карты не должен показываться при активном чекбоксе "у меня есть бонусная карта"

    /* ***** детали ***** */
    $('#bonus_card').change(function() {
        cardToggle(this.checked);
    });
    /* ***** /детали ***** */

    $('#USER_CARD').change(function () {
        var val = $(this).val();
        if (val.length) {
            regFormValidate(this, val);
        }
    });

    if (window.location.hash.substr(1) == 'open-popup' && window.location.pathname == '/'){
        $('.popupReg').showPopup(300);
        $('.shadeDark').fadeTo(300, 0.5);
        $('.regBonusCardNew').show();
        $('.popupReg').addClass('wideState');
        $(document).trigger('auth.registrationLink.click', {});
    }

}); // ---------------- / document ready

/**
 * скрыть поля
 * @param {Boolean} hide
 */
function hideFields(hide) {
    if (hide) {
        $('#NEW_NAME').parent('div').hide();
        $('#NEW_LAST_NAME').parent('div').hide();
        $('#NEW_EMAIL').parent('div').hide();
    } else {
        $('#NEW_NAME').parent('div').show();
        $('#NEW_LAST_NAME').parent('div').show();
        $('#NEW_EMAIL').parent('div').show();
    }
}

/**
 * Обновим, только те поля, которые пришли не пустыми
 * @param currentProfile
 * @param fromCardProfile
 * @returns {*}
 */
function setProfile(currentProfile, fromCardProfile) {
    jQuery.each(fromCardProfile, function (key, val) {
        if (val != undefined /*&& val.length > 0*/) {
            currentProfile[key] = val;
        }
    });
    return currentProfile;
}

function fillForm(data, isProfile) {
    var map = {
        name: {el: $('#NEW_NAME'), hide: true},
        last_name: {el: $('#NEW_LAST_NAME'), hide: true},
        email: {el: $('#NEW_EMAIL'), hide: false}
    };
    jQuery.each(map, function(name, item) {
        var value = data[name];

        var el = item.el;
        var needHide = isProfile ? item.hide : false;
        if (isProfile && value && value.length) {
            el.val(value);
            if (item.hide) {
                el.parent('div').hide();
            }
        } else if (!isProfile) {
            el.val(value);
            el.parent('div').show();
        }
    });
}

// тогл дива с инпутами карты
function cardToggle(isVisible) {
    $('.regCardInputWrap').toggle(isVisible);

    if (!$('.regContainer').hasClass('thankYou')) {
        $('.regPaymentTypeLabel').toggle(!isVisible);
    }

    $('.regPasswordWrap input').toggleClass('regInputBMargin', isVisible);
    $('.regCardLabel').toggleClass('regCardLabelBlack', isVisible);

    if(isVisible) {
        var obClear = $('.regMainInfo').find('.clearOnCheckbox');
        if(obClear.length) {
            obClear.remove();
        }
    }

    hideFields(false);

    $('.regCard, .regPin').val('');
    $('.regCard, .regPin').removeClass('regInputError');
    RegistrationError.hide('regCard');
    RegistrationError.hide('regPin');
    $('.regCardCorrectImg').removeClass('enabled');

    if (!isVisible) { // блок номера карты скрыт
        $.each(formFieldFilledByUser, function (key, value) {
            var $field = $('#popupRegForm').find('#NEW_' + key.toUpperCase());
            if (!value && $field.val().length > 0) {
                formFieldFilledByUser[key] = $field.val();
            }
        });
        fillForm(formFieldFilledByUser);
    } else {
        recaptcha_init('g-recaptcha-registration');
        $('.regMiddle input').each(function(){
            if($(this).val().length !==0){
                $(this).keyup();
            }
        });
    }
    bonusCardOK = false;
    regFormValidate($('#bonus_card'), isVisible);
}
/**
 * На странице "спасибо" не вызывается! .regBonusCardNew там не показывается!
 */
function processNewCardPopup() {
    // При открытии попапа регистрации, при необходимости показываем попап получения новой карты
    $('.popupReg').on('showPopupAfter', function () {
        //БЗ динамическая защита от вызова на спасибо.
        if ($('.regContainer').hasClass('thankYou')) {
            return;
        }
        if (!$('#bonus_card').is(':checked')) {
            $('.regBonusCardNew').show();
            $('.popupReg').addClass('wideState');
            $('.regPaymentTypeLabel').show();
        } else {
            $('.regBonusCardNew').hide();
            $('.popupReg').removeClass('wideState');
        }

    });

    // див новой карты не должен показываться при активных чекбоксах "У меня есть бонусная карта" и "Я юридическое лицо"
    $('#bonus_card, #user_payment_type_popup').change(function(){
        //БЗ динамическая защита от вызова на спасибо.
        if ($('.regContainer').hasClass('thankYou')) {
            return;
        }
        var $newBonusCardBlock = $('.regBonusCardNew');

        if ($('#bonus_card').is(':checked') || $('#user_payment_type_popup').is(':checked') || $('#NEW_BIRTHDAY').hasClass('js-under-18')) {
            $newBonusCardBlock.hide();
            $('.popupReg').removeClass('wideState');
        } else {
            $newBonusCardBlock.show();
            $('.popupReg').addClass('wideState');
        }
    });
}
/**
 * На странице "спасибо" не вызывается! Регистрационная форма там не очищается!
 *
 */
function bindResetRegistrationForm() {
    //защита от вызова на спасибо.
    if ($('.regContainer').hasClass('thankYou')) {
        return;
    }
    $('.popupReg')
        .bind('closePopupCallbackAfter', function (event) {
            if (event.target !== event.currentTarget) return;

            if (typeof resetRegistrationFormState == 'function') {
                var $registrationForm = $(this).find('form');
                resetRegistrationFormState($registrationForm);
            }
        });
}
/* ***** /привязка карты ***** */

// включить сабмит, если все поля заполнены и бонусная карта прошла проверку
function regFormValidate(element, value) {
    var isCard = false;
    if ($('#bonus_card-styler').hasClass('checked')) {
        isCard = bonusCardOK
    } else {
        isCard = true;
    }
    if($(element).hasClass('regCard')){
        if(value.length < 19) {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regCard', (value == '')?'Введите номер карты.':'Номер карты введен некорректно.');
        }else{
            if( isCoBrandCard() ){
                $(element).siblings('.regError').addClass('enabled');
                $(element).addClass('regInputError');
                RegistrationError.show('regCard', 'Для карты «Хоум Кредит-Эльдорадо» доступна только авторизация.');
            }else{
                $(element).siblings('.regError').removeClass('enabled');
                $(element).removeClass('regInputError');
            }
        }
    }
    if($(element).hasClass('regPin')){
        if(value.length < 4) {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regPin', (value == '')?'Введите PIN-код.':'PIN-код введен некорректно.');
        }else{
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }
    if($(element).hasClass('regEmail')){
        if(!/^[a-zA-Z0-9-_]{1,}\.?([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]*@((([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+\-)*[a-zA-Z0-9]+\.[a-zA-Z]{2,6})|(([а-яА-ЯёЁ0-9]+\.)*([а-яА-ЯёЁ0-9]+\-)*[а-яА-ЯёЁ0-9]+\.[а-яА-ЯёЁ]{2,6}))$/.test(value) || value == '') {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regEmail', (value == '')?'Адрес эл. почты не заполнен.':'Адрес эл. почты введен некорректно.');
        }else{
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }
    if ($(element).hasClass('regName') || $(element).hasClass('regSecondName') || $(element).hasClass('regLastName')) {
        let elClass = '';
        if ($(element).hasClass('regName')) {
            elClass = 'regName';
        }
        else if ($(element).hasClass('regSecondName')) {
            elClass = 'regSecondName';
        }
        else if ($(element).hasClass('regLastName')) {
            elClass = 'regLastName';
        }

        let hasError = false;

        if (value.match(/^нет$/i) || (!value.match(/[AaEeIiOoUuYy]/) && !value.match(/[АаЕеЁёИиОоУуЫыЭэЮюЯя]/)) || value.match(/([A-Za-z\-А-Яа-яЁё])\1{2,}/)) {
            RegistrationError.show(elClass, 'Введены некорректные данные.');
            hasError = true;
        }
        if (value.match(/[^A-Za-z\-А-Яа-яЁё\s]/)) {
            RegistrationError.show(elClass, 'Введены некорректные символы.');
            hasError = true;
        }
        if (value.match(/[A-Za-z]/) && value.match(/[А-Яа-яЁё]/)) {
            RegistrationError.show(elClass, 'Введите данные, используя одну раскладку клавиатуры.');
            hasError = true;
        }
        if (value.length > 40) {
            RegistrationError.show(elClass, 'Количество введенных символов не должно превышать 40 символов.');
            hasError = true;
        }
        if(elClass !== 'regSecondName' && value.length === 0) {
            RegistrationError.show(elClass, 'Обязательное поле');
        }
        if (!hasError) {
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }
    if($(element).parent('.regPasswordWrap').length > 0){
        if($('input[name="NEW_PASSWORD_CONFIRM"]').val().length < 6 || $('input[name="NEW_PASSWORD_CONFIRM"]').val() == '') {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regPassConf', 'Длина не менее 6 символов.');
        }else{
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }
    if ($(element).hasClass('regBirthday')) {
        let date = value.split('.');
        let day = parseInt(date[0]);
        let month = parseInt(date[1]) - 1;
        let year = parseInt(date[2]);
        let birthDay = new Date(year, month, day);

        if (!(birthDay.getFullYear() === year && birthDay.getMonth() === month && birthDay.getDate() === day)) {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regBirthday', 'Неверная дата рождения.');
        } else if (birthDay > new Date() || birthDay.getFullYear() < 1900) {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regBirthday', 'Неверная дата рождения.');
        } else if (birthDay > new Date().setFullYear(new Date().getFullYear() - 18)) {
            // Запрет регистрации для несовершеннолетних
            $(element).siblings('.regError').addClass('enabled').width(302);
            $(element).addClass('regInputError');
            RegistrationError.show('regBirthday', 'Участие в Программе Лояльности возможно с 18 лет');
        } else {
            if (!$('#bonus_card').is(':checked') && !$('#user_payment_type_popup').is(':checked')) {
                $('.popupReg .help_popup_trigger').show();
                $('.popupReg .regPaymentTypeLabel').show();
                $('.popupReg .regCardLabel').show();
                $('.popupReg .regBonusCardNew').show();
                $('.popupReg').addClass('wideState');
            }
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }
    if ($(element).hasClass('regPhone')) {
        if (value === '+7 (___) ___ ____') {
            value = '';
        }
        let pattern = /\+7\s\(9\d{2}\)\s\d{3}\s\d{4}$/;
        if (!pattern.test(value)) {
            $(element).siblings('.regError').addClass('enabled');
            $(element).addClass('regInputError');
            RegistrationError.show('regPhone', (value === '') ? 'Телефон не указан.' : 'Неверный номер телефона.');
        } else {
            $(element).siblings('.regError').removeClass('enabled');
            $(element).removeClass('regInputError');
        }
    }

    var errorCount = $('.regInputError').length;
    if (errorCount == 0 && $('.regEmail').val() != "" && $('.regName').val() != "" && ($('#user_payment_type_popup').is(':checked') || ($('.regPhone').val() != "" &&  $('.regBirthday').val() != ""))  && $('input[name="NEW_PASSWORD_CONFIRM"]').val().length > 5 && isCard) {
        $('.regInputSubmit').removeClass('regInputSubmitDisabled');
    } else { // если пользователь очищает инпут, сабмит недоступен
        $('.regInputSubmit').addClass('regInputSubmitDisabled');
    }
}

/**
 * Проверить карту на существование
 * @param {Integer} number
 * @param {Integer} pin
 * @param {String} recaptcha
 */
function checkCard(number, pin, recaptcha) {
    var result = {
            valid: false,
            message: '',
            userProfile: {}
        },
        data = {
            cardNumber: number,
            cardPin: pin,
            'g-recaptcha-response': recaptcha
        };

    $.ajax({
        type: "POST",
        url: '/_ajax/loyalty/checkCard.php',
        data: data,
        async: false,
        success: function (response) {
            var messageContainer = $('.popupReg').find('.regMainInfo');
            result = response;
            if (result.notification) {
                messageContainer.html('<p>' + result.notification + '</p>');
            } else {
                messageContainer.html('');
            }
        },
        error: function () {
            result.success = false;
            result.message = 'Ошибка.';
            result.type = 'error';
        }
    });
    return result;
}

/**
 * Сбрасывает состояние формы регистрации
 */
function resetRegistrationFormState($registrationForm)
{
    $registrationForm.resetForm();

    // Сбросить кеш введенных пользователем данных
    for (var prop in formFieldFilledByUser) {
        if (formFieldFilledByUser.hasOwnProperty(prop)) {
            formFieldFilledByUser[prop] = null;
        }
    }
    $('input[name="NEW_PASSWORD_CONFIRM"]').val('');

    // Скрыть информационные сообщения и сообщения об ошибках
    $('.regMainError, .regMainInfo').empty();
    RegistrationError.hideAll();

    // Необходимо сбросить вручную значения текстовых полей, т.к. они изменяются JavaScript'ом, и reset формы их не учитывает
    $('.regInputMod').val(null);

    // Перевести кнопку в состояние disabled
    $('.regInputSubmit').addClass('regInputSubmitDisabled');
    bonusCardOK = false;
}

var Lv = {};
Lv.FormToolTip = function () {
    var instance = {

        target: null,
        toolTipEl: null,
        position: 'l', // L,R
        text: '',
        customCss: '',

        /**
         * Конструктор
         * @param {Object} config
         */
        __construct: function() {
        },

        init: function() {

            var positionClassSide = this.position == 'l' ? 'L' : 'R',
                positionClass = this.position == 'l' ? 'regErrorLeft' : 'regErrorRight';

            if (this.customCss.length) {
                positionClass += ' ' + this.customCss;
            }

            var start = this.position == 'l' ? 'regErrorEnd' : 'regErrorStart';
            var end = this.position == 'l' ? 'regErrorStart' : 'regErrorEnd';

            this.toolTipEl = $('<div/>', {
                'class': 'regError ' + positionClass
            })
                .append($('<table/>')
                    .append($('<tr/>')
                        .append($('<td/>', {'class': start + positionClassSide}))
                        .append($('<td/>', {'class': 'regErrorMid', text: this.text}))
                        .append($('<td/>', {'class': end + positionClassSide}))
                    )
                );
            this.toolTipEl.insertAfter(this.target);
        },

        setText: function(message) {
            this.text = message;
        },

        setPosition: function(position) {
            this.position = position;
        },

        setCustomCss: function(cssClass) {
            this.customCss = cssClass;
        },

        setTarget: function(el) {
            this.target = el;
        },

        show: function(el) {
            this.init();
            this.toolTipEl.show();
        }
    };
    instance.__construct();
    return instance;
};