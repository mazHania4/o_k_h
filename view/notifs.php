<?php
    include_once "model/post.php";
    include_once "model/notification.php";
    include "ctrl/notifs.php";
    $notifs_ctrl = new Notifs_ctrl();   
    $notifs = $notifs_ctrl->getNotifs();

?>

<div class="container" style="margin-right:200px;">
    
    <?php foreach ($notifs as $notif): ?>
        <div class="m-3 p-2 rounded shadow-lg bg-body-tertiary">
            <div class="m-3">
                <h4><?php echo htmlspecialchars($notif->getTitle()); ?></h4>
                <p class="text-body-secondary"><?php echo htmlspecialchars($notif->getType()); ?></p>
                <p><?php echo htmlspecialchars($notif->getDescription()); ?></p>
            </div>
            <hr>
            <?php $post = $notifs_ctrl->getPost($notif->getPostId()); ?>
            <div class="card mx-5 my-2 text-bg-dark border-light">
                <div class="card-header text-bg-dark border-light">
                    <div class="row container py-2">
                        <div class="col-11 align-self-start">
                            <h4 class="mb-0"><?php echo htmlspecialchars($post->getTitle()); ?></h4>
                        </div>
                    </div>
                </div>
    
                <div class="card-body">
                    <p class="event-meta">
                        <h5 class="card-title">
                            <i class="fa-regular fa-circle-user user-icon"></i>
                            <?php echo htmlspecialchars($post->getPublisherName()); ?>
                        </h5>
                    </p>
                    <p class="card-text">
                        <?php echo htmlspecialchars($post->getDescription()); ?>
                    </p>
                    <p class="event-meta text-bg-dark">
                        <i class="fa-regular fa-calendar-days user-icon"></i>Inicio: <?php echo htmlspecialchars($post->getStart_date());?> <?php echo htmlspecialchars($post->getStart_time());?><br>
                        <i class="fa-regular fa-calendar-days user-icon"></i>Fin: <?php echo htmlspecialchars($post->getEnd_date());?> <?php echo htmlspecialchars($post->getEnd_time());?><br>
                        <i class="fa-solid fa-location-dot user-icon"></i></i>Ubicación: <?php echo htmlspecialchars($post->getLocation());?>
                    </p>
                    <p class="event-meta text-bg-dark">
                        <i class="fa-solid fa-users-between-lines user-icon"></i> Capacidad: <?php echo htmlspecialchars($post->getCapacity()); ?> <br>
                        <i class="fa-regular fa-circle-check user-icon"></i> 
                        Asistencias confirmadas:  <span id="attendance-count-<?php echo htmlspecialchars($post->getPostId()); ?>"><?php echo htmlspecialchars($post->getAttendances()); ?> </span>
                    </p>
                    <a href="<?php echo htmlspecialchars($post->getUrl());?>" class="card-link">Más información</a>
                    <?php $categories = $notifs_ctrl->getCategories($post->getPostId());?>
                    <div class="badges-container mt-3">
                        <?php foreach ($categories as $cat): ?>
                            <span class="badge bg-warning"><?php echo htmlspecialchars($cat['name']);?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php $audiences = $notifs_ctrl->getAudiences($post->getPostId());?>
                    <div class="badges-container mt-3">
                        <?php foreach ($audiences as $aud): ?>
                            <span class="badge bg-info"><?php echo htmlspecialchars($aud['name']);?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="m-3">
                <!-- Validar_post_admin -->
                <?php if ($notif->getType_id() == 1): ?>
                    <form action="/o_k_h/ctrl/admin/approve_post.php" method="POST">
                        <input type="hidden" name="post_id" id="post_id" value="<?php echo htmlspecialchars($post->getPostId());?>">
                        <input type="hidden" name="not_id" id="not_id" value="<?php echo htmlspecialchars($notif->getNotificationId());?>">
                        <input type="hidden" name="approved" id="approved" value="true">
                        <button type="submit" class="btn btn-info btn-lg">Aprobar</button>
                    </form>
                    <form action="/o_k_h/ctrl/admin/approve_post.php" method="POST">
                        <input type="hidden" name="post_id" id="post_id" value="<?php echo htmlspecialchars($post->getPostId());?>">
                        <input type="hidden" name="not_id" id="not_id" value="<?php echo htmlspecialchars($notif->getNotificationId());?>">
                        <input type="hidden" name="approved" id="approved" value="false">
                        <button type="submit" class="btn btn-secondary btn-lg">Denegar</button>
                    </form>
                <?php endif; ?>
                <!-- Reporte_admin -->
                <?php if ($notif->getType_id() == 2): ?>
                    <button type="button" class="btn btn-info btn-lg">Aprobar</button>
                    <button type="button" class="btn btn-secondary btn-lg">Denegar</button>  
                <?php endif; ?>
                <!-- Asistencia -->
                <?php if ($notif->getType_id() == 4): ?>
                    <p><strong>Tiempo restante para el evento:</strong> <span id="countdown<?php echo $notif->getNotificationId();?>"></span></p>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var eventDate = "<?php echo $post->getStart_date(); ?>";  //  YYYY-MM-DD
                            var eventTime = "<?php echo $post->getStart_time(); ?>";  //  HH:MM:SS

                            var countDownDate = new Date(eventDate + ' ' + eventTime).getTime();

                            var x = setInterval(function () {
                                var now = new Date().getTime();                                
                                var distance = countDownDate - now;

                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                
                                document.getElementById("countdown<?php echo $notif->getNotificationId();?>").innerHTML = days + "d " + hours + "h " +
                                    minutes + "m " + seconds + "s ";
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("countdown<?php echo $notif->getNotificationId();?>").innerHTML = "¡El evento ha comenzado!";
                                }
                            }, 1000);
                        });
                    </script>
                <?php endif; ?>
            </div>
        
        </div>
    <?php endforeach; ?>
</div>