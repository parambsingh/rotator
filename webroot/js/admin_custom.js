 function cl(a){ console.log(a); }
$(function () {
    $('[name="phone"], [name="User[phone]"]').usPhoneFormat();
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

    $('.hs-admin-calendar').click(function () {
        $('.datepicker input').focus();
    });

    // $( document ).ajaxSend(function() {
    //     console.log('Sending Request');
    //     pleaseWait();
    // });
    //
    // $( document ).ajaxComplete(function() {
    //     console.log('Request Complete');
    //     Custombox.modal.close('pleaseWaitModal');
    // });

});
