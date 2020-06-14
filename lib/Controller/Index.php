<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  private $userModel;
  private $_relationModel;

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    $this->userModel = new \MyApp\Model\User();
    $users = $this->userModel->followerRanking();
    $this->setValues('users', $users);
    // var_dump($users);
    $this->_relationModel = new \MyApp\Model\Relation();

    if(!empty($_POST['follow_id'])) {
      $this->_relationModel->follow($_POST['follow_id'],$_SESSION['me']->id);
      header('Location: index.php');
      exit;
    }
  }
  public function isFollowed($follow_id) {
    $res = $this->_relationModel->isFollowed($follow_id, $_SESSION['me']->id);
    return $res;
  }
  

  public function returnId($id){
    var_dump($id);
  }

  public function followerCount($id){
    return $this->_relationModel->followerCount($id);
  }

  public function whoChampion($id){
    $rank = $this->_relationModel->ranking($id);
    switch($rank){
      case 1:
        $class = 'fa-gold';
        break;
      case 2:
        $class = 'fa-silver';
        break;
      case 3:
        $class = 'fa-bronze';
        break;
      default:
        $class = 'none';
    }
    return $class;
  }

  
}

