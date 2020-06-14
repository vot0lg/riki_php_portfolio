<?php

namespace MyApp\Controller;

class UserShow extends \MyApp\Controller {

  private $_relationModel;

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      header('Location: newPost.php' );
      exit;
    }
    
    $postModel = new \MyApp\Model\Post(); 
    $posts = $postModel->postsThisUser($_GET['id']);
    $this->setPosts($posts);
    $userModel = new \MyApp\Model\User(); 
    $user = $userModel->findUser($_GET['id']);
    $this->setValues('user', $user);
    $this->_relationModel = new \MyApp\Model\Relation();
  }
  public function isFollowed($follow_id) {
    $res = $this->_relationModel->isFollowed($follow_id, $_SESSION['me']->id);
    return $res;
  }

  public function returnId($id){
    var_dump($id);
  }


}
