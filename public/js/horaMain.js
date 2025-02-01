function updateClockLocal () {
    // Hora Local
    const now = new Date();
    // if (document.getElementById('local-time')) {
        const localTime = document.getElementById('local-time');
        const localDate = new Date(now.toISOString());
        // if (localDate.toLocaleTimeString()) {
            localTime.textContent = `${localDate.toLocaleTimeString()}`;
        // }
    // }
}

setInterval(updateClockLocal, 1000);