<?php

class Notification {
    private $notification_id;
    private $user_id;
    private $post_id;
    private $title;
    private $type_id;
    private $type;
    private $description;
    private $date;
    private $state;

    public function getNotificationId() {return $this->notification_id;}

	public function getUserId() {return $this->user_id;}

	public function getPostId() {return $this->post_id;}

	public function getTitle() {return $this->title;}

	public function getType() {return $this->type;}

	public function getType_id() {return $this->type_id;}

	public function getDescription() {return $this->description;}

	public function getDate() {return $this->date;}

	public function getState() {return $this->state;}

	public function setNotificationId( $notification_id): void {$this->notification_id = $notification_id;}

	public function setUserId( $user_id): void {$this->user_id = $user_id;}

	public function setPostId( $post_id): void {$this->post_id = $post_id;}

	public function setTitle( $title): void {$this->title = $title;}

	public function setType( $type): void {$this->type = $type;}

    public function setType_id( $type_id): void {$this->type_id = $type_id;}

	public function setDescription( $description): void {$this->description = $description;}

	public function setDate( $date): void {$this->date = $date;}

	public function setState( $state): void {$this->state = $state;}

	
}

?>

En la carpeta raíz está la capeta /scripts en la que voy a guardar los arciovos de configuración inicial, ahí coloqué el codigo javascript que escribiste en el archivo init_db.js, necesito que en la misma carpeta escribas un script en el que iré colocando todos los comandos para las configuraciones extras que se harán a los contenedores de docker después de levantarlos, el primer comando que necesito que agregues es el que usa el script init_db.js para inicializar la base de datos en el contenedor de mongo