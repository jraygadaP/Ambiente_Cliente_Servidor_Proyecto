document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir el envío real del formulario

    // Mostrar el mensaje de confirmación
    document.getElementById("confirmation-message").style.display = "block";

    // Limpiar los campos del formulario
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("message").value = "";
});