/*
███████╗██╗░░░██╗███╗░░██╗██╗░█████╗░███╗░░██╗░█████╗░██╗░░░░░██╗██████╗░░█████╗░██████╗░
██╔════╝██║░░░██║████╗░██║██║██╔══██╗████╗░██║██╔══██╗██║░░░░░██║██╔══██╗██╔══██╗██╔══██╗
█████╗░░██║░░░██║██╔██╗██║██║██║░░██║██╔██╗██║███████║██║░░░░░██║██║░░██║███████║██║░░██║
██╔══╝░░██║░░░██║██║╚████║██║██║░░██║██║╚████║██╔══██║██║░░░░░██║██║░░██║██╔══██║██║░░██║
██║░░░░░╚██████╔╝██║░╚███║██║╚█████╔╝██║░╚███║██║░░██║███████╗██║██████╔╝██║░░██║██████╔╝
╚═╝░░░░░░╚═════╝░╚═╝░░╚══╝╚═╝░╚════╝░╚═╝░░╚══╝╚═╝░░╚═╝╚══════╝╚═╝╚═════╝░╚═╝░░╚═╝╚═════╝░

███╗░░██╗░█████╗░██╗░░░██╗██████╗░░█████╗░██████╗░
████╗░██║██╔══██╗██║░░░██║██╔══██╗██╔══██╗██╔══██╗
██╔██╗██║███████║╚██╗░██╔╝██████╦╝███████║██████╔╝
██║╚████║██╔══██║░╚████╔╝░██╔══██╗██╔══██║██╔══██╗
██║░╚███║██║░░██║░░╚██╔╝░░██████╦╝██║░░██║██║░░██║
╚═╝░░╚══╝╚═╝░░╚═╝░░░╚═╝░░░╚═════╝░╚═╝░░╚═╝╚═╝░░╚═╝__navbarfuncion
*/

let toggle = document.querySelector('.toggle');
let left = document.querySelector('.left');
let right = document.querySelector('.right');
let close = document.querySelector('.close');
let body = document.querySelector('body');
let searchBx = document.querySelector('.searchBx');
let searchOpen = document.querySelector('.searchOpen');
let searchClose = document.querySelector('.searchClose');
toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    left.classList.toggle('active');
    right.classList.toggle('overlay');
    body.style.overflow = 'hidden';
});
close.onclick = () => {
    toggle.classList.remove('active');
    left.classList.remove('active');
    right.classList.remove('overlay');
    body.style.overflow = '';
};
searchOpen.onclick = () => {
    searchBx.classList.add('active');
};
searchClose.onclick = () => {
    searchBx.classList.remove('active');
};
window.onclick = (e) => {
    if (e.target == right) {
        toggle.classList.remove('active');
        left.classList.remove('active');
        right.classList.remove('overlay');
        body.style.overflow = '';
    }
};


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

/*
░█████╗░░█████╗░██╗░░░░░███████╗███╗░░██╗██████╗░░█████╗░██████╗░██╗░█████╗░
██╔══██╗██╔══██╗██║░░░░░██╔════╝████╗░██║██╔══██╗██╔══██╗██╔══██╗██║██╔══██╗
██║░░╚═╝███████║██║░░░░░█████╗░░██╔██╗██║██║░░██║███████║██████╔╝██║██║░░██║
██║░░██╗██╔══██║██║░░░░░██╔══╝░░██║╚████║██║░░██║██╔══██║██╔══██╗██║██║░░██║
╚█████╔╝██║░░██║███████╗███████╗██║░╚███║██████╔╝██║░░██║██║░░██║██║╚█████╔╝
░╚════╝░╚═╝░░╚═╝╚══════╝╚══════╝╚═╝░░╚══╝╚═════╝░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░╚════╝░__calendariofuncionalidad
*/

const monthYearElement = document.getElementById('monthYear');
const calendarDaysElement = document.getElementById('calendarDays');
const prevMonthElement = document.getElementById('prevMonth');
const nextMonthElement = document.getElementById('nextMonth');

prevMonthElement.addEventListener('click', () => updateCalendar(-1));
nextMonthElement.addEventListener('click', () => updateCalendar(1));

function generateCalendar(year, month) {
    calendarDaysElement.innerHTML = '';

    const firstDay = new Date(year, month, 1).getDay();
    const lastDay = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        const listItem = document.createElement('li');
        listItem.textContent = '';
        listItem.classList.add('inactive');
        calendarDaysElement.appendChild(listItem);
    }

    for (let i = 1; i <= lastDay; i++) {
        const listItem = document.createElement('li');
        listItem.textContent = i;
        listItem.classList.add('active');
        if (year === currentDate.getFullYear() && month === currentDate.getMonth() && i === currentDate.getDate()) {
            listItem.classList.add('today');
        }
        calendarDaysElement.appendChild(listItem);
    }

    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    monthYearElement.textContent = `${monthNames[month]} ${year}`;
}

function updateCalendar(change) {
    currentDate.setMonth(currentDate.getMonth() + change);
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    generateCalendar(year, month);
}

const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = currentDate.getMonth();
generateCalendar(currentYear, currentMonth);