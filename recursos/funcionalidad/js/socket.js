/*
░█████╗░░█████╗░███╗░░██╗███████╗██╗░░██╗██╗░█████╗░███╗░░██╗  ░██╗░░░░░░░██╗███████╗██████╗░
██╔══██╗██╔══██╗████╗░██║██╔════╝╚██╗██╔╝██║██╔══██╗████╗░██║  ░██║░░██╗░░██║██╔════╝██╔══██╗
██║░░╚═╝██║░░██║██╔██╗██║█████╗░░░╚███╔╝░██║██║░░██║██╔██╗██║  ░╚██╗████╗██╔╝█████╗░░██████╦╝
██║░░██╗██║░░██║██║╚████║██╔══╝░░░██╔██╗░██║██║░░██║██║╚████║  ░░████╔═████║░██╔══╝░░██╔══██╗
╚█████╔╝╚█████╔╝██║░╚███║███████╗██╔╝╚██╗██║╚█████╔╝██║░╚███║  ░░╚██╔╝░╚██╔╝░███████╗██████╦╝
░╚════╝░░╚════╝░╚═╝░░╚══╝╚══════╝╚═╝░░╚═╝╚═╝░╚════╝░╚═╝░░╚══╝  ░░░╚═╝░░░╚═╝░░╚══════╝╚═════╝░

░██████╗░█████╗░░█████╗░██╗░░██╗███████╗████████╗
██╔════╝██╔══██╗██╔══██╗██║░██╔╝██╔════╝╚══██╔══╝
╚█████╗░██║░░██║██║░░╚═╝█████═╝░█████╗░░░░░██║░░░
░╚═══██╗██║░░██║██║░░██╗██╔═██╗░██╔══╝░░░░░██║░░░
██████╔╝╚█████╔╝╚█████╔╝██║░╚██╗███████╗░░░██║░░░
╚═════╝░░╚════╝░░╚════╝░╚═╝░░╚═╝╚══════╝░░░╚═╝░░░__conexionfrontwebsocket
*/

var conn = new WebSocket('ws://localhost:8080');

conn.onopen = function(e) {
    console.log("Conectado al servidor WebSocket");
};

conn.onmessage = function(e) {
    var chatMessages = document.getElementById('chat-messages');
    var message = document.createElement('div');
    message.className = 'message bot';
    message.textContent = e.data;
    chatMessages.appendChild(message);
    chatMessages.scrollTop = chatMessages.scrollHeight;
};

function sendMessage() {
    var input = document.getElementById('message-input');
    var message = input.value;
    if (message) {
        conn.send(message);

        var chatMessages = document.getElementById('chat-messages');
        var messageDiv = document.createElement('div');
        messageDiv.className = 'message user';
        messageDiv.textContent = message;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        input.value = '';
    }
}