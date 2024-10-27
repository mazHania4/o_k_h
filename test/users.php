<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../model/user.php';
include '../svc/users.php';

class TestUsersSvc {
    private $usersSvc;

    public function __construct() {
        $this->usersSvc = new Users_svc();
    }

    public function testRegisterAttendance() {
        echo "Testing registerAttendance()...<br>";
        $userId = 9; 
        $postId = 19; 
        $this->usersSvc->registerAttendance($userId, $postId);
        $attendance = $this->usersSvc->getAttendances($postId);
        echo "Post ID: $postId, Attendance Count: " . $attendance['attendances'] . "<br><br>";
    }

    public function testValidateLogin() {
        echo "Testing validateLogin()...<br>";
        $username = 'svillea'; 
        $password = 'Asia86'; 
        $user = $this->usersSvc->validateLogin($username, $password);
        echo $user ? "Login Successful: User ID " . $user->getUserId() . "<br><br>" : "Login Failed<br><br>";
    }

    public function testCreateUser() {
        echo "Testing createUser()...<br>";
        $name = "Test User";
        $username = "newuser";
        $email = "newuser@example.com";
        $password = "password123";
        $user = $this->usersSvc->createUser($name, $username, $email, $password);
        echo $user ? "User Created: " . $user->getUserId() . "<br><br>" : "Failed to Create User<br><br>";
    }

    public function testBecomePublisher() {
        echo "Testing becomePublisher()...<br>";
        $userId = 9; // revisar id de usuario no publicador
        $result = $this->usersSvc->becomePublisher($userId);
        echo $result ? "User $userId is now a publisher.<br><br>" : "Failed to make user $userId a publisher.<br><br>";
    }

    public function runTests() {
        $this->testRegisterAttendance();
        $this->testValidateLogin();
        $this->testCreateUser();
        $this->testBecomePublisher();
    }
}

$test = new TestUsersSvc();
$test->runTests();

?>
