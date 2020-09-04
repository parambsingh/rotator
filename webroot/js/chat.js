var SSE = {}, SOURCE = null;
var CHATS = {};
var msgPage = 1;
var chatPage = 1;
var loadMessages = true;
var loadingChats = false;


$(function () {

    //$.HSCore.components.HSModalWindow.init("[data-modal-target]");

    $.template("chatTmpl", $("#chatTmpl").html());
    $.template("msgByOtherTmpl", $("#msgByOtherTmpl").html());
    $.template("msgByMeTmpl", $("#msgByMeTmpl").html());
    $.template("msgTmpl", $("#msgTmpl").html());
    $.template("flyerTmpl", $("#flyerTmpl").html());
    $.template("chatDetailTmp", $("#chatDetailTmp").html());

    $("#chats").on("click", ".chat-detail", function () {

        $(".chat-detail").removeClass("active-chat");
        $(this).addClass("active-chat");
        CurrentChatId = $(this).attr("id").split("_")[1];

        var apartment = {};
        var address = [];
        address.push(CHATS[CurrentChatId].apartment.name);
        if (typeof CHATS[CurrentChatId].apartment.city != "undefined") {
            address.push(CHATS[CurrentChatId].apartment.city.name);
        }
        if (typeof CHATS[CurrentChatId].apartment.state != "undefined") {
            address.push(CHATS[CurrentChatId].apartment.state.name);
        }
        address.push(CHATS[CurrentChatId].apartment.zip);

        apartment.name = CHATS[CurrentChatId].apartment.name;
        apartment.address = address.join(", ");
        $("#aptName").val(apartment.name);
        $("#chatMessages").html("");
        msgPage = 1;
        $("#chatDetail").html("Loading...");
        getChatDetail();
        getMessages();

    });


    $("#sendMsg").click(function (e) {
        e.preventDefault();
        if ($.trim($("#chatMessage").text()).length > 0 && $.trim($("#chatMessage").text()) !== "Say Something" ) {
            if (SenderName) {
                sendMsg();
            } else {
                var newModal = new Custombox.modal({
                    overlay: {
                        close: false
                    },
                    content: {
                        target: "#senderNameModal",
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
        }
    });


    $("#chatMessage").keypress(function (e) {
        e.stopPropagation();
        if ((e.keyCode == 13 || e.keyCode == 10) && e.ctrlKey) {
            var content = $(this).val();
            var caret = getCaret(this);
            $(this).val(content.substring(0, caret) +
                "\n" + content.substring(caret, content.length));
        } else if (e.keyCode == 13 || e.keyCode == 10) {
            if ($.trim($("#chatMessage").text()).length > 0 && $.trim($("#chatMessage").text()) !== "Say Something" ) {
                if (SenderName) {
                    sendMsg();
                } else {
                    var newModal = new Custombox.modal({
                        overlay: {
                            close: false
                        },
                        content: {
                            target: "#senderNameModal",
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
            }
            return true;
        }

    });

    $('#chatMessage').focus(function () {
        if($.trim($('#chatMessage').text()) == "Say Something"){
            $('#chatMessage').text("");
        }
    }).blur(function () {
        if($.trim($('#chatMessage').text()) == ""){
            $('#chatMessage').text("Say Something");
        }
    });

    function getCaret(el) {
        if (el.selectionStart) {
            return el.selectionStart;
        } else if (document.selection) {
            el.focus();

            var r = document.selection.createRange();
            if (r == null) {
                return 0;
            }

            var re = el.createTextRange(),
                rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint("EndToStart", re);

            return rc.text.length;
        }
        return 0;
    }

    setTimeout(function () {
        getNewMsgCnt();
    }, 3000);

    function getNewMsgCnt() {
        if (typeof(EventSource) !== "undefined") {
            if (SOURCE !== null) {
                // SOURCE.close();
            }
            SOURCE = new EventSource(SITE_URL + "messages/hasNewMessage");
            SOURCE.addEventListener("message", function (event) {
                var r = JSON.parse(event.data);

                $.each(r.newMessageCount, function (index, chat) {
                    if (chat.count > 0) {
                        $("#chat_" + chat.id + " .new-message-count").html(chat.count).fadeIn();
                        if (chat.id == CurrentChatId) {
                            getMessages();
                        }
                    }
                });

            });
        } else {
            console.log("Whoops! Your browser doesn't receive server-sent events.");
        }
    }

    function sendMsg() {
        if ($.trim($("#chatMessage").text()).length > 0 && $.trim($("#chatMessage").text()) !== "Say Something" ) {

            $.ajax({
                url: SITE_URL + "messages/save-message",
                type: "POST",
                data: {message: $.trim($('#chatMessage').text())},
                dataType: "JSON",
                beforeSend: function () {
                    $("#chatMessage").html("");
                    if (Role == "Apartment") {
                        SenderName = false;
                    }
                },
                success: function (resp) {
                    if (resp.code == 200) {
                        var msg = resp.data.message;
                        msg.chat = CHATS[msg.chat.id];
                        MSG = $.tmpl("msgTmpl", [msg]).html();
                        $.tmpl("msgBy" + msg.by + "Tmpl", [msg]).appendTo("#chatMessages");
                        $("#msg_" + msg.id + " .message-here").html(MSG);
                    } else {
                        console.load("Something went wrong");
                    }

                    $("#scrollBox").mCustomScrollbar({}).mCustomScrollbar("scrollTo", "bottom", {scrollInertia: 0});
                }
            });
        }
    }

    function sendFlyer() {
        var includeFloorPlans = $("#includeFloorPlans").prop("checked");
        $.ajax({
            url: SITE_URL + "messages/save-flyer",
            type: "POST",
            data: {
                message: $.trim($("#loadTemplate").html()),
                flyer_template_id: currentTemplateId,
                include_floor_plans: includeFloorPlans
            },
            dataType: "JSON",
            success: function (resp) {
                Custombox.modal.close();
                if (resp.code == 200) {
                    var msg = resp.data.message;
                    msg.chat = CHATS[msg.chat.id];
                    msg.image = SITE_URL + "img/templates/template" + ("0" + msg.flyer_template_id) + ".png";
                    MSG = $.tmpl("flyerTmpl", [msg]).html();
                    $.tmpl("msgBy" + msg.by + "Tmpl", [msg]).appendTo("#chatMessages");
                    $("#msg_" + msg.id + " .message-here").html(MSG);
                } else {
                    console.load("Something went wrong");
                }

                $("#scrollBox").mCustomScrollbar({}).mCustomScrollbar("scrollTo", "bottom", {scrollInertia: 0});
            }
        });
    }


    $("#sendFlyer").click(function (e) {
        e.preventDefault();
        sendFlyer();
    });


    setTimeout(function () {
        getChats();
    }, 1000);

    $('#chats').on('scroll', function () {
        let div = $(this).get(0);
        if (div.scrollTop + div.clientHeight >= div.scrollHeight) {
            if (!loadingChats) {
                chatPage += 1;
                getChats();
            }
        }
    });


    function getChats() {
        $.ajax({
            url: SITE_URL + "messages/getChats/" + chatPage,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                $("#chats").append("<div id='chatLoader'>" + LOADING + "</div>");
                loadingChats = true;
            },
            success: function (resp) {
                if (chatPage == 1) {
                    $("#chats").html("");
                }
                if (resp.code == 200) {
                    $('#chatLoader').remove();
                    if (resp.data.chats.length > 0) {

                        $("#chats").append($.tmpl("chatTmpl", resp.data.chats));
                        $.each(resp.data.chats, function (index, chat) {
                            CHATS[chat.id] = chat;
                        });

                        if (chatPage == 1) {
                            (CurrentChatId == 0) ? $(".chat-detail:first").click() : $("#chat_" + CurrentChatId).click();
                        }

                    } else {
                        if (chatPage == 1) {
                            $("#chats").html("<h4>No Record Found</h4>");
                        } else {
                            $("#chats").append("<h4>No More Record Found</h4>");
                        }
                    }
                    loadingChats = false;
                } else {
                    $("#chats").html("<h4>No Conversation Found</h4>");
                }


            }
        });
    }

    function getMessages() {
        $.ajax({
            url: SITE_URL + "messages/getMessages/" + CurrentChatId + "/" + msgPage,
            type: "POST",
            dataType: "JSON",
            beforeSend: function () {
                if (msgPage == 1) {
                    $("#chatMessages").html(LOADING);
                } else {
                    $("#chatMessages").prepend(LOADING);
                }
            },
            success: function (resp) {
                if (resp.code == 200) {
                    var MSG = "";
                    var removeCount = true;
                    if (resp.data.messages.length > 0) {
                        $.each(resp.data.messages, function (index, msg) {
                            if (msg.seen == "unseen") {
                                removeCount = false;
                            }
                            switch (msg.message_type) {
                                case "image": {
                                    break;
                                }
                                case "apartment-special-flyer":
                                case "flyer": {
                                    msg.image = SITE_URL + "img/templates/template" + ("0" + msg.flyer_template_id) + ".png";
                                    MSG = $.tmpl("flyerTmpl", [msg]).html();
                                    break;
                                }
                                case "floor plans": {
                                    $.template("floorPlansMsgTmpl", $("#floorPlansMsgTmpl").html());
                                    var MSG = $.tmpl("floorPlansMsgTmpl", [msg]).html();
                                    break;
                                }
                                default:
                                    MSG = $.tmpl("msgTmpl", [msg]).html();
                            }

                            $.tmpl("msgBy" + msg.by + "Tmpl", [msg]).prependTo("#chatMessages");
                            $("#msg_" + msg.id + " .message-here").html(MSG);
                        });
                        if (msgPage == 1) {
                            setTimeout(function () {
                                $("#scrollBox").mCustomScrollbar({
                                    theme: "minimal-dark",
                                    callbacks: {
                                        onTotalScrollBack: function (x, y) {
                                            if (loadMessages) {
                                                msgPage += 1;
                                                getMessages();
                                            }
                                        }
                                    }
                                }).mCustomScrollbar("scrollTo", "bottom");
                            }, 500);

                        }
                        $.getJSON(SITE_URL + "messages/update-seen", function (r) {
                            //r.data.chat_id;
                        });
                        if (removeCount) {
                            $("#chat_" + CurrentChatId + " .new-message-count").fadeOut();
                        }

                    } else {
                        loadMessages = false;
                        //$("#chats").html("<h4>No Record Found</h4>");
                    }
                    $("#chatMessages .loader").remove();
                } else {
                    ///$("#chats").html("<h4>Something went wrong, please try again</h4>");
                }
            }
        });
    }

    function getChatDetail() {
        $.getJSON(SITE_URL + "messages/get-chat-detail", function (resp) {
            $("#chatDetail").html("");
            $('#chatApartmentName').html(resp.data.chat.apartment_name);
            $('#chatRealtorName').html(resp.data.chat.realtor_name);
            $('#chatRealtorCompanyName').html(resp.data.chat.realtor_company);
            $("#chatDetail").append($.tmpl("chatDetailTmp", [resp.data.chat]));
        });
    }

    $("#chatMessages").on("click", ".show-details", function () {
        var newModal = new Custombox.modal({
            overlay: {
                close: true
            },
            content: {
                target: "#showDetailPopupModal",
                effect: "slide",
                animateFrom: "right",
                animateTo: "right",
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

        var url = SITE_URL + "messages/flyer/" + $(this).attr("id").split("_")[1];
        $.get(url, function (data) {
            $("#flyerHtml").html(data);
        });
    });

    $("#flyerHtml").on("click", ".view-floor-plans-btn", function () {
        var newModal = new Custombox.modal({
            overlay: {
                close: true
            },
            content: {
                target: "#viewFloorPlansPopupModal",
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

        $.get(SITE_URL + "messages/view-floor-plans/" + $(this).attr("data-id"), function (data) {
            $("#viewApartmentFloorPlansHtml").html(data);
        });
    });
});

