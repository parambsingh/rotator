$(document).ready(function () {

    $('#apartmentPhone, #realtorPhone').usPhoneFormat();

    $('.js-select').selectpicker();

    $("#realtorEmail, #apartmentEmail").keyup(function () {
        $(this).val($.trim($(this).val()));
    }).keydown(function () {
        $(this).val($.trim($(this).val()));
    });

    $("#apartmentRegisterForm").validate({
        ignore: ":hidden:not(#apartmentIAccept, .not-ignore)",
        rules: {
            apartment_name: {
                required: true
            },
            company_id: {
                required: true
            },
            company_name: {
                required: false
            },
            email: {
                required: true,
                email: true,
                //remote: SITE_URL + '/users/isUniqueEmail',
                remote: {
                    url: SITE_URL + '/users/isUniqueEmail',
                    data: {
                        email: function () {
                            return $("#apartmentEmail").val();
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
                equalTo: "#apartmentPassword"
            },
            phone: {
                required: true,
                phoneUS: true
            },
            address: {
                required: true
            },
            city_id: {
                required: true
            },
            state_id: {
                required: true
            },
            zip: {
                required: true,
                maxlength: 5
            },
            how_did_you_find_apt_net: {
                required: true,
            },
            how_did_you_find_us: {
                required: true
            },

            i_accept: {
                required: true
            }
        },
        messages: {
            apartment_name: {
                required: "Please enter apartment name."
            },
            company_id: {
                required: "Please select management company."
            },
            company_name: {
                required: "Please enter management company name."
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
            city_id: {
                required: "Please select city name."
            },
            state_id: {
                required: "Please select state name."
            },
            zip: {
                required: "Please enter zip.",
                maxlength: "Zip must be less than 5 characters."
            },
            how_did_you_find_apt_net: {
                required: "Please select how did you find us.",
            },
            how_did_you_find_us: {
                required: "Please fill this field."
            },
            i_accept: {
                required: "Please accept terms and conditions."
            }
        },
        submitHandler: function (form) {
            var options = {direction: 'left'};
            $('#signUpApartmentUserForm').hide('drop', options, 700, function () {
                $("#signUpApartmentInfoForm").fadeIn();
            });
            return false;
        }
    });


    $(document).on("click", "#apartmentInfoBackBtn", function (e) {
        e.preventDefault();
        var options = {direction: 'right'};
        $('#signUpApartmentInfoForm').hide('drop', options, 700, function () {
            $("#signUpApartmentUserForm").fadeIn();
        });
    });

    $(document).on("click", "#apartmentEmailPriorityBackBtn", function (e) {
        e.preventDefault();
        var options = {direction: 'right'};
        $('#signUpApartmentEmailPriorityForm').hide('drop', options, 700, function () {
            $("#signUpApartmentInfoForm").fadeIn();
        });
    });

    $('#apartmentStateId').change(function () {
        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'Cities', match: 'state_id'},
            dataType: "json",
            beforeSend: function () {
                $('#apartmentCitiesSelectBox').hide();
                $('#loadingApartmentCities').show();
            },
            success: function (response) {
                $('#loadingApartmentCities').show();
                if (response.suggestions.length > 0) {
                    var options = [];
                    options.push('<option class="bs-title-option" value="">City</option>');
                    $.each(response.suggestions, function (index, data) {
                        options.push('<option value="' + data.value + '">' + data.label + '</option>');
                    });

                    $('#loadingApartmentCities').hide();
                    $('#apartmentCitiesSelectBox').fadeIn();

                    $('#apartmentCityId').html(options.join(''));

                    //$('#apartmentCityId').selectpicker('refresh');
                }

            }
        });

        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'MarketPlaces', match: 'state_id'},
            dataType: "json",
            success: function (response) {
                if (response.suggestions.length > 0) {
                    var options = [];
                    options.push('<option class="bs-title-option" value="">City</option>');
                    $.each(response.suggestions, function (index, data) {
                        options.push('<option value="' + data.value + '" data-content=\'<span class="d-flex align-items-center w-100">' + data.label + '</span>\'>' + data.label + '</option>');
                    });

                    $('#apartmentMarketPlaceId').html(options.join(''));

                    $('#apartmentMarketPlaceId').selectpicker('refresh');
                }

            }
        });
    });


    $("#apartmentInfoForm").validate({
        ignore: ".ignore",
        rules: {
            manager_name: {
                required: true
            },
            regional_manager_name: {
                required: true
            },
            manager_email: {
                required: true,
                email: true,
                //remote: SITE_URL + 'users/isUniqueEmail',
                // remote: {
                //     url: SITE_URL + 'users/isUniqueEmail',
                //     type: "get",
                //     data: {
                //         email: function () {
                //             return $("#accounting-email").val();
                //         }
                //     }
                // }
            },
            regional_manager_email: {
                email: true,
                required: true,
                //remote: SITE_URL + 'users/isUniqueEmail',
                // remote: {
                //     url: SITE_URL + 'users/isUniqueEmail',
                //     type: "get",
                //     data: {
                //         email: function () {
                //             return $("#reporting-email").val();
                //         }
                //     }
                // }
            }

        },
        messages: {
            manager_name: {
                required: "Please enter manager name.",
            },
            regional_manager_name: {
                required: "Please enter regional manager name.",
            },
            manager_email: {
                required: "Please enter manager email.",
                email: "Please enter valid email.",
                // remote: "Email already exists"
            },
            regional_manager_email: {
                required: "Please enter regional manager email.",
                email: "Please enter valid email.",
                //remote: "Email already exists"
            }
        },
        submitHandler: function () {
            var options = {direction: 'left'};
            $('#signUpApartmentInfoForm').hide('drop', options, 700, function () {
                $("#signUpApartmentEmailPriorityForm").fadeIn();
            });
            return false;
        }

    });


    $("#apartmentEmailPriorityForm").validate({
        rules: {
            'realtor_inquiry_priority': {required: true},
            'customer_referral_priority': {required: true},
            'marketing_email_priority': {required: true},
        },
        messages: {
            'realtor_inquiry_priority': {required: "Please select realtor inquiry email priority."},
            'customer_referral_priority': {required: "Please select customer referral email priority."},
            'marketing_email_priority': {required: "Please select marketing email priority."},
        },
        submitHandler: function () {
            $('#apartmentInfoBtn').html('<i class="fa fa-spinner fa-spin"></i> processing...').attr('disabled', 'disabled');
            $.ajax({
                url: SITE_URL + "apartment-users/add",
                type: "POST",
                data: $("#apartmentRegisterForm").serialize() + "&" + $("#apartmentInfoForm").serialize() + "&" + $("#apartmentEmailPriorityForm").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.code == 200) {

                        var options = {direction: 'right'};
                        $('#mainSection').hide('size', options, 700, function () {
                            $('#successMsg').html('Now it is time to log into your account and upload your floorplans details along with the apartment images.');
                            $("#thankYouSection").fadeIn();
                        });
                    } else {
                        $('#anyErrorFromServer').html(response.message);
                        $('#apartmentInfoBtn').html('Sign Up').removeAttr('disabled');
                    }
                }
            });
            return false;
        }
    });


    $('.apartment-find-us-via').click(function () {
        console.log('hear');
        if ($(this).attr('id') == "apartmentFindViaInternet") {
            $("#apartmentHowDidYouFindUs").attr('placeholder', 'Google, Bing or Yahoo');
        }

        if ($(this).attr('id') == "apartmentFindViaOther") {
            $("#apartmentHowDidYouFindUs").attr('placeholder', 'Other..');
        }

        if ($(this).attr('id') == "apartmentFindViaApartmentCommunity") {
            $("#apartmentHowDidYouFindUs").attr('placeholder', 'Apartment Community');
        }

        if ($(this).attr('id') == "apartmentFindViaRealtor") {
            $("#apartmentHowDidYouFindUs").attr('placeholder', 'Realtor Name');
        }

    });


    $("#realtorRegisterForm").validate({
        ignore: ":hidden:not(#realtorIAccept, .not-ignore)",
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            company: {
                required: true
            },
            email: {
                required: true,
                email: true,
                //remote: SITE_URL + '/users/isUniqueEmail'
                remote: {
                    url: SITE_URL + '/users/isUniqueEmail',
                    data: {
                        email: function () {
                            return $("#realtorEmail").val();
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
                equalTo: "#realtorPassword"
            },
            phone: {
                required: true,
                phoneUS: true
            },
            how_did_you_find_apt_net: {
                required: true,
            },
            how_did_you_find_us: {
                required: true
            },

            i_accept: {
                required: true
            }
        },
        messages: {
            first_name: {
                required: "Please enter first name."
            },
            last_name: {
                required: "Please enter last name."
            },
            company: {
                required: "Please enter company name."
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
            how_did_you_find_apt_net: {
                required: "Please select how did you find us.",
            },
            how_did_you_find_us: {
                required: "Please fill this field."
            },
            i_accept: {
                required: "Please accept terms and conditions."
            }
        },
        submitHandler: function (form) {
            var options = {direction: 'left'};
            $('#signUpRealtorUserForm').hide('drop', options, 700, function () {
                $("#signUpRealtorInfoForm").fadeIn();
            });
            return false;
        }
    });

    $(document).on("click", "#realtorInfoBackBtn", function (e) {
        e.preventDefault();
        var options = {direction: 'right'};
        $('#signUpRealtorInfoForm').hide('drop', options, 700, function () {
            $("#signUpRealtorUserForm").fadeIn();
        });
    });


    $('.find-us-via').click(function () {
        if ($(this).attr('id') == "realtorFindViaInternet") {
            $("#realtorHowDidYouFindUs").attr('placeholder', 'Google, Bing or Yahoo');
        }

        if ($(this).attr('id') == "realtorFindViaOther") {
            $("#realtorHowDidYouFindUs").attr('placeholder', 'Other..');
        }

        if ($(this).attr('id') == "realtorFindViaApartmentCommunity") {
            $("#realtorHowDidYouFindUs").attr('placeholder', 'Apartment Community');
        }

        if ($(this).attr('id') == "realtorFindViaRealtor") {
            $("#realtorHowDidYouFindUs").attr('placeholder', 'Realtor Name');
        }

    });


    $("#realtorInfoForm").validate({
        ignore: ".ignore",
        rules: {
            address: {
                required: true
            },
            city_id: {
                required: true
            },
            state_id: {
                required: true
            },
            zip: {
                required: true,
                maxlength: 5
            },
            licence_number: {
                required: true
            },
            state_licensed_in: {
                required: true
            }
        },
        messages: {
            address: {
                required: "Please enter address."
            },
            city_id: {
                required: "Please enter city name."
            },
            state_id: {
                required: "Please enter state name."
            },
            zip: {
                required: "Please enter zip.",
                maxlength: "Zip must be less than 5 characters."
            },
            licence_number: {
                required: "Please enter licence number."
            },
            state_licensed_in: {
                required: "Please select state."
            }
        },
        submitHandler: function (form) {
            var options = {direction: 'left'};
            $('#signUpRealtorInfoForm').hide('drop', options, 700, function () {
                $("#signUpRealtorChooseCities").fadeIn();
            });

            return false;
        }
    });

    $('#searchCityByName').keyup(function () {
        var key = $(this).val();
        $(".city-main").hide();
        if (key.length > 0 && key != "") {
            $(".city-main[data-name^='" + key.toLowerCase() + "']:not(:empty)").show();
        } else {
            $(".city-main:not(:empty)").show();
        }
    });

    $('#searchCityByName').keydown(function () {
        var key = $(this).val();
        $(".city-main:not(:empty)").hide();
        if (key.length > 0 && key != "") {
            $(".city-main[data-name^='" + key.toLowerCase() + "']:not(:empty)").show();
        } else {
            $(".city-main").show();
        }
    });


    $("#addMarketPlaceForm").validate({
        ignore: ":hidden:not(.not-ignore)",
        rules: {
            'city[]': {required: true}
        },
        messages: {
            'city[]': {required: "Please choose atleast one city."}
        },
        submitHandler: function (form) {

            var options = {direction: 'left'};
            $('#signUpRealtorChooseCities').hide('drop', options, 700, function () {
                $("#signUpRealtorEmailPriority").fadeIn();
            });

            return false;
        }
    });

    $("#addMarketPlaceForm").validate({
        ignore: ":hidden:not(.not-ignore)",
        rules: {
            'city[]': {required: true}
        },
        messages: {
            'city[]': {required: "Please choose atleast one city."}
        },
        submitHandler: function (form) {

            $('#realtorInfoBtn').html('<i class="fa fa-spinner fa-spin"></i> processing...').attr('disabled', 'disabled');

            $.ajax({
                url: SITE_URL + "realtors/add",
                type: "POST",
                data: $("#realtorRegisterForm").serialize() + "&" + $("#realtorInfoForm").serialize() + "&" + $("#addMarketPlaceForm").serialize() + "&" + $("#addEmailPriorityForm").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.code == 200) {

                        var options = {direction: 'left'};
                        $('#mainSection').hide('size', options, 700, function () {

                            $("#thankYouSection").fadeIn();
                        });
                    } else {
                        $('#anyErrorFromServer').html(response.message);
                        $('#realtorInfoBtn').html('Sign Up').removeAttr('disabled');
                    }
                }
            });
            return false;
        }
    });

    $("#addEmailPriorityForm").validate({
        ignore: ":hidden:not(.not-ignore)",
        rules: {
            'apartment_special_priority': {required: true},
            'apartment_replies_priority': {required: true},
        },
        messages: {
            'apartment_special_priority': {required: "Please select apartment special email priority."},
            'apartment_replies_priority': {required: "Please select apartment reply email priority."},
        },
        submitHandler: function (form) {

            $('#realtorInfoBtn').html('<i class="fa fa-spinner fa-spin"></i> processing...').attr('disabled', 'disabled');

            $.ajax({
                url: SITE_URL + "realtors/add",
                type: "POST",
                data: $("#realtorRegisterForm").serialize() + "&" + $("#realtorInfoForm").serialize() + "&" + $("#addMarketPlaceForm").serialize() + "&" + $("#addEmailPriorityForm").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.code == 200) {
                        $('#successMsg').html('Thank you for signing up with Apartment Network.  Our administrators are reviewing your account and will email you shortly.  Make sure to check your spam folder.');
                        var options = {direction: 'left'};
                        $('#mainSection').hide('size', options, 700, function () {
                            $("#thankYouSection").fadeIn();
                        });
                    } else {
                        $('#anyErrorFromServer').html(response.message);
                        $('#realtorInfoBtn').html('Sign Up').removeAttr('disabled');
                    }
                }
            });
            return false;
        }
    });


    $('#selectAll').click(function (e) {
        $('.select-row').prop('checked', true);
        $(this).addClass('active');
        $('#deselectAll').removeClass('active');
        $('.choose-cities').hide();
        $('.all-cities-selected').fadeIn();
        $('.select-row').prop('checked', true);
    });

    $('#deselectAll').click(function (e) {
        $(this).addClass('active');
        $('#selectAll').removeClass('active');

        $('.select-row').prop('checked', false);
        $('#selectedCities .select-row').click();
        $('.all-cities-selected').hide();
        $('.choose-cities').fadeIn();
    });

    $('#chooseCities').on('click', '.select-row', function (e) {
        var totalChecks = $('.select-row').length;
        var checkedChecks = $('.select-row:checked').length;

        $('#selectAll').prop('checked', ((totalChecks == checkedChecks) ? true : false));


        var cityId = $(this).val();
        $('<div/>', {
            id: 'selectedCity_' + cityId,
            class: "col-md-12"
        }).appendTo('#selectedCities').append($('#citiBox_' + cityId).html());

        $('#citiBox_' + cityId).html("");
        $('#citiBox_' + cityId).hide();
        $('#city_' + cityId).prop('checked', true);
    });

    $('#selectedCities').on('click', '.select-row', function (e) {
        var cityId = $(this).val();
        $('#city_' + cityId).prop('checked', true);
        $('#citiBox_' + cityId).html($('#selectedCity_' + cityId).html())
        $('#selectedCity_' + cityId).remove();
        $('#citiBox_' + cityId).fadeIn();
        $('#city_' + cityId).prop('checked', false);
    });

    $('#realtorChooseCitiesBackBtn').click(function (e) {
        e.preventDefault();
        var options = {direction: 'right'};
        $('#signUpRealtorChooseCities').hide('drop', options, 700, function () {
            $("#signUpRealtorInfoForm").fadeIn();
        });
    });

    $('#realtorEmailPriorityBackBtn').click(function (e) {
        e.preventDefault();
        var options = {direction: 'right'};
        $('#signUpRealtorEmailPriority').hide('drop', options, 700, function () {
            $("#signUpRealtorChooseCities").fadeIn();
        });
    });

    $('#realtorStateId').change(function () {
        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'Cities', match: 'state_id', do_not_check_status: true},
            dataType: "json",
            beforeSend: function () {
                $('#citiesSelectBox').hide();
                $('#loadingRealtorCities').show();
            },
            success: function (response) {
                if (response.suggestions.length > 0) {
                    var options = [];
                    options.push('<option class="bs-title-option" value="">City</option>');
                    $.each(response.suggestions, function (index, data) {
                        options.push('<option value="' + data.value + '">' + data.label + '</option>');
                    });

                    $('#loadingRealtorCities').hide();
                    $('#citiesSelectBox').fadeIn();

                    $('#realtorCityId').html(options.join(''));

                    //$('#realtorCityId').selectpicker('refresh');
                }

            }
        });
    });
    $('#realtorStateLicensedInId').change(function () {
        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'Cities', match: 'state_id', do_not_check_status: true},
            dataType: "json",
            beforeSend: function () {
                $('#selectedLicensedStateName').val($.trim($('#realtorStateLicensedInId').find("option:selected").text()));
                //$('#selectAll').html("Select All Cities in " + $.trim($('#realtorStateLicensedInId').find("option:selected").text()));
                //$('#deselectAll').html("Deselect All Cities in " + $.trim($('#realtorStateLicensedInId').find("option:selected").text()));
                $("#chooseCities").html("<h3>Fetching Cities ...</h3>");
                $('#searchCityBox').hide();
            },
            success: function (response) {
                if (response.suggestions.length > 0) {
                    $('#searchCityBox, #selectAllCitiesBox').fadeIn();
                    $("#chooseCities").html("");
                    $.template("checkTmpl", $('#checkTmpl').html());
                    $.tmpl("checkTmpl", response.suggestions).appendTo("#chooseCities");
                }
            }
        });

        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'MarketPlaces', match: 'state_id'},
            dataType: "json",
            success: function (response) {
                if (response.suggestions.length > 0) {
                    $.template("marketPlaceTmpl", $('#marketPlaceTmpl').html());
                    $.tmpl("marketPlaceTmpl", response.suggestions).appendTo("#chooseMarketPlaces");
                }

            }
        });
    });


    $('#chooseMarketPlaces').on('click', '.market-place-select-row', function (e) {
        var checked = $(this).is(':checked');
        $.ajax({
            url: SITE_URL + 'users/getOptions',
            type: "POST",
            data: {query: $(this).val(), find: 'MarketPlaceCities', match: 'market_place_id', label: 'city_id'},
            dataType: "json",
            success: function (response) {
                if (response.suggestions.length > 0) {
                    $.each(response.suggestions, function (i, city) {
                        if (checked) {
                            $('#chooseCities #city_' + city.label).click();
                        } else {
                            $('#selectedCities #city_' + city.label).click();
                        }
                    });
                }

            }
        });

    });

    $('#NeverToBoth').click(function () {
        if ($(this).is(':checked')) {
            $('#realtorApartmentRepliesPriority, #realtorApartmentSpecialEmailPriority').val('Never');
            $("#realtorApartmentRepliesPriority").rules("add", {required: false});
            $("#realtorApartmentSpecialEmailPriority").rules("add", {required: false});
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
