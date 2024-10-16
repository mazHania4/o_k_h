<?php
class User {

    private $user_id;
    private $name;
    private $username;
    private $email;
    private $password;
    private $type;
    private $state;

    public function __construct() {   }

    public function getUserId() {return $this->user_id;}

	public function getName() {return $this->name;}

	public function getUsername() {return $this->username;}

	public function getEmail() {return $this->email;}

	public function getPassword() {return $this->password;}

	public function getType() {return $this->type;}

	public function getState() {return $this->state;}

    public function setUserId($user_id): void {$this->user_id = $user_id;}

	public function setName($name): void {$this->name = $name;}

	public function setUsername($username): void {$this->username = $username;}

	public function setEmail($email): void {$this->email = $email;}

	public function setPassword($password): void {$this->password = $password;}

	public function setType($type): void {$this->type = $type;}

	public function setState($state): void {$this->state = $state;}

}
?>