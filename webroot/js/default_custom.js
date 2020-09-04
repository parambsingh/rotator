$(function () {
    $('[name="phone"]').usPhoneFormat();
    $.validator.addMethod("pwcheck", function (value) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/.test(value) // consists of only these
            &&
            /[A-Z]/.test(value) // has a uppercase letter
            &&
            /\d/.test(value); // has a digit
    }, "Password must contain atleast one capital character and one numeric.");

    $.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

    setTimeout(function () {
        if(PAGE_NAME == "Realtorsdashboard" || PAGE_NAME == "Apartmentsdashboard") {
            getNewMessageCount();
        }
    }, 1500);

    function getNewMessageCount() {
        $.ajax({
            url: SITE_URL + 'messages/newMessageCount',
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $('#newMessageCount').hide();
            },
            success: function (response) {
                if (response.data.newMessageCount > 0) {
                    //var messageCount = (response.data.newMessageCount > 99) ? "99+" : response.data.newMessageCount;
                    //$('#newMessageCount').html(messageCount);
                    $('#newMessageCount').fadeIn();
                } else {
                    $('#newMessageCount').hide();
                }

                if (response.data.apartmentSpecialCount > 0) {
                    //var aptSpCount = (response.data.apartmentSpecialCount > 99) ? "99+" : response.data.apartmentSpecialCount;
                    //$('#newApartmentSpecialCount').html(aptSpCount);
                    $('#newApartmentSpecialCount').fadeIn();
                } else {
                    $('#newApartmentSpecialCount').hide();
                }

            }
        });
    }

    $('.hs-admin-calendar, .hs-admin-angle-down').click(function () {
        $('.datepicker input').focus();
    });

    $(document).ajaxError(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
        if (thrownError == "Forbidden") {
            window.location.href = SITE_URL + 'users';
        }
    });

});

(function ($) {
    $.fn.blink = function (options) {
        var defaults = {delay: 500};
        var options = $.extend(defaults, options);
        return $(this).each(function (idx, itm) {
            var handle = setInterval(function () {
                if ($(itm).css("visibility") === "visible") {
                    $(itm).css('visibility', 'hidden');
                } else {
                    $(itm).css('visibility', 'visible');
                }
            }, options.delay);

            $(itm).data('handle', handle);
        });
    }
    $.fn.unblink = function () {
        return $(this).each(function (idx, itm) {
            var handle = $(itm).data('handle');
            if (handle) {
                clearInterval(handle);
                $(itm).data('handle', null);
                $(itm).css('visibility', 'inherit');
            }
        });
    }
}(jQuery));
