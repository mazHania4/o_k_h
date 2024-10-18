
<!-- LogIn modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginLabel">Iniciar sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/o_k_h/ctrl/login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Iniciar sesión</button>
                </form>
            </div>
            <div class="modal-footer">
                <div class="mb-3">
                    <p>
                        ¿Aun no tienes una cuenta? 
                        <button class="btn btn-link" id="openSignIn" data-bs-toggle="modal" data-bs-target="#singinModal">Registrarse</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
