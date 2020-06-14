<?php

namespace MyApp\Controller;

class UserDelete extends \MyApp\Controller{

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/signup.php');
      exit;
    }
    // var_dump($_SESSION);
    if(isset($_POST['token'])) {
      $this->postProcess();
    }
  }

  private function postProcess() {
    if($_SESSION['token'] !== $_POST['token']){
      echo '権限がありません';
      exit;
    } else {
      $userModel = new \MyApp\Model\User();
      if($userModel->userDelete($_SESSION['me']->id)) {
        $this->_deleteSession();
        header('Location: /public_html/signup.php');
      }
    }
  }

  private function _deleteSession() {
    $_SESSION = array();
    // var_dump($_SESSION);
    if(ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      // var_dump($params);
      setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
      );
    }
    session_destroy();
  }

}
