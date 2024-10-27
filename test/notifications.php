<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../svc/notifs.php';
include '../model/notification.php';

class TestNotifSvc {
    private $notifSvc;

    public function __construct() {
        $this->notifSvc = new Notif_svc();
    }

    public function testGetNotifications() {
        echo "Testing getNotifications()...<br>";
        $userId = 1; // Cambiar ID
        $notifications = $this->notifSvc->getNotifications($userId);
        
        if (count($notifications) > 0) {
            foreach ($notifications as $notification) {
                echo "Notification ID: " . $notification->notification_id . "<br>";
                echo "Type: " . $notification->type . "<br>";
                echo "Description: " . $notification->description . "<br>";
                echo "State: " . $notification->state . "<br><br>";
            }
        } else {
            echo "No active notifications found for user $userId.<br><br>";
        }
    }

    public function testDismiss() {
        echo "Testing dismiss()...<br>";
        $notifId = 4; // Cambia ID
        $this->notifSvc->dismiss($notifId);
        echo "Notification ID $notifId has been dismissed.<br><br>";
    }

    public function runTests() {
        $this->testGetNotifications();
        $this->testDismiss();
    }
}

$test = new TestNotifSvc();
$test->runTests();

?>
