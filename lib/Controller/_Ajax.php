<?php

namespace MyApp\Controller;

class _Ajax extends \MyApp\Controller {

  public function run() {
    if(!empty($_POST['follow_id'])) {
      return $this->_followProcess($_POST['follow_id']);
    } elseif (!empty($_POST['like_id'])) {
      return $this->_likeProcess($_POST['like_id']);
    }
  }
  
  private function _followProcess($id) {
    $relationModel = new \MyApp\Model\Relation();
    $res = $relationModel->isFollowed($id, $_SESSION['me']->id);
    if($res) {
      $action = '解除';
      $sql = "DELETE FROM relation WHERE follow_id=? AND follower_id=?";
    } else {
      $action = '登録';
      $sql = "INSERT INTO relation SET follow_id=?, follower_id=?, created=now()";
    }
    $relationModel->followAction($sql, $id, $_SESSION['me']->id);
    $count = $relationModel->followerCount($id);
    $ranking = $relationModel->ranking($id);
    return array(
      "action" => $action,
      "count" => $count,
      "ranking" => $ranking
    );
  }

  private function _likeProcess($id) {
    $likeModel = new \MyApp\Model\Like();
    $res = $likeModel->isLiked($id, $_SESSION['me']->id);
    if($res) {
      $action = '解除';
      $sql = "DELETE FROM likes WHERE post_id=? AND user_id=?";
    } else {
      $action = '登録';
      $sql = "INSERT INTO likes SET post_id=?, user_id=?, created=now()";
    }
    $likeModel->likeAction($sql, $id, $_SESSION['me']->id);
    $count = $likeModel->likeCount($id);
    return array(
      "action" => $action,
      "count" => $count
    );

  }

  

}