<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../svc/reports.php';

class TestReportsSvc {

    private $reportsSvc;

    public function __construct() {
        $this->reportsSvc = new Reports_svc();
    }

    public function testGetReportTypes() {
        echo "Testing getReportTypes()...<br>";
        $types = $this->reportsSvc->getReportTypes();
        
        if (count($types) > 0) {
            foreach ($types as $type) {
                echo "Report Type ID: " . $type['id'] . "<br>";
                echo "Name: " . $type['name'] . "<br><br>";
            }
        } else {
            echo "No report types found.<br><br>";
        }
    }

    public function testRegisterReport() {
        echo "Testing registerReport()...<br>";
        $user_id = 9;     // Cambiar ID 
        $postId = 1;      // Cambiar ID 
        $motiveId = 2;    // Cambiar ID 
        $comment = "Este es un comentario de prueba para el reporte.";

        $this->reportsSvc->registerReport($user_id, $postId, $motiveId, $comment);
        echo "Report has been registered successfully for Post ID $postId.<br><br>";
    }

    public function runTests() {
        $this->testGetReportTypes();
        $this->testRegisterReport();
    }
}

$test = new TestReportsSvc();
$test->runTests();

?>
