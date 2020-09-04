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
    setTimeout(function () {
        // $('#searchAddress').focus();
    }, 500);


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
        icon.fillColor = ($.inArray(APTs[index].id, selectedAptIds) === -1) ? deselectionColor : selectionColor;
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


    $('#saveSearch').click(function (e) {
        e.preventDefault();

        return false;
    });


    $('#saveSearch').click(function (e) {
        e.preventDefault();
        searchSaved = true;
        $('#searchForm').submit();
        return false;
    });


    $('#searchAddress, #searchZip').keyup(function () {
        if ($(this).val().length > 1) {
            $('#listApartmentIds').val('');
            LOADING_APARTMENTS = false;
            PAGE = 1;
            searchSaved = false;
            searchResults();
        }
    });

    $('#searchAddress, #searchZip').keydown(function () {
        if ($(this).val().length > 1) {
            $('#listApartmentIds').val('');
            LOADING_APARTMENTS = false;
            PAGE = 1;
            searchSaved = false;
            searchResults();
        }
    });

    $('#searchCity, #searchCompany').change(function () {
        $('#listApartmentIds').val('');
        LOADING_APARTMENTS = false;
        PAGE = 1;
        searchSaved = false;
        searchResults();
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

    $('#apartmentProfilePage').on('click', '#contactPropertyBtn', function (e) {
        e.preventDefault();

        contactPropertyPopup();

    });


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

});

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
            url: SITE_URL + "realtors/getLookUpProperties/" + PAGE,
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

                            adrs = (adrs.length > 35) ? adrs.substring(0, 35)+"..." : adrs;

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
                                icon.fillColor = deselectionColor;
                            } else {
                                $('#searchedApartments').append($.tmpl("listWindowSelected", [apartment]));
                                icon.fillColor = selectionColor;
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


    markers[index].setIcon(icon);
    markers[index].setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(function () {
        markers[index].setAnimation(null);
    }, 2300);


    if (selectedAptIds.length > 0) {
        $('#selectedApartmentCount, #selectedAptCount').html(" (" + selectedAptIds.length + ") ");
        $('#sendApasendApartmentListToClient, #previewApartmentList').fadeIn()
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

    if (selectedAptIds.length > 0) {
        $('#selectedApartmentCount, #selectedAptCount').html(" (" + selectedAptIds.length + ") ");
        $('#sendApartmentListToClient, #previewApartmentList').fadeIn()
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

    $("#apartmentProfilePage").html("<h3 class='text-center'>Loading ... <i class='fa fa-spinner fa-spin'></i></h3>");

    openPopup('#apartmentDetailModal');

    $("#apartmentProfilePage").html('<h3 style="text-align: center;"><i class="fa fa-spin fa-spinner"></i> Loading... </h3>');
    var markedFavorite = ($.inArray(parseInt(id), selectedAptIds) === -1) ? 0 : 1;


    $.ajax({
        url: SITE_URL + 'realtors/apartment-profile-look-up',
        type: "post",
        data: {
            apartmentId: currentApartmentId,
        },
        success: function (resp) {

            $("#apartmentProfilePage").html(resp);
        }
    });

}


function contactPropertyPopup() {
    //Custombox.modal.close();
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

