$(function () {

    $('#phone').usPhoneFormat();

    $("#registerForm").validate({
        ignore: ":hidden:not(#iAccept, .not-ignore)",
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true,
                //remote: SITE_URL + '/users/isUniqueEmail',
                remote: {
                    url: SITE_URL + '/users/isUniqueEmail',
                    data: {
                        email: function () {
                            return $("#Email").val();
                        }
                    },
                    complete: function (resp) {
                        if (resp.responseText == "false") {
                            var newModal = new Custombox.modal({
                                overlay: {
                                    close: false
                                },
                                content: {
                                    target: "#emailAlreadyExistsModal",
                                    effect: "slide",
                                    animateFrom: "bottom",
                                    animateTo: "top",
                                    positionX: "center",
                                    positionY: "center",
                                    speedIn: 300,
                                    speedOut: 300,
                                    fullscreen: false,
                                    onClose: function () {
                                        //
                                    }
                                }
                            });
                            newModal.open();


                        }
                        return resp;
                    }

                }
            },
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            address: {
                required: true
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            zip: {
                required: true,
                maxlength: 5
            },
            i_accept: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name."
            },
            email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "Email already exists"
            },
            password: {
                required: "Please enter password.",
                minlength: "Password must be greater than 8 characters",
                pwcheck: "Password must contain atleast one capital character and one numeric."
            },
            confirm_password: {
                required: "Please confirm password.",
                equalTo: "Password does not match."
            },
            phone: {
                required: "Please enter phone number."
            },
            address: {
                required: "Please enter address."
            },
            city: {
                required: "Please enter city name."
            },
            state: {
                required: "Please enter state name."
            },
            zip: {
                required: "Please enter zip.",
                maxlength: "Zip must be less than 5 characters."
            },
            i_accept: {
                required: "Please accept terms and conditions."
            }
        }
    });


});

$(document).on('ready', function () {
    // initialization of tabs
    $.HSCore.components.HSTabs.init('[role="tablist"]');

    // initialization of go to
    $.HSCore.components.HSGoTo.init('.js-go-to');

    $('.select-user-type').click(function () {
        $('.select-user-type').removeClass('active');
        $(this).addClass('active');
        $('.select-user-form').hide();
        $('#' + $(this).attr('id') + 'Form').fadeIn();
    });
});

$(window).on('load', function () {
    // initialization of header
    $.HSCore.components.HSHeader.init($('#js-header'));
    $.HSCore.helpers.HSHamburgers.init('.hamburger');

    // initialization of HSMegaMenu component
    $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
    });
});

$(window).on('resize', function () {
    setTimeout(function () {
        $.HSCore.components.HSTabs.init('[role="tablist"]');
    }, 200);
});
