<?php 

namespace MyApp\Controller;

class Timeline extends \MyApp\Controller {
  private $_imgeType;
  private $_imageName;

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    $userModel = new \MyApp\Model\User();
    $users = $userModel->findUsers();
    $this->setValues('users', $users);

    $postModel = new \MyApp\Model\Post();
    $relationModel = new \MyApp\Model\Relation();
    
    $followedUsers = $relationModel->followedUsers($_SESSION['me']->id);
    // var_dump($followedUsers);
    // exit;
    $postsByFollowedUsers = $postModel->postsByFollowedUsers($followedUsers);
    $this->setPosts($postsByFollowedUsers);
  }


}


