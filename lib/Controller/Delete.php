<?php

namespace MyApp\Controller;

require_once(__DIR__ . '/../../config/config.php');

if(isset($_GET['id'])) {

  $postModel = new \MyApp\Model\Post();
  $user_id = $postModel->whoPost($_GET['id']);
  // var_dump($user_id);

  if($_SESSION['me']->id !== $user_id ){
    echo 'この投稿は削除できません';
    exit;
  } else {
    if($postModel->delete($_GET['id'])) {
      header('Location:' . SITE_URL . '/newPost.php');
    }
  }
} else {
  header('Location: newPost.php' );
  exit;
}
