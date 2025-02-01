function modalValidateSend (message) {
    return new Promise((resolve) => { // Usamos una Promesa para manejar el resultado de forma asincrónica
        if (!document.getElementById("modal_validate_send")) {
            let modalValidateSend = document.createElement("div");
            modalValidateSend.id = "modal_validate_send";
            modalValidateSend.className = "rounded";

            let formInsideModalValidateSend = document.createElement("form");
            formInsideModalValidateSend.id = 'form_modal_validate';

            let message_span = document.createElement("span");
            message_span.id = "message_span";
            message_span.textContent = message;

            let divButtons = document.createElement("div");
            divButtons.id = "div_buttons_modal"

            let acceptButton = document.createElement("button");
            acceptButton.textContent = "Accept";
            acceptButton.className = "accept";
            acceptButton.type = "button"; // Evita que el botón envíe el formulario

            let closeButton = document.createElement("button");
            closeButton.textContent = "Close";
            closeButton.className = "close";
            closeButton.type = "button"; // Evita que el botón envíe el formulario

            // Agrega un manejador de evento al botón "Aceptar"
            acceptButton.addEventListener("click", function () {
                resolve(true); // Resuelve la promesa con true cuando se hace clic en "Aceptar"
                hiddenModalValidateSend();
            });

            // Agrega un manejador de evento al botón "Cerrar"
            closeButton.addEventListener("click", function () {
                resolve(false); // Resuelve la promesa con false cuando se hace clic en "Cerrar"
                hiddenModalValidateSend();
            });

            divButtons.appendChild(acceptButton);
            divButtons.appendChild(closeButton);

            formInsideModalValidateSend.appendChild(message_span);
            formInsideModalValidateSend.appendChild(divButtons);
            
            modalValidateSend.appendChild(formInsideModalValidateSend);
            document.body.insertBefore(modalValidateSend, document.body.firstChild);
        }
    });
}

function hiddenModalValidateSend() {
    let modalValidateSend = document.getElementById("modal_validate_send");
    document.body.removeChild(modalValidateSend);
}
