<?php
 
namespace MyApp\Controller;

class Login extends \MyApp\Controller {

  public function run() {
    if($this->isLoggedIn()) {
      header('Location:' . SITE_URL);
      exit;
    }

    if(!empty($_SESSION['success'])) {
      $success = $_SESSION['success'];
      // var_dump($success);
      // exit;
      unset($_SESSION['success']);
      $this->setValues('success', $success);
    }

    if(!empty($_POST)) {
    $this->_postProcess();
    }
  }

  private function _postProcess() {
    try {
      $this->_validate();
      $userModel = new \MyApp\Model\User();
      $user = $userModel->login($_POST['email'], $_POST['password']);
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    } catch (\MyApp\Exception\UnmatchedEmail $e) {
      $this->setErrors('login', $e->getMessage());
    } catch (\MyApp\Exception\UnmatchedPassword $e) {
      $this->setErrors('login', $e->getMessage());
    }

    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    }
    //問題なし
    $_SESSION['me'] = $user;
    $_SESSION['time'] = time();
    if(isset($_SESSION['me'])){
    }
    header('Location:' . SITE_URL);
    exit;
  }

  private function _validate() {
    if(empty($_POST['email']) || empty($_POST['password'])) {
      throw new \MyApp\Exception\EmptyPost();
      exit;
    }
  }

}
