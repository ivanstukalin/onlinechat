function loadMessagesByChat(id) {
    $.get("/chat/messages?id=" + id, function(data) {
        let response = JSON.parse(data);
        if (response.status !== 200) {
            console.log(response.message)
            return;
        }
        messages = JSON.parse(response.body);
        if (messages.length > 0) {
            setMessagesList(messages)
        }
    });
}

function loadChat(id) {
    return $.get("chat?id=" + id, function(data){
        let response = JSON.parse(data)
        if (response.status !== 200) {
            console.log(response.message)
            createChat()
            return;
        }
        chat = JSON.parse(response.body)
        return chat;
    });
}

function createChat() {
    $.post(
        "chat/create",
        {},
        function(data) {
            let response = JSON.parse(data)
            if (response.status === 200) {
                chat = JSON.parse(response.body)
                document.cookie = "chat_id="+ chat.id;
            } else {
                console.log(response.message)
            }
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