<?php
    include_once "model/post.php";
    include "ctrl/home.php";
    $home_ctrl = new Home_ctrl();
    $posts = $home_ctrl->getPosts();    

?>

<div class="container">
    <?php foreach ($posts as $post): ?>
        <div class="card text-bg-dark border-light">
            <div class="card-header text-bg-dark border-light">
                <h4 class="mb-0"><?php echo htmlspecialchars($post->getTitle()); ?></h4>
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
                        <button class="btn btn-success">Registrar Asistencia</button>
                    <?php endif; ?>

                </div>
            </div>

        </div>
        
    
    <?php endforeach; ?>
</div>

<script src="/o_k_h/view/js/home.js"></script>

