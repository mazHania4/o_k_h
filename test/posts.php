<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../svc/posts.php';
include '../model/post.php';

class TestPostsSvc {
    private $postsSvc;

    public function __construct() {
        $this->postsSvc = new Posts_svc();
    }

    public function testApprovePost() {
        echo "Testing approvePost()...<br>";
        $post_id = 10; // ID de un post 'pending'
        $this->postsSvc->approvePost($post_id);
        $post = $this->postsSvc->getPost($post_id);
        echo "Expected: active, Got: " . $post->getState() . "<br><br>";
    }

    public function testDisapprovePost() {
        echo "Testing disapprovePost()...<br>";
        $post_id = 13; // ID de un post 'pending'
        $this->postsSvc->disapprovePost($post_id);
        $post = $this->postsSvc->getPost($post_id);
        echo "Expected: banned, Got: " . $post->getState() . "<br><br>";
    }

    public function testGetPost() {
        echo "Testing getPost()...<br>";
        $post_id = 1;
        $post = $this->postsSvc->getPost($post_id);
        echo "Post ID: " . $post->getPostId() . ", Title: " . $post->getTitle() . ", Publisher: " . $post->getPublisherName() . "<br><br>";
    }

    public function testGetPosts() {
        echo "Testing getPosts()...<br>";
        $posts = $this->postsSvc->getPosts();
        foreach ($posts as $post) {
            echo "Post ID: " . $post->getPostId() . ", Title: " . $post->getTitle() . "<br>";
        }
        echo "<br>";
    }

    public function testInsertPost() {
        echo "Testing insertPost()...<br>";
        // Crea un objeto Post con los detalles necesarios
        $post = new Post();
        $post->setPublisherId(4);
        $post->setTitle("Test Post");
        $post->setStart_date("2024-12-25");
        $post->setStart_time("18:00:00");
        $post->setEnd_date("2024-12-25");
        $post->setEnd_time("20:00:00");
        $post->setCapacity(50);
        $post->setLocation("Test Location");
        $post->setDescription("Test Description");
        $post->setUrl("http://example.com");

        $result = $this->postsSvc->insertPost($post);
        echo "Insert Post Result: " . ($result ? "Success" : "Failed") . "<br><br>";
    }

    public function runTests() {
        $this->testApprovePost();
        $this->testDisapprovePost();
        $this->testGetPost();
        $this->testGetPosts();
        $this->testInsertPost();
    }
}

$test = new TestPostsSvc();
$test->runTests();

?>
