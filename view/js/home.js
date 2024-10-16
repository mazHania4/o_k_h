

document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los botones de registrar asistencia
    var buttons = document.querySelectorAll('.register-attendance');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = this.getAttribute('data-post-id');
            var buttonElement = this;
            
            // Crear la solicitud POST usando Fetch API
            fetch('ctrl/user/attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + encodeURIComponent(postId)
            })
            .then(function(response) {
                console.log("respuesta");
                console.log(response.json)
                return response.json();
            })
            .then(function(data) {
                console.log(data)
                if (data.success) {
                    // Actualizar el contador de asistencias
                    var countElement = document.getElementById('attendance-count-' + postId);
                    countElement.textContent = data.new_count.attendances;
                    
                    // Cambiar el texto del botón
                    buttonElement.textContent = 'Asistencia Registrada';
                    buttonElement.disabled = true;
                } else {
                    alert('Hubo un error al registrar la asistencia.');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Error de conexión.');
            });
        });
    });
});
