var marker, i, drawingManager, map, infowindow, bounds;
var markers = [];
var APTs = [];
var selectedAPTs = {};
var selectedAPTsByIds = {};
var selectedAPTsIds = [];
var formatedAPTs = [];
var selectionColor = "#faad10";
var deselectionColor = "#222e44";
var selectionIcon = "fa-check-square";
var deselectionIcon = "fa-square-o";
var searchItemIndex = 0;
var MAP_PIN_O = 'M125 410 c-56 -72 -111 -176 -120 -224 -7 -36 11 -83 49 -124 76 -85 223 -67 270 31 28 60 29 88 6 150 -19 51 -122 205 -148 221 -6 3 -32 -21 -57 -54z m110 -175 c35 -34 33 -78 -4 -116 -35 -35 -71 -37 -105 -7 -40 35 -43 78 -11 116 34 41 84 44 120 7z';

var APARTMENTS_FOUND = 0;

var icon = {
    path: MAP_PIN_O,
    fillColor: deselectionColor,
    fillOpacity: 1,
    strokeColor: '#fff',
    strokeWeight: 0.5,
    scale: 0.1,
};

$(function () {
    //$.HSCore.components.HSModalWindow.init('[data-modal-target]');
    $('#map').on('click', '.show-apartment-details-info-window', function (e) {
        e.preventDefault();
        showApartmentDetails($(this).attr('data-apartment-id'));
    });
    $('#searchedApartments').on('click', '.show-apartment-details', function (e) {
        e.preventDefault();
        showApartmentDetails($(this).attr('data-apartment-id'))
    });

    $('#searchedApartments').on('mouseover', '.apartment-list-item', function () {
        var index = $(this).attr('id').split('_')[1];
        markers[index].setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(function () {
            markers[index].setAnimation(null);
        }, 2300);
        icon.fillColor = '#007eef';
        markers[index].setIcon(icon);
    });

    $('#searchedApartments').on('mouseleave', '.apartment-list-item', function () {
        var index = $(this).attr('id').split('_')[1];
        icon.fillColor = ($.inArray(APTs[index].id, selectedAPTsIds) === -1) ? deselectionColor : selectionColor;
        markers[index].setIcon(icon);
        markers[index].setAnimation(null);
    });

});

function initMap() {

    var mapBoxId = document.getElementById('map');
    var address = 'Texas, USA';


    map = new google.maps.Map(mapBoxId, {
        zoom: 6,
        maxZoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        fullscreenControl: true
    });

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
        'address': address
    }, function (results, status) {
        map.setCenter(results[0].geometry.location);
    });


    infowindow = new google.maps.InfoWindow();
    bounds = new google.maps.LatLngBounds();

    setTimeout(function () {
        searchResults();
    }, 1000);


    /**********************/
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: false,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['rectangle']
        }
    });

    drawingManager.setMap(map);


}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function searchResults() {
    $.ajax({
        url: SITE_URL + "clients/get-apartment-list/",
        type: "post",
        data: {apartment_ids: apartmentIds},
        dataType: "JSON",
        beforeSend: function () {
            drawingManager.setMap(null);
            $('#searchedApartments, #noOfRecordsFound').html("");
            $('#viewSelectedItems, #sendApartmentListToClient').hide();
            setMapOnAll(null);
            formatedAPTs = [];
            APTs = [];
            selectedAPTs = {};
            markers = [];
            APARTMENTS_FOUND = 0;
            searchItemIndex = 0;
            bounds = new google.maps.LatLngBounds();

            $('#searchedApartments').append("<h5 id='searchLoader'><i class='fa fa-spin fa-spinner'></i> Loading ...</h5>");
        },
        success: function (resp) {

            $('#searchBtn').prop('disabled', false);
            $("#searchBtn").html("<i class=\"fa fa-search\"></i> Search");
            if (resp.code == "200") {
                $('#viewSelectedItems, #selectAllApartments, #sendApartmentListToClient').fadeIn();
                $('#searchLoader').remove();
                if (resp.data.apartments.length > 0) {

                    APARTMENTS_FOUND = APARTMENTS_FOUND + resp.data.apartments.length;
                    $('#noOfRecordsFound').html(APARTMENTS_FOUND + " apartments for you.");
                    $.template("infoWindow", $('#infoWindow').html());
                    $.template("listWindow", $('#listWindow').html());
                    $.template("listWindowSelected", $('#listWindowSelected').html());
                    $.each(resp.data.apartments, function (index, apt) {
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

                        var apartment = {
                            index: searchItemIndex,
                            id: apt.id,
                            name: apt.name,
                            address: address.join(", "),
                            address1: address1,
                            address2: address2.join(", "),
                            image: image,
                            user: apt.user.name,
                            phone: apt.user.phone,
                            lat: apt.lat,
                            lng: apt.lng,
                            commission: (apt.commission == null) ? "NA" : apt.commission,
                            last_updated: moment(apt.modified).fromNow(),
                        }

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
                                infowindow.setContent(infoWindowHtml.html());
                                infowindow.open(map, marker);
                            }
                        })(marker, i));

                        markers.push(marker);
                        bounds.extend(marker.position);

                        if ($.inArray(apartment.id, selectedAPTsIds) === -1) {
                            $('#searchedApartments').append($.tmpl("listWindow", [apartment]));
                            icon.fillColor = deselectionColor;
                        } else {
                            $('#searchedApartments').append($.tmpl("listWindowSelected", [apartment]));
                            icon.fillColor = selectionColor;
                        }
                        markers[searchItemIndex].setIcon(icon);
                        $('#apartment_' + searchItemIndex).fadeIn();
                        formatedAPTs.push(apartment);
                        searchItemIndex = searchItemIndex + 1;
                    });

                    map.fitBounds(bounds);
                    //map.setZoom((map.getZoom() + 1));

                } else {
                    $('#searchedApartments').html("<h5>No record found</h5>");
                }
            }

        }
    });
}

function showApartmentDetails(id) {

    var newModal = new Custombox.modal({
        overlay: {
            close: true
        },
        content: {
            target: '#apartmentDetailModal',
            effect: 'blur',
            animateFrom: 'left',
            animateTo: 'left',
            positionX: 'center',
            positionY: 'center',
            speedIn: 300,
            speedOut: 300,
            fullscreen: false,
            onClose: function () {
            }
        }
    });

    newModal.open();

    $("#apartmentProfilePage").html('<h3 style="text-align: center;"><i class="fa fa-spin fa-spinner"></i> Loading... </h3>');


    $.ajax({
        url: SITE_URL + 'clients/apartment-profile',
        type: "post",
        data: {
            apartmentId: id,
            clientListId: $('#clientListId').val(),
        },
        success: function (resp) {
            $("#apartmentProfilePage").html(resp);
        }
    });

}
