var marker, i, drawingManager, map, infoWindow, bounds;
var markers = [];
var APTs = [];
var selectedAPTs = {};

var selectedAPTsByIds = {};
var selectedAptIds = [];
var searchedAptIds = [];
var aptFloorPlans = {};

var formattedAPTs = [];
var selectionColor = "#faad10";
var deselectionColor = "#222e44";
var noFPColor = "#999999";
var selectionIcon = "fa-check-square";
var deselectionIcon = "fa-square-o";
var makeSelection = 0;
var searchItemIndex = 0;
var currentApartmentId = 0;
var MAP_PIN_O = 'M125 410 c-56 -72 -111 -176 -120 -224 -7 -36 11 -83 49 -124 76 -85 223 -67 270 31 28 60 29 88 6 150 -19 51 -122 205 -148 221 -6 3 -32 -21 -57 -54z m110 -175 c35 -34 33 -78 -4 -116 -35 -35 -71 -37 -105 -7 -40 35 -43 78 -11 116 34 41 84 44 120 7z';

var PAGE = 1;
var LOADING_APARTMENTS = false;
var APARTMENTS_FOUND = 0;

var selectedAptFloorPlans = {};
var selectedAptFloorPlanNotes = {};

var moveBtn, selectBtn, deselectBtn;


var icon = {
    path: MAP_PIN_O,
    fillColor: deselectionColor,
    fillOpacity: 1,
    strokeColor: '#fff',
    strokeWeight: 0.5,
    scale: 0.1,
};

var searchFilterSelected = false;
var searchSaved = false;

var currentCall = null;

var removeAptId = 0;
var removeAptIndex = 0;


$(function () {

    $('#contactPhone').usPhoneFormat();
    // initialization of range datepicker
    // $('.js-range-datepicker').flatpickr({
    //     altInput: true,
    //     altFormat: "F j, Y",
    //     dateFormat: "Y-m-d",
    //     minDate: "today",
    //     onChange: function (selectedDates, dateStr, instance) {
    //         $('#moveDateError').hide();
    //     },
    // });

    // initialization of range datepicker
    moveDate = flatpickr('.js-range-datepicker', {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today",
        static: true,
        onChange: function (selectedDates, dateStr, instance) {
            $('#moveDateError').hide();
        }
    });


    // initialization of range datepicker
    // contactMoveDate = flatpickr('.js-range-datepicker-contact', {
    //     altInput: true,
    //     altFormat: "F j, Y",
    //     dateFormat: "Y-m-d",
    //     minDate: "today",
    //     static: true
    // });

    setTimeout(function () {
        $('#searchCity').focus();
    }, 500);

    $('#searchedApartments').on('click', '.mark-favorite', function () {

        var index = parseInt($(this).parent().attr('apartment-index'));
        var id = parseInt($(this).parent().attr('apartment-id'));

        $(this).children().hasClass(deselectionIcon) ? showApartmentDetails(id, index) : manageSelectedApartments(id, index, 'remove');
    });

    $('#selectedApartmentsInPopup').on('click', '.mark-favorite', function () {
        var id = parseInt($(this).parent().attr('apartment-id'));
        var index = parseInt($(this).parent().attr('apartment-index'));
        manageSelectedApartments(id, index, 'remove');
    });


    $("#apartmentProfilePage").on('click', '.add-to-client-list, .update-apartment-list', function (e) {
        e.preventDefault();
        var id = $(this).attr('apartment-id');
        var index = $(this).attr('apartment-index');
        $('.selectFloorPlanError').fadeOut();
        if ($('.customer_list_apartment_floor_plan_ids:checked').length > 0 && typeof  referraledAPTs[currentApartmentId] == "undefined") {
            openReferralPopup();
        } else {
            if (typeof  selectedAptFloorPlans[currentApartmentId] == "undefined" || $(this).hasClass('top-update-btn')) {
                selectFloorPlanError();
            } else {
                if (selectedAptFloorPlans[currentApartmentId].length <= 0) {
                    selectFloorPlanError();
                } else {
                    manageSelectedApartments(id, index, 'add');
                    Custombox.modal.close();
                }
            }
        }
    });
    // $("#apartmentProfilePage").on('click', '#registerPopupBtn', function (e) {
    //     openReferralPopup();
    // });

    function selectFloorPlanError() {
        $('.selectFloorPlanError').fadeIn()
            .fadeOut()
            .fadeIn()
            .fadeOut()
            .fadeIn()
            .fadeOut()
            .fadeIn()
            .fadeOut()
            .fadeIn();

        var elmnt = document.getElementById("selectFloorPlanError");
        elmnt.scrollIntoView({behavior: "smooth"});
    }

    $("#apartmentProfilePage").on('click', '.remove-from-client-list', function (e) {
        e.preventDefault();
        var id = $(this).attr('apartment-id');
        var index = $(this).attr('apartment-index');

        manageSelectedApartments(id, index, 'remove');

    });

    $('#searchedApartments').on('mouseover', '.apartment-list-item', function () {
        var index = $(this).attr('apartment-index');
        markers[index].setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(function () {
            markers[index].setAnimation(null);
        }, 2300);
        icon.fillColor = '#007eef';
        markers[index].setIcon(icon);
    });

    $('#searchedApartments').on('mouseleave', '.apartment-list-item', function () {
        var index = $(this).attr('apartment-index');
        var dColor = (APTs[index].no_of_floor_plans <= 0) ? noFPColor : deselectionColor;
        icon.fillColor = ($.inArray(APTs[index].id, selectedAptIds) === -1) ? dColor : selectionColor;
        markers[index].setIcon(icon);
        markers[index].setAnimation(null);
    });


    //$.HSCore.components.HSModalWindow.init('[data-modal-target]');
    $('#map').on('click', '.show-apartment-details-info-window', function (e) {
        e.preventDefault();
        showApartmentDetails(parseInt($(this).attr('apartment-id')), parseInt($(this).attr('apartment-index')));
    });

    $('#searchedApartments').on('click', '.show-apartment-details', function (e) {
        e.preventDefault();
        showApartmentDetails(parseInt($(this).attr('apartment-id')), parseInt($(this).attr('apartment-index')));
    });

    $('#apartmentProfilePage').on('click', '#contactPropertyBtn', function (e) {
        e.preventDefault();
        if (searchSaved) {
            contactPropertyPopup();
        } else {
            alertPopupWithOk('Please Save Search', 'Please select all the search filters and then save the search to continue.', function () {
                Custombox.modal.close();
                Custombox.modal.close();

                $('#saveSearch').blink();

                setTimeout(function () {
                    $('#saveSearch').unblink();
                }, 3000);
            });
        }
    });

    $('#sendApartmentListToClient, #previewApartmentList').click(function (e) {
        e.preventDefault();

        var preview = $(this).attr('data-preview');

        if (selectedAptIds.length > 0) {

            if (searchSaved) {

                var finalFloorPlans = {};
                $.each(selectedAptIds, function (ind, apartmentId) {
                    if (typeof  selectedAptFloorPlans[apartmentId] == "undefined") {
                        finalFloorPlans[apartmentId] = aptFloorPlans[apartmentId];
                    } else {
                        finalFloorPlans[apartmentId] = (selectedAptFloorPlans[apartmentId].length > 0) ? selectedAptFloorPlans[apartmentId] : aptFloorPlans[apartmentId];
                    }
                });


                $.ajax({
                    url: SITE_URL + 'realtors/send-client-list',
                    type: "POST",
                    data: {
                        selected_apartment_ids: selectedAptIds,
                        customer_list_id: $('#clientListId').val(),
                        customer_search_id: $('#customerSearchId').val(),
                        floor_plans: finalFloorPlans,
                        floor_plan_notes: selectedAptFloorPlanNotes,
                        preview: preview,
                    },
                    dataType: "JSON",
                    beforeSend: function () {
                        $('#sendApartmentListToClient, #previewApartmentList').prop('disabled', true);
                        if (preview == "yes") {
                            $('#previewApartmentList').html('<i class="fa fa-spinner fa-spin"></i> Creating preview...');
                        } else {
                            $('#sendApartmentListToClient').html('<i class="fa fa-spinner fa-spin"></i> Sending client list...');
                        }
                    },
                    success: function (resp) {
                        if (resp.code == 200) {
                            $('#clientListId').val(resp.data.clientListId);
                            if (resp.data.preview == "yes") {
                                var win = window.open(resp.data.listUrl, '_blank');
                                win.focus();

                            } else {
                                //listSentModal('Client List Sent', '<h6>The Apartment list has been sent to your client.  Once your clients views the list you will be notified via email.</h6>');
                            }
                        }

                        //Reseting Button HTML
                        if (preview == "yes") {
                            $('#previewApartmentList').html('<i class="fa fa-eye"></i> Preview Apartment List');
                        } else {
                            $('#sendApartmentListToClient').html('<i class="fa fa-send"></i> Send Apartment List to Client');

                            if (isSubscribed) {
                                var newModal = new Custombox.modal({
                                    overlay: {
                                        close: false
                                    },
                                    content: {
                                        target: '#sendListModal',
                                        positionX: 'center',
                                        positionY: 'center',
                                        speedIn: false,
                                        speedOut: false,
                                        fullscreen: false,
                                        onClose: function () {
                                            $('#sendListData').html("");
                                        }
                                    }
                                });

                                newModal.open();

                                $.get(SITE_URL + 'email-templates/choose-list-template', function (resp) {
                                    $('#sendListData').html(resp);
                                });
                            } else {
                                var newModal = new Custombox.modal({
                                    overlay: {
                                        close: true
                                    },
                                    content: {
                                        target: '#subscriptionExpired',
                                        id: 'subscriptionExpired',
                                        positionX: 'center',
                                        positionY: 'center',
                                        speedIn: false,
                                        speedOut: false,
                                        fullscreen: false,
                                        onClose: function () {
                                            //Send Message will be Here
                                        }
                                    }
                                });
                                newModal.open();

                                var url = 'realtors/plans';
                                $.get(SITE_URL + url, function (data) {
                                    $("#subscriptionExpiredPlans").html(data);
                                });
                            }
                        }


                        $('#sendApartmentListToClient, #previewApartmentList').prop('disabled', false);


                        // $('#listSentTitle').html(title);
                        // $('#listSentMessage').html(message);

                    }
                });
            } else {
                alertPopupWithOk('Please Save Search', 'Please select all the search filters and then save the search to continue.', function () {
                    $('#saveSearch').blink();

                    setTimeout(function () {
                        $('#saveSearch').unblink();
                    }, 5000);
                });
            }
        } else {
            alertPopupWithOk('No Apartment Selected', 'Please add apartments to client list.', function () {
                Custombox.modal.close();
                Custombox.modal.close();
            });
        }

    });

    $('#searchForm').validate({
        ignore: ":hidden:not(.not-ignore)",
        rules: {
            market_place_city_id: {
                required: true
            },
            name: {
                required: false
            },
            zip: {
                required: false
            },
            bedrooms: {
                required: true
            },
            bathrooms: {
                required: true
            },
            min_rent: {
                required: true
            },
            max_rent: {
                required: true
            },
            move_date: {
                required: true
            }
        },
        messages: {
            market_place_city_id: {
                required: "City?"
            },
            name: {
                required: "Apartment Name?"
            },
            zip: {
                required: "Zip?"
            },
            bedrooms: {
                required: "Beds?"
            },
            bathrooms: {
                required: "Baths?"
            },
            min_rent: {
                required: "Min Rent?"
            },
            max_rent: {
                required: "Max Rent?"
            },
            move_date: {
                required: "Move Date?"
            }
        },
        invalidHandler: function (event, validator) {
            searchFilterSelected = false;
            searchSaved = false;
            alertPopupWithOk('Please Save Search', 'Please select all the search filters and then save the search to continue.', function () {
                $('#saveSearch').blink();

                setTimeout(function () {
                    $('#saveSearch').unblink();
                }, 5000);
            });
        },
        submitHandler: function (form) {
            searchFilterSelected = true;
            if (searchSaved) {
                $('#saveSearchError').hide();
                var searchedAptIds = [];
                $.each(APTs, function (index, apt) {
                    if ((apt.no_of_floor_plans > 0)) {
                        searchedAptIds.push(apt.id);
                    }
                });
                if (searchedAptIds.length > 0) {
                    $.ajax({
                        url: SITE_URL + 'realtors/save-search',
                        type: "POST",
                        data: {
                            searched_apartment_ids: searchedAptIds,
                            customer_search_id: $('#customerSearchId').val(),
                            move_date: $('#moveDate').val(),
                            search_parameters: $('#searchForm').serialize()
                        },
                        dataType: "JSON",
                        beforeSend: function () {
                            $('#saveSearch').prop('disabled', true);
                            $('#saveSearch').html('<i class="fa fa-spinner fa-spin"></i> Saving Search');
                        },
                        success: function (resp) {
                            if (resp.code == 200) {
                                alertPopupWithOk('Search Saved', 'Now select the apartments and floorplans you wish to send to your client.');
                                $('#customerSearchId').val(resp.data.customerSearchId);
                                $('#sendApartmentListToClient').fadeIn();
                            }
                            $('#saveSearch').html('<i class="fa fa-save"></i> Save Search');
                            $('#saveSearch').prop('disabled', false);
                        }
                    });
                }
            }
            return false;
        }
    });

    $('#saveSearch').click(function (e) {
        e.preventDefault();
        searchSaved = true;
        $('#searchForm').submit();
        return false;
    });


    $('#searchAddress, #searchZip').blur(function () {
        $('#listApartmentIds').val('');
        LOADING_APARTMENTS = false;
        PAGE = 1;
        searchSaved = false;
        searchResults();
    });

    $('#searchCityAustin, #searchCityDFW, #searchCityHouston, #searchCitySanAntonio, #searchCityAll').change(function () {
        $('#cityIdField').val($(this).val());
        if ($(this).val().length > 0) {
            $('#listApartmentIds').val('');
            LOADING_APARTMENTS = false;
            PAGE = 1;
            searchSaved = false;
            searchResults();
        }
    });

    $('#applySearchAmenities').click(function () {
        $('#listApartmentIds').val('');
        Custombox.modal.close();
        setTimeout(function () {
            LOADING_APARTMENTS = false;
            PAGE = 1;
            searchSaved = false;
            searchResults();
        }, 1000);

    });

    $('#searchBedrooms, #searchBathrooms, #searchMinRent, #searchMaxRent').change(function () {
        $('#listApartmentIds').val('');
        if ($('#cityIdField').val().length > 0 || $('#searchAddress').val().length > 0 || $('#searchZip').val().length > 0) {
            LOADING_APARTMENTS = false;
            PAGE = 1;
            searchResults();
        }
    });

    $('#searchedApartments').scroll(function (e) {
        var scrollHeight = document.getElementById("searchedApartments").scrollHeight;
        if (scrollHeight - $(this).scrollTop() < ($(this).height() + 100)) {
            if (PAGE == 1) {
                searchSaved = false;
            }
            searchResults();
        }
    });

    $('#amenitiesBtn').click(function (e) {
        e.preventDefault();
        openPopup('#amenitiesModal');
    });

    $('#viewSelectedItems').click(function (e) {
        e.preventDefault();

        $('#selectedApartmentsInPopup').html("");
        $('#sendApartmentListToClient').hide();

        if (selectedAptIds.length <= 0) {
            $('#selectedAptCount').html("");
            $('#selectedApartmentsInPopup').append("<h3>No Apartment Selected.</h3>");
        } else {
            $('#selectedAptCount').html(" (" + selectedAptIds.length + ")");
            $.template("listWindowSelectedForPopup", $('#listWindowSelectedForPopup').html());
            $('#sendApartmentListToClient, #previewApartmentList').fadeIn();
            $.ajax({
                url: SITE_URL + 'realtors/sort-selected-apartments',
                type: "POST",
                data: {
                    selected_apartment_ids: selectedAptIds,
                    sort_by: "name",
                },
                dataType: "JSON",
                success: function (resp) {
                    if (resp.code == 200) {
                        $('#selectedApartmentsInPopup').html("");
                        $.each(resp.data.apartments, function (index, aptId) {
                            $('#selectedApartmentsInPopup').append($.tmpl("listWindowSelectedForPopup", selectedAPTsByIds[aptId]));
                        });
                    }
                }
            });
        }

        openPopup('#viewSelectedApartmentsModal');
    });


    $('#searchBy').change(function () {
        $('#listApartmentIds').val('');
        $('#searchZip, #searchAddress, #searchCityAustin, #searchCityDFW, #searchCityHouston, #searchCitySanAntonio').val("");
        $('#searchZip, #searchAddress, #searchCityAustin, #searchCityDFW, #searchCityHouston, #searchCitySanAntonio').rules("add", {required: false});


        $('.search-by, .select-marketplace-city-box').hide();
        if ($(this).val() == "city") {
            $('.select-marketplace-city-box').fadeIn();
            $('.select-marketplace:first').click();
        } else {
            $('.' + $(this).val()).fadeIn();
            $('#cityIdField').val("");
        }
        switch ($(this).val()) {
            case"name": {
                $('#searchAddress').rules("add", {required: true});
                break;
            }
            case"zip": {
                $('#searchZip').rules("add", {required: true});
                break;
            }
        }
    });

    $(".select-marketplace").click(function () {

        $(".search-by").hide();
        $('.market-place-city').val("").change();
        $('.' + $(this).val()).fadeIn();

        $.get(SITE_URL + 'realtors/saveLastSelectedMarketplace/' + $(this).val());

        //$('#searchCityAustin, #searchCityDFW, #searchCityHouston, #searchCitySanAntonio').rules("add", {required: false});

        // switch ($(this).val()) {
        //     case"Austin": {
        //         $('#searchCityAustin').rules("add", {required: true});
        //         break;
        //     }
        //     case"DFW": {
        //         $('#searchCityDWF').rules("add", {required: true});
        //         break;
        //     }
        //     case"Houston": {
        //         $('#searchCityHouston').rules("add", {required: true});
        //         break;
        //     }
        //     case"SanAntonio": {
        //         $('#searchCitySanAntonio').rules("add", {required: true});
        //         break;
        //     }
        // }
    });

    if (lastSelectedMarketplace == "NA") {
        $('.select-marketplace:first').click();
    } else {

        $('#mkp_' + lastSelectedMarketplace).click();
    }


    $('#selectAllApartments').click(function () {
        if (searchSaved) {
            var makeSelection = 'add';
            if ($(this).attr('action-type') == "select") {
                $(this).html("<i class='fa fa-check-square'></i> &nbsp;Unselect All");
                $(this).attr('action-type', 'unselect');
            } else {
                $(this).html("<i class='fa fa-square-o'></i> &nbsp;Select All");
                $(this).attr('action-type', 'select');
                makeSelection = 'remove';
            }

            $.each(markers, function (index, marker) {
                manageSelectedApartments(APTs[index].id, index, makeSelection);
            });
        } else {
            alertPopupWithOk('Please Save Search', 'Please select all the search filters and then save the search to continue.', function () {
                $('#saveSearch').blink();

                setTimeout(function () {
                    $('#saveSearch').unblink();
                }, 5000);
            });
        }

    });


    $('.open-popup-calendar').click(function () {
        $('.popup-calendar').focus();
    });

    $('.open-search-calendar').click(function () {
        $('.search-calendar').focus();
    });

    $("#apartmentProfilePage").on('click', '.customer_list_apartment_floor_plan_ids', function (e) {
        $('.selectFloorPlanError').fadeOut();
        selectedAptFloorPlans[currentApartmentId] = [];
        // if (typeof  referraledAPTs[currentApartmentId] == "undefined") {
        //     openReferralPopup();
        //     e.preventDefault();
        //     return false;
        // } else {
        $('.floorplan-notes').attr('readonly', 'readonly').attr('disabled', 'disabled').val("").css("cssText", "background-color: #f1f1f1 !important;");
        if (typeof  selectedAptFloorPlanNotes[currentApartmentId] == "undefined") {
            selectedAptFloorPlanNotes[currentApartmentId] = {}
        }

        $('.customer_list_apartment_floor_plan_ids:checked').each(function () {
            var fpId = $(this).attr('data-id');
            selectedAptFloorPlans[currentApartmentId].push(fpId);
            $('#fpNote_' + fpId)
                .removeAttr('readonly')
                .removeAttr('disabled')
                .css("cssText", "background-color: #ffffff !important;");
            $('#fpNote_' + fpId).val(selectedAptFloorPlanNotes[currentApartmentId][fpId]);

        });
        // }
    });

    $("#apartmentProfilePage").on('keyup', '.floorplan-notes', function () {
        if (typeof  selectedAptFloorPlanNotes[currentApartmentId] == "undefined") {
            selectedAptFloorPlanNotes[currentApartmentId] = {}
        }

        selectedAptFloorPlanNotes[currentApartmentId][$(this).attr('data-fp-id')] = $(this).val();
    }).on('keydown', '.floorplan-notes', function () {
        if (typeof  selectedAptFloorPlanNotes[currentApartmentId] == "undefined") {
            selectedAptFloorPlanNotes[currentApartmentId] = {}
        }

        selectedAptFloorPlanNotes[currentApartmentId][$(this).attr('data-fp-id')] = $(this).val();
    });

    $('#removeFromListBtn').click(function (e) {
        e.preventDefault();
        removeSelectedApartment();
    });
});

var openSendApartmentList = function () {
    Custombox.modal.close();
    $('#viewSelectedItems').click();
};

function initMap() {

    var mapBoxId = document.getElementById('map');


    var address = 'Texas, USA';

    map = new google.maps.Map(mapBoxId, {
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP, // //SATELLITE
        fullscreenControl: true
    });

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
        'address': address
    }, function (results, status) {
        map.setCenter(results[0].geometry.location);
    });


    infoWindow = new google.maps.InfoWindow();

    bounds = new google.maps.LatLngBounds();

    $('#searchBtn').click(function () {
        LOADING_APARTMENTS = false;
        PAGE = 1;
        searchResults();
    });

    /**********************/
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: false,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['rectangle']
        }
    });

    drawingManager.setMap(map);


    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
        switch (event.type) {
            case google.maps.drawing.OverlayType.POLYGON:
            case google.maps.drawing.OverlayType.RECTANGLE:
            case google.maps.drawing.OverlayType.CIRCLE:
                $.each(markers, function (index, marker) {

                    if (shapeContains(event.overlay, marker.getPosition())) {
                        if (makeSelection == 1) {
                            manageSelectedApartments(APTs[index].id, index, 'add');
                        }

                        if (makeSelection == 2) {
                            manageSelectedApartments(APTs[index].id, index, 'remove');
                        }
                    }
                });

                event.overlay.setMap(null);
                break;
        }
    });

    moveBtn = document.createElement('button');
    moveBtn.setAttribute('class', "btn btn-primary g-color-white g-font-size-22");
    moveBtn.id = "moveMap";
    moveBtn.title = "Move Map";
    moveBtn.style.marginTop = "20px";
    moveBtn.innerHTML = '<i class="fa fa-hand-paper-o"></i>';
    moveBtn.onclick = function () {
        moveBtn.removeAttribute('class');
        moveBtn.setAttribute('class', "btn btn-primary g-color-white g-font-size-22");
        drawingManager.setMap(null);
        makeSelection = 0;
    }

    selectBtn = document.createElement('button');
    selectBtn.setAttribute('class', "btn btn-default g-color-white g-font-size-22");
    selectBtn.id = "selectFromMap";
    selectBtn.title = "Select Apartments";
    selectBtn.style.backgroundColor = "#faad10";
    selectBtn.style.marginTop = "20px";
    selectBtn.innerHTML = '<i class="fa fa-check-square"></i>';
    selectBtn.onclick = function () {
        moveBtn.removeAttribute('class');
        moveBtn.setAttribute('class', "btn btn-danger g-color-white g-font-size-22");
        drawingManager.setMap(map);
        drawingManager.setOptions({
            drawingControl: false,
            drawingMode: "rectangle"
        });
        makeSelection = 1;
    };

    deselectBtn = document.createElement('button');
    deselectBtn.setAttribute('class', "btn  btn-primary g-color-white selection-btn  g-font-size-22");
    deselectBtn.id = "deleclectFromMap";
    deselectBtn.title = "Unselect Apartments";
    deselectBtn.style.backgroundColor = "#222e44";
    deselectBtn.style.marginTop = "20px";
    deselectBtn.style.marginBottom = "10px";
    deselectBtn.innerHTML = '<i class="fa fa-square-o"></i>';
    deselectBtn.onclick = function () {
        if ($('#searchedApartments .' + selectionIcon).length > 0) {
            moveBtn.removeAttribute('class');
            moveBtn.setAttribute('class', "btn btn-danger g-color-white g-font-size-22");
            drawingManager.setMap(map);
            drawingManager.setOptions({
                drawingControl: false,
                drawingMode: "rectangle"
            });
            makeSelection = 2;
        }
    };


    var controlTrashUI = document.createElement('DIV');
    controlTrashUI.style.cursor = 'pointer';
    controlTrashUI.style.position = 'fixed';
    controlTrashUI.style.height = 'auto';
    controlTrashUI.style.width = '50px';
    controlTrashUI.style.top = '210px';
    controlTrashUI.style.right = '45px';
    controlTrashUI.style.zIndex = '9999999';
    //controlTrashUI.appendChild(moveBtn);
    //controlTrashUI.appendChild(selectBtn);
    //controlTrashUI.appendChild(deselectBtn);
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlTrashUI);

}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function searchResults() {
    if (!LOADING_APARTMENTS) {
        if (currentCall != null) {
            currentCall.abort();
        }
        currentCall = $.ajax({
            url: SITE_URL + "realtors/search/" + PAGE,
            type: "post",
            data: $('#searchForm').serialize(),
            dataType: "JSON",
            beforeSend: function () {
                if (PAGE == 1) {
                    drawingManager.setMap(null);
                    makeSelection = 0;
                    $('#searchedApartments, #noOfRecordsFound').html("");
                    $('#sendApartmentListToClient, #saveSearch, #previewApartmentList').hide();
                    setMapOnAll(null);
                    formattedAPTs = [];
                    APTs = [];
                    searchedAptIds = [];
                    selectedAPTs = {};
                    makeSelection = 0;
                    markers = [];
                    APARTMENTS_FOUND = 0;
                    searchItemIndex = 0;
                    bounds = new google.maps.LatLngBounds();
                }

                $("#searchBtn").html("<i class='fa fa-spin fa-spinner'></i> Searching..");
                $('#searchedApartments').append("<h5 id='searchLoader'><i class='fa fa-spin fa-spinner'></i> Loading ...</h5>");
                $('#searchBtn').prop('disabled', true);
                LOADING_APARTMENTS = true;
            },
            success: function (resp) {

                $('#searchBtn').prop('disabled', false);
                $("#searchBtn").html("<i class=\"fa fa-search\"></i> Search");
                if (resp.code == "200") {
                    currentCall = null;
                    $('#selectAllApartments, #saveSearch, #viewSelectedItems').fadeIn();
                    $('#searchLoader').remove();
                    if (resp.data.apartments.length > 0) {

                        var addPlus = "+";

                        if (resp.data.apartments.length < 100) {
                            addPlus = "";
                        }

                        APARTMENTS_FOUND = APARTMENTS_FOUND + resp.data.apartments.length;
                        $('#noOfRecordsFound').html(APARTMENTS_FOUND + addPlus + " apartments found.");

                        $.template("infoWindow", $('#infoWindow').html());
                        $.template("listWindow", $('#listWindow').html());
                        $.template("listWindowSelected", $('#listWindowSelected').html());
                        $.each(resp.data.apartments, function (index, apt) {
                            searchedAptIds.push(apt.id);
                            APTs.push(apt);
                            var address = [];
                            var address1 = apt.address;
                            var address2 = [];
                            address.push(apt.address);
                            if (apt.city != null) {
                                address.push(apt.city.name);
                                address2.push(apt.city.name);
                            }
                            if (apt.state != null) {
                                address.push(apt.state.name);
                                address2.push(apt.state.name);
                            }
                            address.push(apt.zip);
                            address2.push(apt.zip);

                            var image = (apt.image == null) ? "files/images/default.png" : apt.image.small_thumb;

                            var floorPlans = [];

                            $.each(apt.floor_plans, function (ind, fp) {
                                floorPlans.push(fp.id);
                            });

                            aptFloorPlans[apt.id] = floorPlans;

                            var adrs = address.join(", ");

                            adrs = (adrs.length > 35) ? adrs.substring(0, 35) + "..." : adrs;

                            var apartment = {
                                index: searchItemIndex,
                                id: apt.id,
                                name: (apt.name.length > 25) ? apt.name.substring(0, 25) + ".." : apt.name,
                                address: adrs,
                                address1: address1,
                                address2: address2.join(", "),
                                image: image,
                                user: apt.user.name,
                                phone: apt.user.phone,
                                lat: apt.lat,
                                lng: apt.lng,
                                commission: (apt.commission == null) ? "NA" : apt.commission,
                                last_updated: moment(apt.modified).fromNow(),
                            };

                            var infoWindowHtml = $.tmpl("infoWindow", [apartment]);

                            //console.log($.tmpl("infoWindow", [apartment]).html());

                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(apt.lat, apt.lng),
                                map: map,
                                icon: {
                                    path: MAP_PIN_O,
                                    fillColor: '#222e44',
                                    fillOpacity: 1,
                                    strokeColor: '#fff',
                                    strokeWeight: 0.5,
                                    scale: 0.1,
                                },
                                map_icon_label: '<i class="fa fa-circle"></i>'
                            });

                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {
                                    infoWindow.setContent(infoWindowHtml.html());
                                    infoWindow.open(map, marker);
                                }
                            })(marker, i));

                            markers.push(marker);
                            bounds.extend(marker.position);


                            if ($.inArray(apartment.id, selectedAptIds) === -1) {
                                $('#searchedApartments').append($.tmpl("listWindow", [apartment]));
                                icon.fillColor = (apt.no_of_floor_plans <= 0) ? noFPColor : deselectionColor;
                            } else {
                                $('#searchedApartments').append($.tmpl("listWindowSelected", [apartment]));
                                icon.fillColor = selectionColor;
                            }

                            if (apt.no_of_floor_plans <= 0) {
                                $('#apartment_' + apt.id).removeClass('u-header__section--admin-dark');
                                $('#apartment_' + apt.id).addClass('g-bg-gray-dark-v5');
                            }


                            markers[searchItemIndex].setIcon(icon);
                            $('#apartment_' + apt.id).fadeIn();
                            formattedAPTs.push(apartment);
                            searchItemIndex = searchItemIndex + 1;

                            if (listApartmentIds.indexOf(apt.id) !== -1) {
                                manageSelectedApartments(apt.id, index, "add")
                            }
                        });

                        map.fitBounds(bounds);

                        if(markers.length <= 2) {
                            map.setZoom(map.getZoom() - 6);
                        }

                        PAGE = PAGE + 1;
                        LOADING_APARTMENTS = false;
                    } else {
                        if (PAGE === 1) {
                            $('#searchedApartments').html("<h5>No record found</h5>");
                        } else {
                            $('#searchedApartments').append("<h5>No more record found</h5>");
                            LOADING_APARTMENTS = true;
                        }
                    }
                }

            }
        });
    }
}

// /*wrapper for contains function */
function shapeContains(shape, latLng) {
    if (shape instanceof google.maps.Circle)
        return shape.getBounds().contains(latLng) && google.maps.geometry.spherical.computeDistanceBetween(shape.getCenter(), latLng) <= shape.getRadius();
    else if (shape instanceof google.maps.Rectangle)
        return shape.getBounds().contains(latLng);
    else if (shape instanceof google.maps.Polygon)
        return google.maps.geometry.poly.containsLocation(latLng, shape);
    else
        throw new Error("contains is not supported for this type of shape");
}

function manageSelectedApartments(id, index, type) {

    if (type == "add") {

        selectedAPTs[index] = APTs[index];
        selectedAPTsByIds[id] = formattedAPTs[index];
        if (selectedAptIds.indexOf() === -1) {
            selectedAptIds.push(parseInt(id));

            $('#apt_' + id + ' .mark-favorite i')
                .removeClass(deselectionIcon)
                .addClass(selectionIcon).css({color: selectionColor});
        }
        icon.fillColor = selectionColor;
        $('#addToClientListBtn_' + id + ', #addToClientListBottomBtn_' + id).hide();
        $('#removeFromClientListBtn_' + id + ', #removeFromClientListBottomBtn_' + id).fadeIn();
    } else {
        removeAptId = id;
        removeAptIndex = index;
        var newModal = new Custombox.modal({
            overlay: {
                close: false
            },
            content: {
                target: '#removeFromListAlertModal',
                positionX: 'center',
                positionY: 'center',
                speedIn: false,
                speedOut: false,
                fullscreen: false,
            }
        });

        newModal.open();
        return false;
    }

    $.ajax({
        url: SITE_URL + "customer-searches/save-selected",
        type: "POST",
        data: {customer_search_id: $('#customerSearchId').val(), apartment_id: id, selected: type},
        dataType: "JSON",
        success: function (resp) {
            //Do Nothing;
        }
    });


    markers[index].setIcon(icon);
    markers[index].setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(function () {
        markers[index].setAnimation(null);
    }, 2300);


    if (selectedAptIds.length > 0) {
        $('#selectedApartmentCount, #selectedAptCount').html(" (" + selectedAptIds.length + ") ");
        $('#sendApasendApartmentListToClient, #previewApartmentList').fadeIn();
        saveClientList();
    } else {
        $('#selectedApartmentsInPopup').html('<h4>No Apartment Selected.</h4>');
        $('#selectedApartmentCount, #selectedAptCount').html("");
        $('#sendApartmentListToClient, #previewApartmentList').fadeOut()
    }

}

function removeSelectedApartment() {
    var id = parseInt(removeAptId);
    var index = parseInt(removeAptIndex);

    var searchedAptIndex = searchedAptIds.indexOf(id);

    var i = selectedAptIds.indexOf(id);

    if (i > -1) {
        selectedAptIds.splice(i, 1);
    }
    delete selectedAPTsByIds[id];
    delete selectedAPTs[index];
    delete selectedAptFloorPlans[id];
    if (searchedAptIndex > -1) {
        $('#apt_' + id + ' .mark-favorite i')
            .removeClass(selectionIcon)
            .addClass(deselectionIcon)
            .css({color: '#ffffff'});

        icon.fillColor = deselectionColor;
        $('#removeFromClientListBtn_' + id + ', #removeFromClientListBottomBtn_' + id).hide();
        $('#addToClientListBtn_' + id + ', #addToClientListBottomBtn_' + id).fadeIn();
    }


    $('#selectedApt_' + id).remove();

    if (searchedAptIndex > -1) {
        markers[index].setIcon(icon);
        markers[index].setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(function () {
            markers[index].setAnimation(null);
        }, 2300);
    }

    $.ajax({
        url: SITE_URL + "customer-searches/save-selected",
        type: "POST",
        data: {customer_search_id: $('#customerSearchId').val(), apartment_id: id, selected: "remove"},
        dataType: "JSON",
        success: function (resp) {
            //Do Nothing;
        }
    });

    if (selectedAptIds.length > 0) {
        $('#selectedApartmentCount, #selectedAptCount').html(" (" + selectedAptIds.length + ") ");
        $('#sendApartmentListToClient, #previewApartmentList').fadeIn();
        saveClientList();
    } else {
        $('#selectedApartmentsInPopup').html('<h4>All Apartments Removed.</h4>');
        $('#selectedApartmentCount, #selectedAptCount').html("");
        $('#sendApartmentListToClient, #previewApartmentList').fadeOut()
        $('#sendApartmentListToClient, #previewApartmentList').fadeOut()
    }

    Custombox.modal.close();

}


function showApartmentDetails(id, index) {
    currentApartmentId = id;
    if (searchSaved) {

        $("#apartmentProfilePage").html("<h3 class='text-center'>Loading ... <i class='fa fa-spinner fa-spin'></i></h3>");

        openPopup('#apartmentDetailModal');

        $("#apartmentProfilePage").html('<h3 style="text-align: center;"><i class="fa fa-spin fa-spinner"></i> Loading... </h3>');
        var markedFavorite = ($.inArray(parseInt(id), selectedAptIds) === -1) ? 0 : 1;


        $.ajax({
            url: SITE_URL + 'realtors/apartment-profile',
            type: "post",
            data: {
                apartmentId: currentApartmentId,
                index: index,
                markedFavorite: markedFavorite,
                bedrooms: $('#searchBedrooms').val(),
                bathrooms: $('#searchBathrooms').val(),
                minRent: $('#searchMinRent').val(),
                maxRent: $('#searchMaxRent').val(),
                clientListId: $('#clientListId').val(),
                clientId: clientId,
                customerSearchId: $('#customerSearchId').val(),

            },
            success: function (resp) {

                var finalFloorPlans = {};
                if (typeof  selectedAptFloorPlans[currentApartmentId] == "undefined") {
                    // finalFloorPlans = aptFloorPlans[currentApartmentId];
                } else {
                    finalFloorPlans = (selectedAptFloorPlans[currentApartmentId].length > 0) ? selectedAptFloorPlans[currentApartmentId] : {};
                }

                console.log(finalFloorPlans);

                $("#apartmentProfilePage").html(resp);

                setTimeout(function () {

                    $('.floorplan-notes')
                        .attr('readonly', 'readonly')
                        .attr('disabled', 'disabled')
                        .css("cssText", "background-color: #f1f1f1 !important;")
                        .val("");

                    $.each(finalFloorPlans, function (ind, fpId) {
                        $('#selectedFP_' + fpId + ', #selectedFP_' + fpId + '_all').prop('checked', true);
                        $('#selectedFP_' + fpId + ', #selectedFP_' + fpId + '_all').attr('checked', true);
                        $('#fpNote_' + fpId).val(selectedAptFloorPlanNotes[currentApartmentId][fpId]);
                        $('#fpNote_' + fpId)
                            .removeAttr('readonly')
                            .removeAttr('disabled')
                            .css("cssText", "background-color: #ffffff !important;");
                    });

                }, 1000);
            }
        });

    } else {
        alertPopupWithOk('Please Save Search', 'Please select all the search filters and then save the search to continue.', function () {
            $('#saveSearch').blink();

            setTimeout(function () {
                $('#saveSearch').unblink();
            }, 5000);
        });
    }
}


function contactPropertyPopup() {
    //Custombox.modal.close();
    // if ($('#moveDate').val().length > 0 && $('#moveDate').val() != "Select Move Date") {
    //     contactMoveDate.setDate($('#moveDate').val(), true);
    // }
    setTimeout(function () {
        openPopup('#contactApartmentModal');
    }, 200);

}

function openPopup(modelId, callback) {
    var newModal = new Custombox.modal({
        overlay: {
            close: true
        },
        content: {
            target: modelId, //'#apartmentDetailModal',
            id: modelId.replace("#", ""), //'#apartmentDetailModal',
            positionX: 'center',
            positionY: 'center',
            speedIn: false,
            speedOut: false,
            fullscreen: false,
            onClose: callback
        }
    });

    newModal.open();
}

function alertPopup(title, message, callback) {
    $('#alertTitle').html(title);
    $('#alertMessage').html(message);
    var newModal = new Custombox.modal({
        overlay: {
            close: false
        },
        content: {
            target: '#alertMessageModal',
            positionX: 'center',
            positionY: 'center',
            speedIn: false,
            speedOut: false,
            fullscreen: false,
            onClose: callback
        }
    });

    newModal.open();
}

function alertPopupWithOk(title, message, callback) {
    $('#alertTitleWithOk').html(title);
    $('#alertMessageWithOk').html(message);
    var newModal = new Custombox.modal({
        overlay: {
            close: false
        },
        content: {
            target: '#alertMessageWithOkModal',
            id: 'alertMessageWithOkModal',
            positionX: 'center',
            positionY: 'center',
            speedIn: false,
            speedOut: false,
            fullscreen: false,
            onClose: callback
        }
    });

    newModal.open();
}

function listSentModal(title, message, callback) {
    $('#listSentTitle').html(title);
    $('#listSentMessage').html(message);
    var newModal = new Custombox.modal({
        overlay: {
            close: false
        },
        content: {
            target: '#listSentModal',
            positionX: 'center',
            positionY: 'center',
            speedIn: false,
            speedOut: false,
            fullscreen: false,
        }
    });

    newModal.open();
}

function resetPage() {
    //$('#resetBtn').click();
    window.location.reload();
}

function openReferralPopup() {
    var newModal = new Custombox.modal({
        overlay: {
            close: false
        },
        content: {
            target: "#registerReferralModal",
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

function saveClientList() {
    if (selectedAptIds.length > 0) {

        if (searchSaved) {

            var finalFloorPlans = {};
            $.each(selectedAptIds, function (ind, apartmentId) {
                if (typeof  selectedAptFloorPlans[apartmentId] == "undefined") {
                    finalFloorPlans[apartmentId] = aptFloorPlans[apartmentId];
                } else {
                    finalFloorPlans[apartmentId] = (selectedAptFloorPlans[apartmentId].length > 0) ? selectedAptFloorPlans[apartmentId] : aptFloorPlans[apartmentId];
                }
            });


            $.ajax({
                url: SITE_URL + 'realtors/send-client-list',
                type: "POST",
                data: {
                    selected_apartment_ids: selectedAptIds,
                    customer_list_id: $('#clientListId').val(),
                    customer_search_id: $('#customerSearchId').val(),
                    floor_plans: finalFloorPlans,
                    floor_plan_notes: selectedAptFloorPlanNotes,
                    preview: "yes",
                },
                dataType: "JSON",
                success: function (resp) {
                    if (resp.code == 200) {
                        $('#clientListId').val(resp.data.clientListId);
                    }
                }
            });
        }
    }
}