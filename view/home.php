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


<?php include 'view/publisher/new_post.php';?>


<script src="/o_k_h/view/js/home.js"></script>