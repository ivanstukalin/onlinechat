function loadMessagesByChat(id) {
    $.ajax({
        type: 'GET',
        url: "/chat/messages?id=" + id,
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                setMessagesList(data)
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        },
    });
}

function loadChat(id) {
    $.ajax({
        type: 'GET',
        url: "chat?id=" + id,
        dataType: "json",
        success: function(data) {
            chat = data
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        },
    });
}

function createChat() {
    return $.ajax({
        type: 'POST',
        url: "chat/create",
        data: {},
        dataType: "json",
        success: function(data) {
            chat = data
            document.cookie = "chat_id="+ chat.id;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        },
    }).done(function (data) {
        return data
    });
}

function setMessagesList(messages) {
    if (messages.length > 0) {
        for (let i = 0; i < messages.length; i++) {
            addMessageToChatBox(messages[i])
        }
    }
}
function getCookie(name) {
    let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function loadOperator(id) {
    $.ajax({
        type: 'GET',
        url: "operator?id=" + id,
        dataType: "json",
        success: function(data) {
            operator = data;
            },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            document.getElementById('message-input').hidden = true;
        },
    });
}