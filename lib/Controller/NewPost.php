<?php 

namespace MyApp\Controller;

class NewPost extends \MyApp\Controller {
  private $_imgeType;
  private $_imageName;
  private $_likeModel;

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    if($this->isReply()) {
      // var_dump($_GET['res']);
      $this->replyProcess();
    }

    $userModel = new \MyApp\Model\User();
    $users = $userModel->findUsers();
    $this->setValues('users', $users);

    $postModel = new \MyApp\Model\Post();
    $this->_likeModel = new \MyApp\Model\Like();
    
    if(!empty($_POST)) {
      try {
        $this->_upload();
        
      } catch (\Exception $e) {
        $this->setErrors('post', $e->getMessage());
      }
      
      if(!$this->hasError()) {
        $postModel->newPost($_POST['message'], $this->_imageName, $_POST['reply_message_id'], $_SESSION['me']->id);
        header('Location: newPost.php');
      }
    }
    $AllPosts = $postModel->findAllPosts();
    $this->setPosts($AllPosts);
  }

  public function isReply() {
    if(isset($_GET['res']) && $_GET['res'] !== "" && is_numeric($_GET['res'])){
      return true;
    }
  }

  public function replyProcess() {
    $this->setThisPost($_GET['res']);
  }

  private function _upload() {
    // var_dump($_POST['token']);
    if(!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
      echo "権限がありません";
      exit;
    }

    if (empty($_POST['message']) && empty($_FILES['image']['name'])) {
      throw new \Exception('メッセージを入力してください');
    } elseif (!empty($_FILES['image']['name'])) {
      $this->_validateUpload();
      $ext = $this->_validateImageType();
      $savePath = $this->_save($ext);
      $this->_createThumbnail($savePath);
    } else {
      $this->_imageName = '';
    }
  }
  
  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    if($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch ($this->_imageType) {
      //ソース画像の作成
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
      }
      // var_dump();
      // exit;
      $thumbHeight = THUMBNAIL_WIDTH * $height / $width;
      // 指定した大きさの黒い画像を表す画像 ID を返します。
      $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
      // 再サンプリングを行いイメージの一部をコピー、伸縮する
      imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

      switch ($this->_imageType) {
        case IMAGETYPE_GIF:
          imagegif($thumbImage, '../postThumbnails/' . $this->_imageName);
          break;
        case IMAGETYPE_JPEG:
          imagejpeg($thumbImage, '../postThumbnails/' . $this->_imageName);
          break;
        case IMAGETYPE_PNG:
          imagepng($thumbImage, '../postThumbnails/' . $this->_imageName);
        break;
        }

  }

  
  private function _save($ext) {
    $this->_imageName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(),true)),
      $ext
    );
    $savePath = '../postImages/' . $this->_imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    return $savePath;
  }

  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch ($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
      throw new \Exception('PNG,GIF,JPG形式の画像を選択してください');
    }
  }
  
  private function _validateUpload() {

    if(!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }
    switch ($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('ファイルサイズが大きすぎます');
      default:
        throw new \Exception('不明なエラー' . $_FILES['image']['error']);
    }
  }

  public function isLiked($post_id) {
    return $this->_likeModel->isLiked($post_id, $_SESSION['me']->id);
  }

  public function likeCount($post_id) {
    return $this->_likeModel->likeCount($post_id);
    // var_dump($post_id);
  }


}
