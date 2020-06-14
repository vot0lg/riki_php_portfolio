<?php

namespace MyApp;

class Controller {

  private $_errors;
  protected $values;
  private $_posts;
  protected $thisPost;
  private $_user;
  private $_image;

  public function __construct() {
    $this->_errors = new \stdClass();
    $this->values = new \stdClass();
    $this->_posts = new \stdClass();
    if(!isset($_SESSION['token'])) {
      $_SESSION += array('token' => bin2hex(openssl_random_pseudo_bytes(16)));
    }
  }

  protected function isLoggedIn() {
    if(!empty($_SESSION['me']) && $_SESSION['time'] + 3600 > time()) {
      $_SESSION['time'] = time();
      return true;
    } else {
      return false;
    }
  }
  protected function setPosts($posts) {
    $this->_posts = $posts;
  }
  public function getPosts() {
    return isset($this->_posts) ? $this->_posts : '' ;
  }
  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }
  public function getErrors($key) {
    return isset($this->_errors->$key) ? $this->_errors->$key : '' ;
  }
  protected function setValues($key, $value) {
    $this->values->$key = $value;
  }
  public function getValues($key) {
    return isset($this->values->$key) ? $this->values->$key : '' ;
  }
  protected function hasError() {
    return !empty(get_object_vars($this->_errors));
  }

  public function getThisPost() {
    return $this->thisPost;
  }
  protected function setThisPost($post) {
    $postModel = new \MyApp\Model\Post();
    $postData =  $postModel->getPost($post);
    $this->thisPost = $postData;
    // var_dump($this->thisPost);
  }

  public function thumbOrImage($image) {
    if(file_exists('../postThumbnails/' . $image)){
      return 'postThumbnails/' . $image;
    } else {
      return 'postImages/' . $image;
    }
  }


}
