<?php

class Post
{

    private $post_id;
    private $publisher_id;
    private $publisher_name;
    private $title;
    private $start_date;
    private $start_time;
    private $end_date;
    private $end_time;
    private $capacity;
    private $attendances;
    private $reports;
    private $location;
    private $description;
    private $url;

    public function __construct() {   }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getPublisherId()
    {
        return $this->publisher_id;
    }

    public function getPublisherName()
    {
        return $this->publisher_name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getStart_date()
    {
        return $this->start_date;
    }

    public function getStart_time()
    {
        return $this->start_time;
    }

    public function getEnd_date()
    {
        return $this->end_date;
    }

    public function getEnd_time()
    {
        return $this->end_time;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getAttendances()
    {
        return $this->attendances;
    }

    public function getReports()
    {
        return $this->reports;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
    }

    public function setPublisherId($publisher_id): void
    {
        $this->publisher_id = $publisher_id;
    }

    public function setPublisherName($publisher_name): void
    {
        $this->publisher_name = $publisher_name;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setStart_date($start_date): void
    {
        $this->start_date = $start_date;
    }

    public function setStart_time($start_time): void
    {
        $this->start_time = $start_time;
    }

    public function setEnd_date($end_date): void
    {
        $this->end_date = $end_date;
    }

    public function setEnd_time($end_time): void
    {
        $this->end_time = $end_time;
    }

    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function setAttendances($attendances): void
    {
        $this->attendances = $attendances;
    }

    public function setReports($reports): void
    {
        $this->reports = $reports;
    }

    public function setLocation($location): void
    {
        $this->location = $location;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }
}
