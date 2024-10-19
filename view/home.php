<?php
    include_once "model/post.php";
    include "ctrl/home.php";
    $home_ctrl = new Home_ctrl();
    $posts = $home_ctrl->getPosts();    
    $reportTypes = $home_ctrl->getReportTypes();    

?>

<div class="container">

    <div class="m-4">
        <?php if (isset($_SESSION['username'])): ?>
            <?php if ( $_SESSION['usertype'] == 'user'): ?>
                <button class="btn btn-info btn-lg btn-icon-split" data-bs-toggle="modal" data-bs-target="#becomePublisherModal">
                    <span class="icon text my-3 ms-3 display-6">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="text mt-4 mx-3 align-middle">Publicar un evento</span>
                </button>
            <?php else: ?>
                <button class="btn btn-info btn-lg btn-icon-split" data-bs-toggle="modal" data-bs-target="#newPostModal">
                    <span class="icon text my-3 ms-3 display-6">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="text mt-4 mx-3 align-middle">Publicar un evento</span>
                </button>
            <?php endif; ?>
        <?php else: ?>
            <button class="btn btn-info btn-lg btn-icon-split" data-bs-toggle="modal" data-bs-target="#loginModal">
            <span class="icon text my-3 ms-3 display-6">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span class="text mt-4 mx-3 align-middle">Publicar un evento</span>
        </button>
        <?php endif; ?>
    </div>

    <?php foreach ($posts as $post): ?>
        <div class="card text-bg-dark border-light">
            <div class="card-header text-bg-dark border-light">
                <div class="row container py-2">
                    <div class="col-11 align-self-start">
                        <h4 class="mb-0"><?php echo htmlspecialchars($post->getTitle()); ?></h4>
                    </div>
                    <div class="col-1 align-self-end text-end">
                        <?php if (isset($_SESSION['username'])): ?>
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#reportModal_<?php echo htmlspecialchars($post->getPostId());?>">
                                <i class="fa-regular fa-font-awesome"></i>
                            </button>
                        <?php else: ?>
                                <button id="openLogin" type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fa-regular fa-font-awesome"></i>
                                </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Cuerpo de la tarjeta: contenido del evento -->
            <div class="card-body">
                <p class="event-meta">
                    <h5 class="card-title">
                        <i class="fa-regular fa-circle-user user-icon"></i>
                        <?php echo htmlspecialchars($post->getPublisherName()); ?>
                    </h5>
                </p>
                <!-- Descripción del evento -->
                <p class="card-text">
                    <?php echo htmlspecialchars($post->getDescription()); ?>
                </p>

                <!-- Meta información: Fechas, horas, y ubicación -->
                <p class="event-meta text-bg-dark">
                    <i class="fa-regular fa-calendar-days user-icon"></i>Inicio: <?php echo htmlspecialchars($post->getStart_date());?> <?php echo htmlspecialchars($post->getStart_time());?><br>
                    <i class="fa-regular fa-calendar-days user-icon"></i>Fin: <?php echo htmlspecialchars($post->getEnd_date());?> <?php echo htmlspecialchars($post->getEnd_time());?><br>
                    <i class="fa-solid fa-location-dot user-icon"></i></i>Ubicación: <?php echo htmlspecialchars($post->getLocation());?>
                </p>


                <!-- Capacidad y Asistencias -->
                <p class="event-meta text-bg-dark">
                    <i class="fa-solid fa-users-between-lines user-icon"></i> Capacidad: <?php echo htmlspecialchars($post->getCapacity()); ?> <br>
                    <i class="fa-regular fa-circle-check user-icon"></i> 
                    Asistencias confirmadas:  <span id="attendance-count-<?php echo htmlspecialchars($post->getPostId()); ?>"><?php echo htmlspecialchars($post->getAttendances()); ?> </span>
                </p>

                <!-- URL -->
                <a href="<?php echo htmlspecialchars($post->getUrl());?>" class="card-link">Más información</a>

                <!-- Categorias -->
                <?php $categories = $home_ctrl->getCategories($post->getPostId());?>
                <div class="badges-container mt-3">
                    <?php foreach ($categories as $cat): ?>
                        <span class="badge bg-warning"><?php echo htmlspecialchars($cat['name']);?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Público -->
                <?php $audiences = $home_ctrl->getAudiences($post->getPostId());?>
                <div class="badges-container mt-3">
                    <?php foreach ($audiences as $aud): ?>
                        <span class="badge bg-info"><?php echo htmlspecialchars($aud['name']);?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer text-body-secondary border-light">
                <div class="d-grid">
                    <?php if (isset($_SESSION['username'])): ?>
                        <button class="register-attendance btn btn-success" data-post-id="<?php echo htmlspecialchars($post->getPostId()); ?>">Registrar Asistencia</button>
                    <?php else: ?>
                        <button class="btn btn-success" id="openLogin" data-bs-toggle="modal" data-bs-target="#loginModal">Registrar Asistencia</button>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        
    
    <?php endforeach; ?>
</div>


<!-- Report modals -->
<?php foreach ($posts as $post): ?>
    <div class="modal fade" id="reportModal_<?php echo htmlspecialchars($post->getPostId()); ?>" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginLabel">Reportar publicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="m-2">    
                        <label for="title">Titulo:</label>
                        <p class="border border-secondary p-1" id="title"> <?php echo htmlspecialchars($post->getTitle());?> </p>
                    </div>
                    <div class="m-2">
                        <label for="publisher">Publicador:</label>
                        <p class="border border-secondary p-1" id="publisher"> <?php echo htmlspecialchars($post->getPublisherName());?> </p>
                    </div>
                    <div class="m-2">
                        <label for="desc">Descripción:</label>
                        <p class="border border-secondary p-1" id="desc"> <?php echo htmlspecialchars($post->getDescription());?> </p>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: flex-start;">
                    <form action="">
                        <fieldset class="mb-3">
                            <legend>Motivo del reporte</legend>
                            <?php $i=0; ?>
                            <?php foreach ($reportTypes as $type): ?>
                                <?php $i++; ?>
                                <div class="form-check">
                                    <input type="radio" name="motive" class="form-check-input" value=<?php echo htmlspecialchars($type['id']);?> id="motive<?php echo htmlspecialchars($i);?>">
                                    <label class="form-check-label" for="motive<?php echo htmlspecialchars($i);?>"><?php echo htmlspecialchars($type['name']);?></label>
                                </div>
                            <?php endforeach; ?>
                        </fieldset>
                        <div class="form mb-3">
                            <label for="comment_<?php echo htmlspecialchars($post->getPostId()); ?>">Comentario:</label>
                            <input type="text" class="form-control" id="comment_<?php echo htmlspecialchars($post->getPostId()); ?>" name="comment_<?php echo htmlspecialchars($post->getPostId()); ?>">
                        </div>
                        <button type="button" class="submit-report btn btn-info" data-post-id="<?php echo htmlspecialchars($post->getPostId()); ?>" data-bs-dismiss="modal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>




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


<script src="/o_k_h/view/js/home.js"></script>

