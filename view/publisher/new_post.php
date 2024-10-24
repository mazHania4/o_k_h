

<!-- New Post Modal -->
<div class="modal fade" id="newPostModal" tabindex="-1" aria-labelledby="newPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPostModalLabel">Nueva Publicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPostForm" action="/o_k_h/ctrl/publisher/new_post.php" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" maxlength="255" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacidad</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="location" name="location" maxlength="350" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3" maxlength="750" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL del Evento</label>
                        <input type="url" class="form-control" id="url" name="url" maxlength="255" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Publicación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Become Publisher modals -->
<div class="modal fade" id="becomePublisherModal" tabindex="-1" aria-labelledby="becomePublisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Convertirse en publicador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="mb-3">
                    <p>Actualmente tu cuenta no tiene permitido hacer publicaciones, puedes aceptar los acuerdos a continuación descritos para ascender a categoría 'publicador'</p>
                </div>
                <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                    <h3>Términos y Condiciones de Uso de [Ola Ke Hace]</h3>
                    <ol>
                        <li>
                            <h5>Aceptación de los Términos</h5>
                            <p>Al acceder o utilizar [Ola Ke Hace] (en adelante, la "Plataforma"), usted acepta estar sujeto a estos Términos y Condiciones de Uso (en adelante, los "Términos").
                                Estos Términos constituyen un acuerdo vinculante entre usted y la Compañía Ola Ke Hace. Si no acepta estos Términos, no utilice la Plataforma.</p>
                        </li> 
                        <li>        
                            <h5>Registro y Categorías de Usuario</h5>
                            <ol>
                                <li>Registro: Para utilizar la Plataforma, debe registrarse y crear una cuenta.</li>
                                <li>Categorías de Usuario:
                                    <ul>
                                        <li>Usuario: Cualquier persona que se registre en la Plataforma.</li>
                                        <li>Usuario-Publicador: Un Usuario que ha leído y aceptado estos Términos y que ha obtenido autorización para publicar eventos en la Plataforma.</li>
                                    </ul>
                                </li>
                            </ol>
                        </li>
                        <li>
                            <h5>Publicaciones y Contenido</h5>
                            <ol>
                                <li>
                                    Requisitos para Publicaciones: Para publicar eventos en la Plataforma, el Usuario debe convertirse en Usuario-Publicador.
                                </li>
                                <li>
                                    Revisión de Publicaciones:
                                    <ul>
                                        <li>Primeras Publicaciones: Las primeras publicaciones de un nuevo Usuario-Publicador serán revisadas por un Administrador para su aprobación.</li>
                                        <li>Publicaciones Posteriores: Una vez aprobadas dos publicaciones iniciales, las publicaciones subsiguientes se cargarán automáticamente, a menos que se infrinjan estos Términos.</li>
                                    </ul>
                                </li>
                                <li>
                                    Contenido Prohibido: El Usuario-Publicador se compromete a no publicar contenido que sea:
                                    <ul>
                                        <li>Ilegal, dañino, amenazante, abusivo, acosador, difamatorio, obsceno, vulgar, odioso, discriminatorio o de otra manera objetable.</li>
                                        <li>Falso, engañoso o inexacto.</li>
                                        <li>Spam, correo no deseado o cualquier otra forma de solicitud no solicitada.</li>
                                        <li>Invasivo de la privacidad de otra persona.</li>
                                        <li>Protegido por derechos de autor, marca registrada u otros derechos de propiedad sin la autorización expresa del propietario.</li>
                                        <li>Que promueva actividades ilegales o dañinas.</li>
                                    </ul>
                                </li>
                            </ol>
                        </li>
                        <li>
                            <h5>Consecuencias de las Infracciones</h5>
                            <ol>
                                <li>Suspensión de Publicaciones Automáticas: Si un Usuario-Publicador infringe estos Términos, se le puede suspender la publicación automática de eventos y sus publicaciones serán nuevamente revisadas por un Administrador.</li>
                                <li>Suspensión de la Cuenta: Si un Usuario-Publicador, que no tiene permiso de publicación automática, infringe estos Términos, se le puede prohibir publicar eventos en la Plataforma.</li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="modal-footer">
                <div class="mb-3">
                    <form action="/o_k_h/ctrl/user/become_publisher.php" method="POST">
                        <button type="submit" class="btn btn-info" >Aceptar y Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



