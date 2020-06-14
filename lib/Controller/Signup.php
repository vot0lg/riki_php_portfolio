<?php
 
namespace MyApp\Controller;

class Signup extends \MyApp\Controller {
  private $_image;

  public function run() {
    if($this->isLoggedIn()) {
      header('Location:' . SITE_URL);
      exit;
    }
    // var_dump($_SESSION);
    if(isset($_SESSION['success'])) {
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
      $this->setValues('delete', $success);
    }

    if(!empty($_POST)) {
      $this->_postProcess();
    }
  }

  private function _postProcess() {
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('all', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\MyApp\Exception\TooShortPassword $e) {
      $this->setErrors('password', $e->getMessage());   
    } catch (\MyApp\Exception\InvalidFileType $e) {
      $this->setErrors('image', $e->getMessage());
    }

    $this->setValues('name', $_POST['name']);
    $this->setValues('email', $_POST['email']);

    if (!$this->hasError()) {
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'name' => $_POST['name'],
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'picture' => $this->_image
          ]);
          //問題なし
          $_SESSION['success'] = 'アカウントが作成されました。ログインしてください'; 
          header('Location:' . SITE_URL . '/login.php');
          exit;
        } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    }
  }

  private function _validate() {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
      throw new \MyApp\Exception\EmptyPost();
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    if(!preg_match('/\A[a-zA-Z1-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
    if(strlen($_POST['password']) < 6) {
      echo 'エラー';
      throw new \MyApp\Exception\TooShortPassword();
    }
    $this->_imageProcess();

  }
  private function _imageProcess() {
    //$_FILESは空でも値のない連想配列として送られるから、array_filter()で値のない要素を削除すればempty()で判定できる　<-  これやっぱ嘘。ファイルを選択しないとerrorキーに値がセットされるのでだめ。
    // $file = array_filter($_FILES['image']);
    // if(!empty($file)) {

      $ext = $this->_validateImage();
      $this->_fileUpload($ext);
    }
    
    private function _validateImage() {
      if(!empty($_FILES['image']['name'])) {
        $ext = substr($_FILES['image']['name'], -3);
        if ($ext !== 'gif' && $ext !== 'png' && $ext !== 'jpg') {
          throw new \MyApp\Exception\InvalidFileType();
          return;
        } else {
          return $ext;
        }
      }
      return $ext = '';
    }
    private function _fileUpload($ext) {
      if(!empty($_FILES['image']['name'])) {
      $this->_image = sprintf(
        '%s_%s.%s' ,
        time(),
        sha1(uniqid(mt_rand(),true)),
        $ext
      );
    } else {
      $this->_image = 'default.jpg';
    }
    $savePath = '../userPictures';
    move_uploaded_file($_FILES['image']['tmp_name'], $savePath . '/' .$this->_image);
    
  }

}

