

document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.register-attendance');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = this.getAttribute('data-post-id');
            var buttonElement = this;
            
            fetch('ctrl/user/attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + encodeURIComponent(postId)
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Actualizar el contador de asistencias
                    var countElement = document.getElementById('attendance-count-' + postId);
                    countElement.textContent = data.new_count;
                    
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


    var submitButtons = document.querySelectorAll('.submit-report');
    submitButtons.forEach(function(submitButton) {
        submitButton.addEventListener('click', function() {

            var postId = this.getAttribute('data-post-id');
            var motive = document.querySelector('input[name="motive"]:checked').value;
            var comment = document.getElementById('comment_' + postId).value;
            
            var formData = new URLSearchParams();
            formData.append('post_id', postId);
            formData.append('motive', motive);
            formData.append('comment', comment);
            
            fetch('ctrl/user/report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString()
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    alert('El reporte ha sido enviado exitosamente.');
                } else {
                    alert('Hubo un error al enviar el reporte.');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Error en la solicitud.');
            });
        });
    });
    
});
