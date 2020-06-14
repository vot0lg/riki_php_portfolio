<?php

namespace MyApp\Controller;

class Show extends \MyApp\Controller {

  private $_postModel;

  public function run() {
    if(!$this->isLoggedIn()) {
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      header('Location: newPost.php' );
      exit;
    }
    
    $this->setThisPost($_GET['id']);
    $this->_postModel = new \MyApp\Model\Post();
    
    $replys = $this->_postModel->findReplys($_GET['id']);
    $this->setValues('replys', $replys);
    // var_dump($this->values->replys);
    // $this->findRes();
    
    
  }
  //返信に対する返信なども表示したかったが、そうするためにはテーブル木構造をとる必要がある。
  // private function findRes() {
  //   // var_dump($this->values->replys);
  //   foreach($this->values->replys as $replys) {
  //     $replysOfReplys = $this->_postModel->findReplys($replys->id);
  //     $this->setValues('replysOfReplys', $replysOfReplys);
  //     foreach($this->values->replysOfReplys as $post) {
  //       var_dump($post->user_id);
  //       if($post->user_id === $this->thisPost['user_id']) {
  //         echo '一致しました';
  //         echo $post->id . '番の投稿が' . $replys->id . 'に対する私の返信です';
  //       }
  //     }
  //   }
  // }  
    // private function _postProcess() {
    //   $this->_postModel = new \MyApp\Model\Post();
    //   //成功したか //hiddenでやっておけば簡単だった
    //   if($postModel->editPost($this->thisPost['id'], $_POST['message'])){
    //     header('Location: newPost.php');
    //   } 
    // }


  
}

