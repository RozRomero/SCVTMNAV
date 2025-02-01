
/* Hora de cada pais */
function updateClock() {
    const shanghaiTime = document.getElementById('shanghai-time');
    const santiagoTime = document.getElementById('santiago-time');
    const greenwichTime = document.getElementById('greenwich-time');

    const now = new Date();

    // Obtener la hora de Shanghái
    const shanghaiDate = new Date(now.toLocaleString('en-US', {timeZone: 'Asia/Shanghai'}));
    shanghaiTime.textContent = `${shanghaiDate.toLocaleTimeString()}`;

    // Obtener la hora de Santiago
    const santiagoDate = new Date(now.toLocaleString('en-US', {timeZone: 'America/Santiago'}));
    santiagoTime.textContent = `${santiagoDate.toLocaleTimeString()}`;

    // Obtener la hora de Greenwich
    const greenwichDate = new Date(now.toLocaleString('en-US', {timeZone: 'GMT'}));
    greenwichTime.textContent = `${greenwichDate.toLocaleTimeString()}`;
}

setInterval(updateClock, 1000);