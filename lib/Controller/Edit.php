<?php

namespace MyApp\Controller;

class Edit extends \MyApp\Controller {

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }
    if(!isset($_GET['id'])) {
      header('Location: newPost.php' );
      exit;
    }
    
    $this->setThisPost($_GET['id']);
    // var_dump($_SESSION['me']->id);
    // var_dump($this->thisPost['user_id']);
    if($_SESSION['me']->id !== $this->thisPost['user_id']) {
      echo 'この投稿は編集できません';
      exit;
    }

    
    if(!empty($_POST)) {
      $this->_postProcess();
    }
  }
  
  private function _postProcess() {
    $postModel = new \MyApp\Model\Post();
    //成功したか //hiddenでやっておけば簡単だった
    if($postModel->editPost($this->thisPost['id'], $_POST['message'])){
      header('Location: newPost.php');
    } 
  }
}