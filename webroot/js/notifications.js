var loadingNtf = '<li class="media u-header-dropdown-item-v1 g-parent g-px-20"><div class="d-flex align-self-center u-header-dropdown-icon-v1 g-pos-rel g-width-50 g-height-50 g-font-size-22 rounded-circle g-mx-15 g-my-10"><i class="fa fa-spinner fa-spin g-absolute-centered" style="top: 12px !important; left: 12px !important;"></i></div><div class="media-body align-self-center"><p class="mb-0">Loading...</p></div></li>';

var noNtfFound = '<li class="media u-header-dropdown-item-v1 g-parent g-p-20"><div class="d-flex align-self-center u-header-dropdown-icon-v1 g-pos-rel g-width-50 g-height-50 g-font-size-22 rounded-circle g-mx-15 g-my-10"><i class="fa fa-circle-o g-absolute-centered"></i></div><div class="media-body align-self-center"><p class="mb-0">No Notification Found</p></div></li>';

var ntfLi = '<li id="ntf_{ID}" class="media u-header-dropdown-item-v1 g-parent g-p-20 {BY} "><div class="d-flex align-self-center u-header-dropdown-icon-v1 g-pos-rel g-width-50 g-height-50 g-font-size-22 rounded-circle g-mx-15 g-my-10"><i class="fa fa-{ICON} g-absolute-centered"></i></div><div class="media-body align-self-center"><p class="mb-0 {IS_SEEN}">{NTF}</p></div>{TRASH}</li>';

/*
         * Notification By Admin
         * E-Blast By Apartment
         * Message By Apartment
         * Message By Realtor
         *
         */

$(function () {
    function getNtfCount() {
        $.ajax({
            url: SITE_URL + 'users/getNtfCount',
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $('#ntfCount').hide();
            },
            success: function (response) {
                if (response.data.newNtfCount > 0) {
                    var ntfCount = (response.data.newNtfCount > 99) ? "99+" : response.data.newNtfCount;
                    $('#ntfCount').html(ntfCount);
                    $('#ntfCount').fadeIn();
                    var newModal = new Custombox.modal({
                        content: {
                            target: '#checkNtfModal',
                            effect: 'slide',
                            animateFrom: 'top',
                            animateTo: 'bottom',
                            positionX: 'center',
                            positionY: 'center',
                            speedIn: 300,
                            speedOut: 300,
                            fullscreen: false,
                            onClose: function () {
                                $('#ntfCount').fadeOut();
                                $('#ntfCount').fadeIn();
                                $('#ntfCount').fadeOut();
                                $('#ntfCount').fadeIn();
                                $('#ntfCount').fadeOut();
                                $('#ntfCount').fadeIn();
                                $('#ntfCount').fadeOut();
                                $('#ntfCount').fadeIn();
                            }
                        }
                    });
                    newModal.open();
                } else {
                    $('#ntfCount').html("").hide();
                }

            }
        });
    };

    function reGetNtfCount() {
        $.ajax({
            url: SITE_URL + 'users/getNtfCount',
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $('#ntfCount').hide();
            },
            success: function (response) {
                if (response.data.newNtfCount > 0) {
                    var ntfCount = (response.data.newNtfCount > 99) ? "99+" : response.data.newNtfCount;
                    $('#ntfCount').html(ntfCount);
                    $('#ntfCount').fadeIn();
                } else {
                    $('#ntfCount').html("").hide();
                }

            }
        });
    };

    setTimeout(function () {
        if (PAGE_NAME == "Realtorsdashboard" || PAGE_NAME == "Apartmentsdashboard") {
            getNtfCount();
        }
    }, 1500);


    function getNtfs() {
        $.ajax({
            url: SITE_URL + 'users/getNtfs',
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $('#newNtfs').html(loadingNtf);
                $('#seeAllNtfs').hide();
            },
            success: function (response) {
                $('#newNtfs').html("");
                $('#ntfCount').hide();
                if (response.data.ntfs.length > 0) {
                    $.each(response.data.ntfs, function (ind, ntf) {

                        var li = "NA";
                        switch (ntf.activity.activity_type) {
                            case "Notification By Admin" : {
                                var a = ntf.activity.activity;
                                var n = 21;

                                a = (a.length > n) ? (a.substr(0, n - 1) + '&hellip; Read More') : a;
                                a = '<a href="javascript:void(0);" class="read-more" id="readMoreNtf_' + ntf.activity.id + '">' + a + '</a>';
                                li = ntfLi.replace(/\{(NTF)\}/g, a);
                                li = li.replace(/\{(ICON)\}/g, 'user');
                                li = li.replace(/\{(BY)\}/g, 'admin-ntf');
                                break;
                            }
                            case "E-Blast By Apartment" : {
                                var NTF = '<a href="' + SITE_URL + 'apartment-special/' + ntf.activity.e_blast_id + '">An <b>E-Blast</b> from apartment <b>' + ntf.activity.apartment.name + '</b> for you.</a>';
                                li = ntfLi.replace(/\{(NTF)\}/g, NTF);
                                li = li.replace(/\{(ICON)\}/g, 'building-o');
                                li = li.replace(/\{(BY)\}/g, 'apartment-e-blast-ntf');
                                break;
                            }
                            case "Message By Apartment" : {
                                var NTF = 'This is for future use.';
                                li = ntfLi.replace(/\{(NTF)\}/g, NTF);
                                li = li.replace(/\{(BY)\}/g, 'apartment-msg-ntf');
                                break;
                            }
                            case "Message By Realtor" : {
                                var NTF = 'This is for future use.';
                                li = ntfLi.replace(/\{(NTF)\}/g, NTF);
                                li = li.replace(/\{(BY)\}/g, 'realtor-msg-ntf');
                                break;
                            }

                            default : {
                                break;
                            }
                        }
                        {
                        }
                        li = li.replace(/\{(IS_SEEN)\}/g, ntf.is_seen ? '' : 'bold-me g-font-weight-700');
                        li = li.replace(/\{(ID)\}/g, ntf.activity.id);
                        $('#newNtfs').append(li.replace(/\{(TRASH)\}/g, ""));
                    });

                    $('#seeAllNtfs').fadeIn();

                } else {
                    $('#newNtfs').html(noNtfFound);
                    $('#seeAllNtfs').fadeOut();
                }

            }
        });
    };


    $('#notificationsInvoker').click(function () {
        if (PAGE_NAME == "Realtorsdashboard" || PAGE_NAME == "Apartmentsdashboard") {
            getNtfs();
        }
    });

    $('#newNtfs').on('click', '.read-more', function () {
        $('#ntfDetail').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');
        var ntfId = $(this).attr('id').split('_')[1];
        //$('#DeleteNtf').attr('data-id', ntfId);
        // var newModal = new Custombox.modal({
        //     content: {
        //         target: '#ntfDetailModal',
        //         effect: 'slide',
        //         animateFrom: 'right',
        //         animateTo: 'right',
        //         positionX: 'center',
        //         positionY: 'center',
        //         speedIn: 300,
        //         speedOut: 300,
        //         fullscreen: false,
        //         onClose: function () {
        //
        //         }
        //     }
        // });
        // newModal.open();

        window.location.href = SITE_URL + 'users/notifications/' + ntfId

        // $.ajax({
        //     url: SITE_URL + 'users/getNtf/' + ntfId,
        //     type: "POST",
        //     dataType: "json",
        //     beforeSend: function () {
        //         $('#ntfDetail').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');
        //     },
        //     success: function (resp) {
        //         $('#ntfDetail').html(resp.activity);
        //         reGetNtfCount();
        //     }
        // });
    });

    $('#DeleteNtf').click(function () {
        var ntfId = $(this).attr('data-id');
        $.ajax({
            url: SITE_URL + 'users/deleteNtf/' + ntfId,
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $('#activity_' + ntfId).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {
                $('#ntf_' + ntfId).remove();
                Custombox.modal.close();
                getNtfs();
            }
        });
    });

});

